<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UpdateTest
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generate_not_found_error_if_the_record_does_not_exist()
    {
        $randomId = $this->getRandomId();

        $response = $this->editSurl($randomId);

        $response->assertNotFound();
    }

    /** @test */
    public function it_generate_not_found_error_if_the_record_does_not_exist_for_update()
    {
        $parameters = [
            'url' => 'https://laravel.com',
        ];

        $randomId = $this->getRandomId();

        $response = $this->updateSurl($randomId, $parameters);

        $response->assertNotFound();
    }

    /** @test */
    public function an_exist_record_data_can_be_fetched_by_id()
    {
        $createResponse = $this->createSurl([ 'url' => 'https://laravel.com' ],true);

        $response = $this->editSurl($createResponse['id']);

        $response
            ->assertStatus(200)
            ->assertViewIs('surl::edit')
            ->assertViewHas('surl.url','https://laravel.com')
            ->assertViewHas('surl.id',$createResponse['id']);
    }

    /** @test */
    public function an_exist_record_can_be_updated()
    {
        $createResponse = $this->createSurl([ 'url' => 'https://laravel.com' ],true);

        $parameters = [
            'url' => 'https://github.com',
            'identifier' => 'github',
            'title' => 'Github',
            'description' => 'Github official website',
        ];

        $response = $this->updateSurl($createResponse['id'],$parameters);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $createResponse['id'],
                "identifier" => $parameters['identifier'],
                "title" => $parameters['title'],
                "description" => $parameters['description'],
                "url" => $parameters['url'],
                "short_url" => $this->getShortUrl($parameters['identifier'])
            ]);
    }


    /** @test */
    public function it_must_redirect_to_list_route_after_updated()
    {
        $createResponse = $this->createSurl([ 'url' => 'https://laravel.com' ],true);

        $parameters = [
            'url' => 'https://github.com',
            'identifier' => 'github',
        ];

        $response = $this->updateSurl($createResponse['id'],$parameters,true);

        $response
            ->assertStatus(302)
            ->assertHeader('Location',route('surl.list'))
            ->assertSessionHasNoErrors();
    }

}
