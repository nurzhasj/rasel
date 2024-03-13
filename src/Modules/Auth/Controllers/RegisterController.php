<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Core\Exceptions\VerificationException;
use Modules\Auth\Requests\RegisterRequest;
use Modules\Auth\Requests\SetPasswordRequest;
use Modules\Auth\Requests\VerifyPhoneNumberRequest;
use Support\Traits\HttpResponses;

final class RegisterController extends Controller
{
    use HttpResponses;

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $user = User::query()
            ->create(
                [
                    'name' => $dto->name,
                    'password' => $dto->name,
                    'phone_number' =>
                        str_replace(' ', '', $dto->phoneNumber),
                    'birthday' => $dto->birthday
                ]
            );

        return $this->success(
            data: [
                'user' => $user
            ],
            message: 'Registration data was saved successfully.'
        );
    }

    /**
     * @throws VerificationException
     */
    public function verifyPhoneNumber(VerifyPhoneNumberRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $user = User::query()
            ->where('id', $dto->userId)
            ->first();

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

    public function setPassword(SetPasswordRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $user = $request->user();

        $user->password = Hash::make($dto->password);

        $user->save();

        return $this->success(
            data: [],
            message: 'Password set successfully.'
        );
    }
}
