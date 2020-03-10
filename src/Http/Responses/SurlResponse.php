<?php


namespace Mniknab\Surl\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * Class SurlResponse
 *
 * @package Mniknab\Surl\Http\Responses
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class SurlResponse implements Responsable
{

    private $result;

    /**
     * SurlResponse constructor.
     *
     * @param $result
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if($request->wantsJson()){
            return response(
                $this->getResponse(),
                $this->getStatusCode( $request->getMethod() )
            );
        }

        return redirect()
            ->route('surl.list')
            ->with('message', $this->getMessage());
    }

    /**
     * Get response message content
     *
     * @return array
     */
    private function getMessage() :array
    {

        if(is_bool($this->result)){
            return [
                'content'   => __('surl::responses.deleted'),
                'type'      => 'success'
            ];
        }

        if($this->result->wasRecentlyCreated){
            $message = [
                'content'   => __('surl::responses.created'),
                'type'      => 'success'
            ];
        }

        if(!$this->result->wasRecentlyCreated){
            $message = [
                'content'   => __('surl::responses.updated'),
                'type'      => 'success'
            ];
        }

        return $message ?? [
            'content'   => 'An Error has occurred!',
            'type'      => 'danger'
        ];
    }

    /**
     * Get response content
     *
     * @return array
     */
    private function getResponse(): array
    {
        if(is_bool($this->result)){
            return [
                'result' => $this->result
            ];
        }

        $arrResult = $this->result->attributesToArray();

        $shortUrl = route('surl.redirect', $arrResult['identifier'] );

        return [
            'id'                => $arrResult['id'],
            'identifier'        => $arrResult['identifier'],
            'title'             => $arrResult['title'],
            'description'       => $arrResult['description'],
            'url'               => $arrResult['url'],
            'short_url'         => $shortUrl,
            'expires_at'        => $arrResult['expires_at'],
            'impression_count'  => $arrResult['impression_count'],
        ];
    }

    /**
     * Get perfect http status code
     *
     * @param $method
     * @return int
     */
    private function getStatusCode($method): int
    {
        $statuses = [
            'POST' => 201,
            'PUT' => 200,
            'DELETE' => 204
        ];

        return $statuses[$method];
    }

}
