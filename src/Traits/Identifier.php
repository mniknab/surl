<?php

namespace Mniknab\Surl\Traits;

use Illuminate\Support\Str;

/**
 * Trait Identifier
 *
 * @package Mniknab\Surl\Traits
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
trait Identifier
{
    /**
     * Generate hash for identifier or convert identifier to slug
     *
     * @param $identifier
     * @return string
     */
    public function getSlugOrHashIdentifier($identifier = null) :string
    {
        return empty($identifier) ? Str::random( config('surl.identifier_hash_length') ) : Str::slug($identifier) ;
    }
}
