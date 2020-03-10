<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ReadTest
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class ReadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_return_empty_when_no_record_exists()
    {
        $response = $this->listSurl();
        $viewData = $response['list']->toArray();

        $response
            ->assertStatus(200)
            ->assertViewIs('surl::list');

        $this->assertEquals($viewData['total'],0);
    }


    /** @test */
    public function it_can_fetch_all_records()
    {
        $parameters = [
            'url' => 'https://laravel.com',
        ];

        for ($counter = 1; $counter <=3; $counter++){
            $this->createSurl($parameters);
        }

        $response = $this->listSurl();
        $viewData = $response['list']->toArray();

        $response
            ->assertStatus(200)
            ->assertViewIs('surl::list');

        $this->assertEquals($viewData['total'],3);
    }


    /** @test */
    public function number_of_items_per_page_must_be_equals_with_config()
    {
        $response = $this->listSurl();
        $itemsPerPage = config('surl.items_per_page');
        $viewData = $response['list']->toArray();

        $response
            ->assertStatus(200)
            ->assertViewIs('surl::list');

        $this->assertEquals($viewData['per_page'],$itemsPerPage);
    }
}
