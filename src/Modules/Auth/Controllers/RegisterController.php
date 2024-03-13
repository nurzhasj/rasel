<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Core\Exceptions\VerificationException;
use Modules\Auth\Requests\RegisterRequest;
use Modules\Auth\Requests\VerifyPhoneNumberRequest;
use Support\Traits\HttpResponses;

final class RegisterController
{
    use HttpResponses;

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $user = User::query()
            ->create(
                [
                    'name' => $dto->name,
                    'phone_number' => $dto->phoneNumber,
                    'birthday' => $dto->birthday
                ]
            );

        return $this->success(
            data: ['user' => $user],
            message: 'Registration data was saved successfully.'
        );
    }

    /**
     * @throws VerificationException
     */
    public function verifyPhoneNumber(VerifyPhoneNumberRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $user = $request->user();

        if ($dto->verificationCode != substr($user->phone_number, -4))
        {
            throw VerificationException::invalidVerificationCode();
        }

        $user->phone_number_verified_at = now();

        $user->save();

        return $this->success(
            data: [
                'user' => $user,
                'token' => $user->createToken($user->name)->plainTextToken
            ],
            message: 'User signed in successfully.'
        );
    }
}
