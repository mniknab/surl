<?php

namespace Mniknab\Surl\Contracts;

use Illuminate\Http\Request;
use Mniknab\Surl\Models\SurlModel;

/**
 * Interface Surl
 *
 * @package Mniknab\Surl\Contracts
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
interface Surl
{
    /**
     * Create Short url (Surl)
     *
     * @param string $url
     * @param string|null $identifier
     * @param string|null $title
     * @param string|null $description
     * @param string|null $expiresAt
     * @return SurlModel
     */
    public function create(
        string $url,
        string $identifier = null,
        string $title = null,
        string $description = null,
        string $expiresAt = null
    ) : SurlModel;

    /**
     * Get all Surls list
     *
     * @return mixed
     */
    public function all();

    /**
     * Get a Surl by id
     *
     * @param int $id
     * @return SurlModel
     */
    public function getById(int $id) : SurlModel;

    /**
     * Update a surl details
     *
     * @param int $id
     * @param string $url
     * @param string|null $identifier
     * @param string|null $title
     * @param string|null $description
     * @param string|null $expiresAt
     * @return SurlModel
     */
    public function update(
        int     $id,
        string  $url,
        string  $identifier = null,
        string  $title = null,
        string  $description = null,
        string  $expiresAt = null
    ) : SurlModel;

    /**
     * Permanently delete a surl
     *
     * @param $id
     * @return bool
     */
    public function destroy($id) :bool;

    /**
     * Forget cached Surl
     *
     * @param $key
     * @return void
     */
    public function forgetCache($key) :void;

    /**
     * Get a Surl by identifier
     *
     * @param $identifier
     * @return mixed
     */
    public function getByIdentifier($identifier);

    /**
     * Save Impression for a Surl
     *
     * @param SurlModel $surl
     * @param Request $request
     */
    public function setImpression(SurlModel $surl, Request $request):void;
}
