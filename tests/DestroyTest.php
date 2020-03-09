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
    public function an_exist_record_can_be_deleted()
    {
        $createResponse = $this->createSurl([ 'url' => 'https://laravel.com' ],true);

        $response = $this->destroySurl($createResponse['id']);

        $response->assertStatus(204);
    }
}
