<?php

namespace Modules\Auth\Core\Exceptions;

use Support\Exceptions\CustomException;
use Symfony\Component\HttpFoundation\Response;

class VerificationException extends CustomException
{
    public static function invalidVerificationCode(): VerificationException
    {
        return new VerificationException(
            message: 'Invalid verification code provided!',
            code: Response::HTTP_BAD_REQUEST
        );
    }
}
