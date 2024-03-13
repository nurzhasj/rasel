<?php

declare(strict_types=1);

namespace Modules\Auth\Core\DTO;

final class ForgotPasswordRequestDTO
{
    public function __construct(
        public string $phoneNumber
    ) {
    }
}
