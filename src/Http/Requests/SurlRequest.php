<?php

namespace Mniknab\Surl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * Class SurlRequest
 *
 * @package Mniknab\Surl\Http\Requests
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class SurlRequest extends FormRequest
{

    /**
     * Authorize method
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Rules for request parameters
     *
     * @return array
     */
    public function rules()
    {
        $exceptUniqueIdentifier = '';
        if ($this->route('id')) {
            $exceptUniqueIdentifier .= ',id,'.$this->route('id');
        }

        return [
            'url'           => 'required|active_url',
            'identifier'    => 'max:255|unique:surls' . $exceptUniqueIdentifier,
            'expires_at'    => 'date|after:now|nullable'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'identifier' => Str::slug($this->identifier),
        ]);
    }
}
