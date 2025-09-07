<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',  'unique:products,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'vendor_id' => ['required', 'integer', 'exists:vendors,id'],
        ];
    }

    public function prepareForValidation()
    {
        // if($this->name){
        //     $this->merge([
        //         'name' => $this->name . ' Mothy'
        //     ]);
        // }
    }

    public function attributes()
    {
        return [
            'category_id' => 'category'
        ];
    }
}
