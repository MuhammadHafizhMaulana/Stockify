<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository{

    public function getAll(){
        return User::all();
    }

    public function findById($id){
        return User::findOrFail($id);
    }

    public function create(array $data){
        return User::create($data);
    }

    public function update(User $user, array $data){
        return $user->update($data);
    }

    public function delete(User $user){
        return $user->delete();
    }

    public function findByEmail($email){
        return User::where('email', $email)->first();
    }
}
