<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdjustInventoryRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'vendor_id' => 'required|exists:vendors,id',
            'lot_number' => 'required|string|max:255',
            'adjustment_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'uom' => 'required|string|max:50|in:kg,g,lb,ea',
            'expiration_date' => 'required|date|after:today',
            'facility_location' => 'required|string|max:100|in:warehouse,quarantine,production',
            'adjustment_type' => 'required|string|max:50',
            'quarantine_user' => 'nullable|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'product_id' => 'product',
            'vendor_id' => 'vendor',
            'lot_number' => 'lot number',
            'uom' => 'unit of measure',
            'facility_location' => 'facility location',
            'adjustment_type' => 'adjustment type',
            'expiration_date' => 'expiration date',
        ];
    }
}
