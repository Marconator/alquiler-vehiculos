<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  /**
   * Register a new user
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \App\Models\User;
   */
  public function register(Request $request)
  {
    $validated = $request->validate([
    'name' => 'required',
    'password' => 'required|between:12,25',
    'email' => 'required|email|unique:App\Models\User,email'
    ]);

    $request->merge(['password' => Hash::make($request->password)]);
    return User::create($request->all());
  }
}
