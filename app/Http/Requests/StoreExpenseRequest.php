<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        $colocationId = $this->input('colocation_id');

        if (! $colocationId) {
            return false;
        }

        // allow if the authenticated user has an active membership in the provided colocation
        return $user->colocations()->whereNull('memberships.left_at')->where('colocations.id', $colocationId)->exists();
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
