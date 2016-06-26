<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CrawlingFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
		    'inputText' => 'required',
		    'number' => 'required|integer|max:100',
		    'depthLimit' => 'required|integer|max:10',
	    ];
    }
}
