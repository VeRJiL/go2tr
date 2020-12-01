<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\SendSmsRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Http\Requests\V1\ActivateRequest;
use App\Services\Contracts\UserServiceInterface;

class AuthenticationController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {

    }

    public function login(LoginRequest $request)
    {

    }

    public function logout()
    {

    }

    public function sendCode(SendSmsRequest $request)
    {

    }

    public function confirmCode(ActivateRequest $request)
    {

    }

    public function refresh()
    {

    }
}
