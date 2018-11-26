<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvocationRequest extends FormRequest
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
//            'designationr_nature'=>'required',
//            'personnels_id_personnel'=>'required',
//            'num_immobilier'=>'required|min:7',
//            'adresse_immobilier'=>'required|min:255'
        ];
    }
}
