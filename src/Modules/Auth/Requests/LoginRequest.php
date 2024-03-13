<?php

declare(strict_types=1);

namespace Modules\Auth\Requests;

use Illuminate\Support\Arr;
use Modules\Auth\Core\DTO\LoginRequestDTO;
use Support\Requests\BaseFormRequest;

final class LoginRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'phone_number' =>
                'required',
                'string',
                'exists:users,phone_number',
            'password' => 'required|string'
        ];
    }

    public function getDto(): LoginRequestDTO
    {
        $validated = $this->validated();

        return new LoginRequestDTO(
            phoneNumber: Arr::get($validated, 'phone_number'),
            password: Arr::get($validated, 'password')
        );
    }
}
