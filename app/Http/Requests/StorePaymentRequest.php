<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        $colocationId = $this->input('colocation_id');
        $fromId = $this->input('from_user_id');

        if (! $colocationId || ! $fromId) {
            return false;
        }

        // user must be part of the provided colocation
        if (! $user->colocations()->whereNull('memberships.left_at')->where('colocations.id', $colocationId)->exists()) {
            return false;
        }

        // the payer should also belong to the same colocation
        $fromUser = \App\Models\User::find($fromId);
        if (! $fromUser || ! $fromUser->colocations()->whereNull('memberships.left_at')->where('colocations.id', $colocationId)->exists()) {
            return false;
        }

        // current user will be treated as recipient so no further check
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
            'amount' => 'required|numeric|min:0.01',

            'from_user_id' => 'required|exists:users,id',

            'colocation_id' => 'required|exists:colocations,id',
        ];
    }
}
