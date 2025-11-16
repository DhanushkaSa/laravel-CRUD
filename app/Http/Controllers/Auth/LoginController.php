<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResources;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Arrays;
use phpDocumentor\Reflection\Types\Resource_;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): array
    {
        $request->authenticate();

        // $request->session()->regenerate();
        $user = $request->user();
        $token = $user->createToken('main')->plainTextToken;

        return [
            'user' => new UserResources($user),
            'token' => $token
        ];
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        $user=$request->user();
        $user->currentAccessToken()->delete();

        return response()->noContent();
    }
}
