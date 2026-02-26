<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // only the owner of the active colocation can send invitations
        $user = $this->user();

        if (! $user) {
            return false;
        }

        $colocation = $user->activeColocation();
        return $colocation && $colocation->pivot->role === 'owner';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            // colocation_id is determined server‑side from the authenticated user,
            // we don't expect it from the form anymore.
        ];
    }
}
