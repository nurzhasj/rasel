<?php

declare(strict_types=1);

namespace Modules\Auth\Core\DTO;

final class LoginRequestDTO
{
    public function __construct(
        public string $phoneNumber,
        public string $password
    ){
    }
}
