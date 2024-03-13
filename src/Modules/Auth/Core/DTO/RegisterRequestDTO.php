<?php

declare(strict_types=1);

namespace Modules\Auth\Core\DTO;

use Carbon\Carbon;

final class RegisterRequestDTO
{
    public function __construct(
        public string $name,
        public string $phoneNumber,
        public ?Carbon $birthday
    ) {
    }
}
