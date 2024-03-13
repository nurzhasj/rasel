<?php

declare(strict_types=1);

namespace Modules\Auth\Core\DTO;

final class VerifyPhoneNumberRequestDTO
{
    public function __construct(
        public int $userId,
        public string $verificationCode
    ) {
    }
}
