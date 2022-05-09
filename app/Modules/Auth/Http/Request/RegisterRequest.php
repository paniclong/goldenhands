<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc',
            'password' => 'required|min:8',
            'name' => 'required|min:2',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => __('Email is required'),
            'email.password' => __('Password is required'),
            'email.name' => __('Name is required'),
            'password.min' => __('Min length of password equals 8'),
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->get('email', '');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name', '');
    }

    /**
     * @return string
     */
    public function getUserPassword(): string
    {
        return $this->get('password', '');
    }
}
