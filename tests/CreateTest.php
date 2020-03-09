<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CreateTest
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_shorten_an_url()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'laravel'
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(201)
            ->assertJson([
                'identifier' => $parameters['identifier'],
                'short_url' => $this->getShortUrl($parameters['identifier'])
            ]);

    }

    /** @test */
    public function an_url_must_be_valid_on_create()
    {
        $parameters = [
            'url' => 'invalid-url',
            'identifier' => 'invalid'
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('url');
    }

    /** @test */
    public function an_identifier_is_generated_if_let_it_empty()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => null
        ];

        $response = $this->createSurl($parameters);

        $response->assertStatus(201);
        $this->assertNotNull( $response->json('identifier') );
    }

    /** @test */
    public function an_identifier_is_lowered()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'LaRaVeL'
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(201)
            ->assertJson([
                'identifier' => strtolower($parameters['identifier']),
                'short_url' => $this->getShortUrl(strtolower($parameters['identifier']))
            ]);
    }

    /** @test */
    public function an_identifier_is_sanitized()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'larav\!el. surl'
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(201)
            ->assertJson([
                'identifier' => 'laravel-surl',
                'short_url' => route('surl.redirect', 'laravel-surl' )
            ]);
    }

    /** @test */
    public function an_identifier_is_smaller_than_256_characters()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => str_repeat('a', 256)
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('identifier');
    }

    /** @test */
    public function an_identifier_must_be_unique()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'identifier' => 'laravel'
        ];

        $this->createSurl($parameters);

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('identifier');
    }

    /** @test */
    public function impression_count_is_equals_to_zero_on_creation()
    {
        $parameters = [
            'url' => 'https://laravel.com',
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(201)
            ->assertJson([
                'impression_count' => 0
            ]);
    }

    /** @test */
    public function an_expiration_date_could_be_set()
    {
        $expires_at = Carbon::parse('tomorrow');

        $parameters = [
            'url' => 'https://laravel.com',
            'expires_at' => $expires_at
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(201)
            ->assertJson([
                'expires_at' => $expires_at->toDateString()
            ]);
    }

    /** @test */
    public function an_expiration_date_is_optional()
    {
        $parameters = [
            'url' => 'https://laravel.com',
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(201)
            ->assertJson([
                'expires_at' => null
            ]);
    }

    /** @test */
    public function an_expiration_date_must_be_a_valid_date()
    {
        $parameters = [
            'url' => 'https://laravel.com',
            'expires_at' => 'invalid_expires_at'
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('expires_at');
    }


    /** @test */
    public function an_expiration_date_must_be_in_the_future()
    {
        $expires_at = Carbon::parse('yesterday');

        $parameters = [
            'url' => 'https://laravel.com',
            'expires_at' => $expires_at
        ];

        $response = $this->createSurl($parameters);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('expires_at');
    }
}
