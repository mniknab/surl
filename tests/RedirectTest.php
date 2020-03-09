<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mniknab\Surl\Models\SurlModel;

/**
 * Class RedirectTest
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class RedirectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generate_not_found_error_if_the_identifier_doest_not_exist()
    {
        $response = $this->redirectSurl('laravel');

        $response->assertNotFound();
    }

    /** @test */
    public function it_redirect_to_the_correct_long_url()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'laravel'
        ];

        $this->createSurl($parameters);

        $response = $this->redirectSurl($parameters['identifier']);

        $response
            ->assertStatus(302)
            ->assertHeader('Location',$parameters['url']);
    }

    /** @test */
    public function an_url_could_expire()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'laravel',
            'expires_at' => Carbon::now()->addHour()
        ];

        $this->createSurl($parameters);

        Carbon::setTestNow(Carbon::now()->addHours(2));

        $response = $this->redirectSurl($parameters['identifier']);

        $response->assertStatus(410);
    }

    /** @test */
    public function it_redirect_to_the_correct_long_url_when_expiration_date_in_future()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'laravel',
            'expires_at' => Carbon::now()->addHour()
        ];

        $this->createSurl($parameters);

        $response = $this->redirectSurl($parameters['identifier']);

        $response
            ->assertStatus(302)
            ->assertHeader('Location',$parameters['url']);
    }

    /** @test */
    public function it_redirects_to_the_correct_url_after_update()
    {
        $createResponse = $this->createSurl([ 'url' => 'https://laravel.com' ],true);

        $parameters = [
            'url' => 'https://github.com',
            'identifier' => 'github'
        ];

        $this->updateSurl($createResponse['id'],$parameters);

        $response = $this->redirectSurl($parameters['identifier']);

        $response
            ->assertStatus(302)
            ->assertHeader('Location',$parameters['url']);
    }

    /** @test */
    public function the_cache_is_cleared_after_an_update()
    {

        $createParameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'identifier',
        ];

        $updateParameters = [
            'url' => 'https://github.com',
            'identifier' => 'identifier',
        ];

        $createResponse = $this->createSurl($createParameters,true);

        $impressionResponse = $this->redirectSurl($createParameters['identifier']);
        $impressionResponse
            ->assertStatus(302)
            ->assertHeader('Location',$createParameters['url']);

        $updateResponse = $this->updateSurl($createResponse['id'], $updateParameters);
        $updateResponse
            ->assertStatus(200)
            ->assertJson([
                'id' => $createResponse['id'],
                "identifier" => $createParameters['identifier'],
                "url" => $updateParameters['url'],
            ]);

        $impressionResponse = $this->redirectSurl($createParameters['identifier']);
        $impressionResponse
            ->assertStatus(302)
            ->assertHeader('Location',$updateParameters['url']);

    }

    /** @test */
    public function the_cache_is_cleared_after_an_destroy()
    {
        $createParameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'identifier',
        ];

        $createResponse = $this->createSurl($createParameters,true);

        $impressionResponse = $this->redirectSurl($createParameters['identifier']);
        $impressionResponse
            ->assertStatus(302)
            ->assertHeader('Location',$createParameters['url']);

        $destroyResponse = $this->destroySurl($createResponse['id']);
        $destroyResponse->assertStatus(204);

        $impressionResponse = $this->redirectSurl($createParameters['identifier']);
        $impressionResponse->assertNotFound();;
    }

    /** @test
     * @param SurlContract $surl
     */
    public function it_increments_impression_counter_on_redirect()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'laravel'
        ];

        $createResponse = $this->createSurl($parameters,true);

        for ($counter = 1; $counter <=3; $counter++){
            $impressionResponse = $this->redirectSurl($parameters['identifier']);

            $impressionResponse
                ->assertStatus(302)
                ->assertHeader('Location',$parameters['url']);
        }

        $surlResponse = SurlModel::find($createResponse['id']);

        $this->assertEquals($surlResponse->impression_count, 3);
    }
}
