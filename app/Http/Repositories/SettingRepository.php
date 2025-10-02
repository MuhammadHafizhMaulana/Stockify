<?php

namespace App\Http\Repositories;

use App\Models\Setting;

class SettingRepository{
    public function getAll(){
        return Setting::all();
    }

    public function findById($id){
        return Setting::find($id);
    }

    public function create(array $data){
        return Setting::create($data);
    }

    public function update(Setting $setting, array $data){
        return $setting->update($data);
    }

    public function delete(Setting $setting){
        return $setting->delete();
    }

}
