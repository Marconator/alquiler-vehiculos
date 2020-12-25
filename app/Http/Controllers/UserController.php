<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

  /**
   * Return all users
   *
   * @return \App\Models\User;
   */
  public function index()
  {
      return User::all();
  }

  /**
   * Return user profile
   *
  * @param  \Illuminate\Http\Request  $request
   * @param  \Integer  $int
   * @return \App\Models\User;
   */
  public function show(Request $request, $id)
  {
    $user = User::findOrFail($id);
    if(!Hash::check($request->bearerToken(), $user->auth_token))
    {
      abort(401, "Invalid credentials for this resource.");
    }
      $rentOrders = $user->rentOrders;
      return $user;
  }

}
