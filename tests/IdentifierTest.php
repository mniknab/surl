<?php

namespace Tests;

use Mniknab\Surl\Traits\Identifier;

/**
 * Class IdentifierTest
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class IdentifierTest extends TestCase
{
    use Identifier;

    /** @test */
    public function it_generate_a_correct_identifier_length()
    {
        $identifier = $this->getSlugOrHashIdentifier();

        $this->assertEquals(strlen($identifier), config('surl.identifier_hash_length'));
    }

    /** @test */
    public function it_generate_a_sanitize_identifier()
    {
        $identifier = $this->getSlugOrHashIdentifier('laravel/ surl!');

        $this->assertEquals($identifier, 'laravel-surl');
    }

    /** @test */
    public function it_generate_a_lowered_identifier()
    {
        $identifier = $this->getSlugOrHashIdentifier('LaRaVeL');

        $this->assertEquals($identifier, 'laravel');
    }
}
