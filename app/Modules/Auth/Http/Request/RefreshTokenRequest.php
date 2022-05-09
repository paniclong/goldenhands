<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class RefreshTokenRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'refresh_token' => 'required|string|max:256',
        ];
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->get('refresh_token', '');
    }
}
