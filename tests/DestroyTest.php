<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class DestroyTest
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class DestroyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generate_not_found_error_if_the_record_does_not_exist()
    {
        $randomId = $this->getRandomId();

        $response = $this->destroySurl($randomId);

        $response->assertNotFound();
    }

    /** @test */
    public function an_exist_record_can_be_destroyed()
    {
        $createResponse = $this->createSurl([ 'url' => 'https://laravel.com' ],true);

        $response = $this->destroySurl($createResponse['id']);

        $response->assertStatus(204);
    }

    /** @test */
    public function it_must_redirect_to_list_route_after_destroyed()
    {
        $createResponse = $this->createSurl([ 'url' => 'https://laravel.com' ],true);
        $response = $this->destroySurl($createResponse['id'],true);

        $response
            ->assertStatus(302)
            ->assertHeader('Location',route('surl.list'))
            ->assertSessionHasNoErrors();
    }
}
