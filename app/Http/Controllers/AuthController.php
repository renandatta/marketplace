<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $productRepository;
    private $userRepository;
    public function __construct(ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function login()
    {
        $productCategories = $this->productRepository->getAllParentCategory();
        return view('auth.login', compact('productCategories'));
    }

    public function register()
    {
        $productCategories = $this->productRepository->getAllParentCategory();
        return view('auth.register', compact('productCategories'));
    }

    public function login_process(LoginRequest $request)
    {
        $user = $this->userRepository->login(
            $request->input('email'), $request->input('password'), $request->has('remember')
        );
        if ($user == false) return redirect()->back()->withErrors(['msg', __('auth.failed')]);
        if (Auth::user()->user_level == 'Administrator') return redirect()->route('management');
        return redirect()->route('/');
    }

    public function register_process(RegisterRequest $request)
    {
        $this->userRepository->register(
            $request->input('name'), $request->input('email'), $request->input('password')
        );
        return redirect()->route('/');
    }

    public function logout()
    {
        $this->userRepository->logout(Auth::user()->last_user_auth->token);
        return redirect()->route('/');
    }
}
