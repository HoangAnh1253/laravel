<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web', ['except' => ['login', 'register']]);
    }


    public function index(Request $request)
    {
        return view('index')->with(["message"=>$request->message]);
    }

    public function user()
    {
        $users = User::get();
        return new Response([
            'id' => Auth::user()
        ]);
    }

    public function register(Request $request, UserRepository $repository)
    {
        $payload = [
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "is_admin" => $request->is_admin || false,
        ];

        $user = $repository->create($payload);
        return new Response($user);
    }

    public function login(Request $request)
    {
        $isLogin = false;
        $token = Auth::attempt($request->only(['email', 'password']));
        if (!$token) {
            return response(view('login', ['status' => 400]), HttpFoundationResponse::HTTP_BAD_REQUEST);
        }
        $user = Auth::user();
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        $user = Auth::user();
        return redirect('/login');
    }
}