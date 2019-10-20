<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    /**
     * Create new user
     *
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public function createUser(string $name, string $email, string $password): bool
    {
        $user = new User;

        $user->{User::FIELD_NAME} = $name;
        $user->{User::FIELD_EMAIL} = $email;
        $user->{User::FIELD_PASSWORD} = Hash::make($password);

        return $user->save();
    }

    /**
     * Authorization the user
     *
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public function authorization(string $email, string $password): bool
    {
        return Auth::attempt(['email' => $email, 'password' => $password]);
    }

    /**
     * Get user access token
     *
     * @param User $user
     *
     * @return string
     */
    public function getToken(User $user): string
    {
        return $user->createToken(Config::get('app.name'))-> accessToken;
    }


}
