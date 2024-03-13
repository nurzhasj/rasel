<?php

declare(strict_types=1);

namespace Modules\Auth\Core\DTO;

final class SetPasswordRequestDTO
{
    public function __construct(
        public string $password
    ){
    }
}
