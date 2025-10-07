<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\ActivityLogService;

class AuthController extends Controller
{

    protected $authService;
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $login = $this->authService->login($request->email, $request->password);

        if($login){
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function showLoginForm(){
        return view('auth.login');
    }

    public function register(Request $request, ActivityLogService $logService)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = $this->authService->register($data);

        // log
        $logService->log(
            'register',
            "User {$user->name} mendaftar dengan email {$user->email}",
            $user->id
        );

        Auth::login($user); // auto login setelah daftar
        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil, Anda sudah login.');
    }
}
