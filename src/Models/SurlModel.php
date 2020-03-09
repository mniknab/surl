<?php


namespace Mniknab\Surl\Models;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class SurlModel
 *
 * @package Mniknab\Surl\Models
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class SurlModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'surls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'identifier',
        'title',
        'description',
        'expires_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['impression_count'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'date:Y-m-d',
    ];

    /**
     * Check surl expire date
     *
     * @return bool
     */
    public function hasExpired():bool
    {
        if( is_null($this->expires_at) ) return false;

        $expiresAt = Carbon::parse($this->expires_at);
        return !$expiresAt->isFuture();
    }

    /**
     * Get the count of impression
     *
     * @param  string  $value
     * @return string
     */
    public function getImpressionCountAttribute($value)
    {
        return $this->impressions()->count('id');
    }

    /**
     * Get the impressions for the surl record
     */
    public function impressions()
    {
        return $this->hasMany('\Mniknab\Surl\Models\SurlImpressionModel','surl_id');
    }
}
