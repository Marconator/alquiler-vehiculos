<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
  /**
   * Login
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \App\Models\User;
   */
  public function login(Request $request)
  {
    $validated = $request->validate([
      'email' => 'email|required',
      'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password))
    {
      abort(401, "Wrong credentials.");
    }
    $user->tokens()->delete();
    $token = $user->createToken('user-token')->plainTextToken;
    $user->auth_token = Hash::make($token);
    $user->save();

    $response = ['user' => $user, 'token' => $token];
    return response($response,200);
  }

  /**
   * Logout
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Integer  $int
   * @return Symfony\Component\HttpFoundation\Response
   */
  public function logout(Request $request, $id)
  {
    $user = User::findOrFail($id);
    if(!Hash::check($request->bearerToken(), $user->auth_token))
    {
      abort(401, "Invalid credentials for this transaction.");
    }
    $user->tokens()->delete();
    $user->auth_token = "";
    $user->save();
    $response = ['status' => 200, 'message' => 'Successful logout'];
    return response($response,200);
  }

}
