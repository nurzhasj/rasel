<?php

namespace Modules\Auth\Core\Exceptions;

use Support\Exceptions\CustomException;
use Symfony\Component\HttpFoundation\Response;

class LoginException extends CustomException
{
    public static function invalidVerificationCode(): LoginException
    {
        return new LoginException(
            message: 'Credentials do not match.',
            code: Response::HTTP_BAD_REQUEST
        );
    }
}
