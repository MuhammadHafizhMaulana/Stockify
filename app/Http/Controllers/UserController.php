<?php

namespace App\Http\Controllers;

use App\Http\Services\ActivityLogService;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->listUser();
        return view('user.index', compact('users'));
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $user = $this->userService->createUser($data);

        if($request->hasFile('image')){
            $file = $request->file('image');

            $filename = $user->id. '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('users',$filename,'public');

            $this->userService->updateUser( $user->id,['image'=> $path]);
        }

        $actor = Auth::check()
            ? 'admin' . Auth::user()->name
            : 'User mendaftar sendiri';

        $logService->log(
            'create_user',
            "{$actor} membuat akun baru : " .
            "Nama : {$user->name}, Email : {$user->email}, Role : {$user->role}"
        );

        return redirect()
        ->route('user.index')
        ->with('success', "User berhasil terdaftar");
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
        $user = $this->userService->getUserById($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ActivityLogService $logService)
    {
        $user = $this->userService->getUserById($id);

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $old = $this->userService->getUserById($id);
        $oldData = [
            'name' => $old->name,
            'role' => $old->role,
        ];

        if($request->hasFile('image')){
            $file = $request->file('image');

            //hapus file lama
            if($user->image && Storage::disk('users')->exists($user->image)){
                Storage::disk('public')->delete($user->image);
            }

            $file = $request->file('image');

            $filename = $user->id. '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('users',$filename,'public');
            $data['image'] = $path;

            $user->update(['image' => $path]);
        }

        $this->userService->updateUser($id, $data);

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
                if($field === 'user_id'){
                    $oldName = optional($old->user)->name ?? '-';
                    $newName = optional(User::find($values['new']))->name ?? '-';
                    $parts[] = "produk: {$oldName} → {$newName}";
                } else {
                    $parts[] = "{$field}: {$values['old']} → {$values['new']}}";
                }
            }

            $description = "Mengubah User ID {$old->id} (" .
                implode(', ', $parts) . ")";

            $logService->log('edit_user', $description);
        }

        // Membuat deskripsi log
        $description = sprintf(
            'Mengubah data user'
        );
        return redirect()
        ->route('user.index')
        ->with('success', 'user updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ActivityLogService $logService)
    {
        $user = $this->userService->getUserById($id);
        if(!$user){
            return redirect()
            ->route('user.index')
            ->with('error', 'User tidak ditemukan');
        }

        // hapus user
        $this->userService->deleteUser($id);

        // Buat log
        $logService->log(
            'delete_user',
            "Menghapus transaksi user ID {$user->id}, ".
            "Nama {$user->name}, ".
            "Email {$user->email}, ".
            "Role {$user->role}, "
        );
        return redirect()
        ->route('user.index')
        ->with('success', 'user deleted');
    }
}
