<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Core\Exceptions\LoginException;
use Modules\Auth\Requests\LoginRequest;
use Support\Traits\HttpResponses;

final class LoginController extends Controller
{
    use HttpResponses;

    /**
     * @throws LoginException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $user = User::query()
            ->where('phone_number', $dto->phoneNumber)
            ->first();

        if (! $user || ! Hash::check($dto->password, $user->password)) {
            throw LoginException::invalidVerificationCode();
        }

        return $this->success(
            data: [
                'user' => $user,
                'token' => $user->createToken($user->name)->plainTextToken,
            ],
            message: 'Successfully logged in.'
        );
    }
}
