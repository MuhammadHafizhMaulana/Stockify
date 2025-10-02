<?php

namespace App\Http\Controllers;

use App\Http\Services\ActivityLogService;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Services\SettingService;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $settingService;

    public function __construct(SettingService $settingService){
        $this->settingService = $settingService;
    }
    public function index()
    {
        $setting = Setting::first();
        return view('setting.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ActivityLogService $logService)
    {
        $data = $request->validate([
            'logo'  => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'slogan' => 'required',
            'title' => 'required'
        ]);

        $data['title'] = strtolower($data['title']);
        $data['slogan'] = strtolower($data['slogan']);

        $setting = $this->settingService->createSetting($data);

        $logService->log(
            'create_setting',
            "Menambahkan settingan baru "
        );

        if($request->hasFile('logo')){
            $file = $request->file('logo');

            $filename = $setting->id. '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('setting',$filename,'public');

            $this->settingService->updateSetting( $setting->id,['logo'=> $path]);
        }

        return redirect()->route('setting.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = Setting::first();
        return view('setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ActivityLogService $logService)
    {
        $data = $request->validate([
            'logo' => 'nullable',
            'title' => 'nullable',
            'slogan' => 'nullable'
        ]);

        $setting = Setting::find($id);

        if($request->hasFile('logo')){
            $file = $request->file('logo');

            //hapus file lama
            if($setting->logo && Storage::disk('public')->exists($setting->logo)){
                Storage::disk('public')->delete($setting->logo);
            }

            $file = $request->file('logo');

            $filename = $setting->id. '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('setting',$filename,'public');
            $data['logo'] = $path;

            $setting->update(['logo' => $path]);
        }

        $old = $this->settingService->getSettingById($id);
        $oldData = [
            'title' => $old->title,
            'slogan' => $old->slogan,
        ];

        // ubah ke lower case
        $data['title'] = strtolower($data['title']);
        $data['slogan'] = strtolower($data['slogan']);

        $this->settingService->updateSetting($id, $data);

        // Membandingkan field yang berubah
        $changed = [];
        foreach($data as $key => $newValue){
            if (array_key_exists($key,$oldData) && $oldData[$key] != $newValue){
                $changed[$key] = [
                    'old' => $oldData[$key],
                    'new' => $newValue
                ];
            }
        }

        // Membuat deskripsi data yang berubah
        if (!empty($changed)){
            $parts = [];
            foreach ($changed as $field => $values){
                // Menampilkan nama produk
                if($field === 'setting_id'){
                    $oldName = optional($old->product)->title ?? '-';
                    $newName = optional(Setting::find($values['new']))->title ?? '-';
                    $parts[] = "setting: {$oldName} → {$newName}";
                } else {
                    $parts[] = "{$field}: {$values['old']} → {$values['new']}}";
                }
            }

            $description = "Mengubah setting ID {$old->id} (" .
                implode(', ', $parts) . ")";

            $logService->log('edit_setting', $description);
        }

        // Membuat deskripsi log
        $description = sprintf(
            'Mengubah setting'
        );

         return redirect()->route('setting.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
