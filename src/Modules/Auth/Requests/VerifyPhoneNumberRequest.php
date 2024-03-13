<?php

declare(strict_types=1);

namespace Modules\Auth\Requests;

use Illuminate\Support\Arr;
use Modules\Auth\Core\DTO\VerifyPhoneNumberRequestDTO;
use Support\Requests\BaseFormRequest;

final class VerifyPhoneNumberRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|int',
            'verification_code' => 'required|string|max:4',
        ];
    }

    public function getDto(): VerifyPhoneNumberRequestDTO
    {
        $validated = $this->validated();

        return new VerifyPhoneNumberRequestDTO(
            userId: (int) Arr::get($validated, 'user_id'),
            verificationCode: Arr::get($validated, 'verification_code')
        );
    }
}
