<?php

namespace Mniknab\Surl\Http\Controllers;

use Illuminate\Routing\Controller;
use Mniknab\Surl\Contracts\Surl as SurlContract;
use Mniknab\Surl\Http\Requests\SurlRequest;
use Mniknab\Surl\Http\Responses\SurlResponse;

/**
 * Class SurlController
 *
 * @package Mniknab\Surl\Http\Controllers
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class SurlController extends Controller
{

    /**
     * The SurlContract instance.
     *
     * @var SurlContract
     */
    private $surl;

    /**
     * Create a new instance.
     *
     * @param SurlContract $surl
     */
    public function __construct(SurlContract $surl)
    {
        $this->surl = $surl;
    }

    /**
     * Get all Surls list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->surl->all();
        return view('surl::list', compact('list'));
    }

    /**
     * Show the create page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('surl::create');
    }

    /**
     * Create short url
     *
     * @param SurlRequest $request
     * @return SurlResponse
     */
    public function store(SurlRequest $request)
    {
        $result = $this->surl->create(
            $request->url,
            $request->identifier,
            $request->title,
            $request->description,
            $request->expires_at
        );

        return new SurlResponse($result);
    }

    /**
     * Show the edit page
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surl = $this->surl->getById($id)->toArray();
        return view('surl::edit',compact('surl'));
    }

    /**
     * Update a surl details
     *
     * @param SurlRequest $request
     * @param $id
     * @return SurlResponse
     */
    public function update(SurlRequest $request, $id)
    {
        $result = $this->surl->update(
            $id,
            $request->url,
            $request->identifier,
            $request->title,
            $request->description,
            $request->expires_at
        );

        return new SurlResponse($result);
    }

    /**
     * Permanently delete a surl
     *
     * @param $id
     * @return SurlResponse
     */
    public function destroy($id)
    {
        $result = $this->surl->destroy($id);
        return new SurlResponse($result);
    }
}

