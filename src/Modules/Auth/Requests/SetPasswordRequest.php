<?php

declare(strict_types=1);

namespace Modules\Auth\Requests;

use Illuminate\Support\Arr;
use Modules\Auth\Core\DTO\SetPasswordRequestDTO;
use Support\Requests\BaseFormRequest;

final class SetPasswordRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'confirmed'
            ]
        ];
    }

    public function getDto(): SetPasswordRequestDTO
    {
        $validated = $this->validated();

        return new SetPasswordRequestDTO(
            password: Arr::get($validated, 'password')
        );
    }
}
