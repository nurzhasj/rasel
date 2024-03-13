<?php

declare(strict_types=1);

namespace Modules\Auth\Requests;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Modules\Auth\Core\DTO\RegisterRequestDTO;
use Support\Requests\BaseFormRequest;

final class RegisterRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone_number' => [
                'required',
                'string',
                'regex:/^\+7\s?\d{3}\s?\d{3}\s?\d{2}\s?\d{2}$/',
            ],
            'birthday' => 'required|date|before:today|after:1900-01-01',
        ];
    }

    public function getDto(): RegisterRequestDTO
    {
        $validated = $this->validated();

        $birthday = Arr::get($validated, 'birthday');

        return new RegisterRequestDTO(
            name: Arr::get($validated, 'name'),
            phoneNumber: Arr::get($validated, 'phone_number'),
            birthday: $birthday ? Carbon::parse($birthday) : null
        );
    }
}
