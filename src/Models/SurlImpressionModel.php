<?php


namespace Mniknab\Surl\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class SurlImpressionModel
 *
 * @package Mniknab\Surl\Models
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class SurlImpressionModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'surl_impressions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surl_id',
    ];
}
