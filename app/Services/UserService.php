<?php

namespace App\Services;

use App\Models\User;
use App\Acme\BaseAnswer;
use App\Jobs\RegisterUser;
use App\Http\Requests\V1\RegisterRequest;
use App\Services\Contracts\UserServiceInterface;

class UserService extends Service implements UserServiceInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(RegisterRequest $request): BaseAnswer
    {
        $user = $this->user->where('phone_number', $request->input('phone_number'))->first();

        if ($user) {
            return failAnswer('کاربری با این شماره تلفن قبلا ثبت نام کرده است.');
        }

        RegisterUser::dispatch($request->all());
        return successAnswer(null, 'اطلاعات کاربر با موفقیت ثبت گردید.');
    }
}
