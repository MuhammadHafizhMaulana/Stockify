<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\UserRepository;

class AuthService {

    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function login($email, $password){

        $user = $this->userRepo->findByEmail($email);

        if($user && Hash::check($password, $user->password)){
            Auth::login($user);
            session()->regenerate();
            return true;
        }

        return false;
    }

}
