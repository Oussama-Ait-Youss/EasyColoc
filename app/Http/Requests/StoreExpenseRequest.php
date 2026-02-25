<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            
            'amount' => 'required|numeric|min:0.01',
            
            'category_id' => 'required|exists:categories,id',
            
            'date' => 'required|date|before_or_equal:today',
            
            'colocation_id' => 'required|exists:colocations,id',
        ];
    }
}
