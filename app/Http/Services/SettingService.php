<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;
use App\Http\Repositories\SettingRepository;

class SettingService{

    protected $settingRepo;

    public function __construct(SettingRepository $settingRepo){

        $this->settingRepo = $settingRepo;

    }

    public function createSetting(array $data){
        return $this->settingRepo->create($data);
    }

    public function updateSetting($id, array $data){
        $setting = $this->settingRepo->findById($id);
        return $this->settingRepo->update($setting, $data);
    }

    public function deleteSetting($id){
        $setting = $this->settingRepo->findById($id);

        if($setting->logo && Storage::disk('public')->exists($setting->logo)){
            Storage::disk('public')->delete($setting->logo);
        }
        return $setting->delete();
    }

    public function getSettingById($id){
        return $this->settingRepo->findById($id);
    }
}
