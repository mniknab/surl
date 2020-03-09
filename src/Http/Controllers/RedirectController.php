<?php


namespace Mniknab\Surl\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mniknab\Surl\Contracts\Surl as SurlContract;

/**
 * Class RedirectController
 *
 * @package Mniknab\Surl\Http\Controllers
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class RedirectController extends Controller
{
    /**
     * The SurlContract instance.
     *
     * @var SurlContract
     */
    private $surl;

    const STATUS_NOT_FOUND  = 404;
    const STATUS_GONE       = 410;
    const STATUS_FOUND      = 302;

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
     * Set impression and redirect short url to long url
     * \
     * @param Request $request
     * @param $identifier
     * @return void | \Illuminate\Http\RedirectResponse
     */
    public function redirect(Request $request, $identifier)
    {
        $surl = $this->surl->getByIdentifier($identifier);

        if(!is_null($surl)){

            if( $surl->hasExpired() ){
                return $this->abort(self::STATUS_GONE);
            }

            $this->surl->setImpression($surl,$request);

            return redirect()->away($surl->url,self::STATUS_FOUND);
        }
        return $this->abort(self::STATUS_NOT_FOUND);
    }

    /**
     * Return error view if exists or abort
     *
     * @param $error_code
     * @return \Illuminate\Http\Response|void
     */
    public function abort($error_code){
        if( view()->exists('surl::errors.'.$error_code) ){
            return response()->view('surl::errors.'.$error_code, [], $error_code);
        }
        return abort($error_code);
    }
}
