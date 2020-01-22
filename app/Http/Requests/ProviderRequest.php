<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProviderRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $id = $request->id;
        if($request->isMethod('post')){
            return [
                'name' => ['required', 'string', 'max:255'],
                'company' => ['required','string'],
                'address' => ['required','string'],
                'city' => ['required','string'],
                'phone' => ['required','numeric','digits:10' ,'unique:providers'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:providers']
            ];
        }else {
            return [
                'name' => ['required', 'string', 'max:255'],
                'company' => ['required','string'],
                'address' => ['required','string'],
                'city' => ['required','string'],
                'phone' => ['required','numeric','min:10', Rule::unique('providers')->ignore($id)],
                'email' => ['required', 'string', 'email', 'max:255',  Rule::unique('providers')->ignore($id)]
            ];
        }

    }
}
