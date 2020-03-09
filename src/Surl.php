<?php

namespace Mniknab\Surl;

use Illuminate\Http\Request;
use Mniknab\Surl\Contracts\Surl as SurlContract;
use Mniknab\Surl\Traits\Identifier;
use Mniknab\Surl\Models\SurlModel;
use Illuminate\Support\Facades\Cache;

/**
 * class Surl
 *
 * @package Mniknab\Surl
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class Surl implements SurlContract
{
    use Identifier;

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
    public function create(string $url, string $identifier = null, string $title = null, string $description = null, string $expiresAt = null ) :SurlModel
    {
        $surl = new SurlModel;
        $surl->url = $url;
        $surl->identifier = $this->getSlugOrHashIdentifier($identifier);
        $surl->title = $title;
        $surl->description = $description;
        $surl->expires_at = $expiresAt;

        $surl->save();

        return $surl;
    }

    /**
     * Get all Surls list
     *
     * @return mixed
     */
    public function all()
    {
        return SurlModel::orderBy('id', 'DESC')->paginate( config('surl.items_per_page') );
    }

    /**
     * Get a Surl by id
     *
     * @param int $id
     * @return SurlModel
     */
    public function getById(int $id) :SurlModel
    {
        return SurlModel::findOrFail($id);
    }

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
    public function update(int $id, string $url, string $identifier = null, string $title = null, string $description = null, string $expiresAt = null) :SurlModel
    {
        $surl = $this->getById($id);

        $this->forgetCache($surl->identifier);

        $surl->url = $url;
        $surl->identifier = $this->getSlugOrHashIdentifier($identifier);
        $surl->title = $title;
        $surl->description = $description;
        $surl->expires_at = $expiresAt;

        $surl->save();

        return $surl;
    }

    /**
     * Forget cached Surl
     *
     * @param $key
     * @return void
     */
    public function forgetCache($key) :void
    {
        Cache::forget(config('surl.cache_prefix') . $key);
    }

    /**
     * Permanently delete a surl
     *
     * @param $id
     * @return bool
     */
    public function destroy($id): bool
    {
        $surl = $this->getById($id);

        $this->forgetCache($surl->identifier);

        return $surl->delete();
    }

    /**
     * Get a Surl by identifier
     *
     * @param $identifier
     * @return mixed
     */
    public function getByIdentifier($identifier)
    {
        return Cache::rememberForever( config('surl.cache_prefix') . $identifier, function () use ($identifier) {
            return SurlModel::whereIdentifier($identifier)->first();
        });
    }

    /**
     * Save Impression for a Surl
     *
     * @param SurlModel $surl
     * @param Request $request
     */
    public function setImpression(SurlModel $surl, Request $request): void
    {
        $surl->impressions()->create([]);
    }
}
