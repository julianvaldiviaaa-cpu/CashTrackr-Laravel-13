<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view("Auth.login");
    }

    public function store(SignInRequest $request){
        $data = $request->validated();

        if(!Auth::attempt($data, true)){
            return back()->with("error", "Contraseña Incorrecta.");
        }

        return redirect()->route("dashboard");
    }
}
