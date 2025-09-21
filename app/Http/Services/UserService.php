<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\UserRepository;

class UserService{

    protected $userRepo;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    public function listUser(){
        return $this->userRepo->getAll();
    }

    public function createUser(array $data){
        $data['password'] = Hash::make($data['password']);
        return $this->userRepo->create($data);
    }

    public function updateUser($id, array $data){
        $user = $this->userRepo->findById($id);
        return $this->userRepo->update($user, $data);
    }

    public function deleteUser($id){
        $user = User::findOrFail($id);
        return $this->userRepo->delete($user);
    }

    public function getUserById($id){
        return $this->userRepo->findById($id);
    }
}
