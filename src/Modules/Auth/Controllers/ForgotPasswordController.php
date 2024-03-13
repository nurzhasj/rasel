<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Core\Exceptions\LoginException;
use Modules\Auth\Requests\ForgotPasswordRequest;
use Support\Traits\HttpResponses;

final class ForgotPasswordController extends Controller
{
    use HttpResponses;

    /**
     * @throws LoginException
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $user = User::query()
            ->where('phone_number', $dto->phoneNumber)
            ->first();

        // @TODO: Send verification code to the user part

        return $this->success(
            data: [
                'user' => $user,
                'token' => $user->createToken($user->name)->plainTextToken
            ],
            message: 'Setting password process went successfully.'
        );
    }
}
