<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $user = $this->userService->createUser($data);;

        if($request->hasFile('image')){
            $file = $request->file('image');

            $filename = $user->id. '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('users',$filename,'public');

            $this->userService->updateUser( $user->id,['image'=> $path]);
        }

        return redirect()->route('user.index');
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
    public function update(Request $request, string $id)
    {
        $user = $this->userService->getUserById($id);

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

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
        return redirect()
        ->route('user.index')
        ->with('success', 'user updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);
        return redirect()
        ->route('user.index')
        ->with('success', 'user deleted');
    }
}
