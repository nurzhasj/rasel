<?php

declare(strict_types=1);

namespace Modules\Auth\Requests;

use Illuminate\Support\Arr;
use Modules\Auth\Core\DTO\ForgotPasswordRequestDTO;
use Support\Requests\BaseFormRequest;

final class ForgotPasswordRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'phone_number' => 'required',
            'string',
            'exists:users,phone_number',
        ];
    }

    public function getDto(): ForgotPasswordRequestDTO
    {
        $validated = $this->validated();

        return new ForgotPasswordRequestDTO(
            phoneNumber: Arr::get($validated, 'phone_number')
        );
    }
}
