<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends Controller
{
    public function signup(Request $request) {

      if(!$user = JWTAuth::parseToken()->authenticate()) {
        return response()->json(['msg' => 'Usuário não encontrado']);
      }

      $this->validate($request, [
        'name' => 'required',
        'email' => 'email|required|unique:users',
        'password' => 'required'
      ]);

      $user = new User;
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->save();

      return response()->json(['msg' => 'Usuario criado com sucesso']);
    }
    public function signin(Request $request) {
      $this->validate($request, [
        'email' => 'email|required',
        'password' => 'required'
      ]);

      $credentials = $request->only('email', 'password');

      try {
        if(!$token = JWTAuth::attempt($credentials)) {
          return response()->json(['error' => 'Credenciais invalidas']);
        }
      } catch(JWTException $e) {
        return response()->json(['Nao foi possivel gerar o token']);
      }
      return response()->json(['token' => $token]);
    }
}
