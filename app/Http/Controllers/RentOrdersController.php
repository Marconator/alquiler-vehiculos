<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RentOrders;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use DateTime;

class RentOrdersController extends Controller
{

  /**
   * Return all orders
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \App\Models\RentOrders;
   */
  public function index()
  {
      return RentOrders::all();
  }

  /**
   * Delete an order
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function delete(Request $request, $id)
  {
      $rentOrder = RentOrders::findOrFail($id);
      $user = $rentOrder->user;
      if(!Hash::check($request->bearerToken(), $user->auth_token))
      {
        abort(401, "Invalid credentials for this transaction.");
      }
      $rentOrder->delete();
      $response = ['status' => 200, 'message' => 'Order deleted.'];
      return response($response,200);
  }

  /**
   * Create new order
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \App\Models\RentOrders;
   */
  public function create(Request $request)
  {
    $validated = $request->validate([
    'starting_date' => 'required|date_format:Y-m-d',
    'ending_date' => 'required|date_format:Y-m-d|after_or_equal:starting_date',
    'car_id' => 'required|exists:App\Models\Car,id',
    'user_id' => 'required|exists:App\Models\User,id'
    ]);
      $user = User::find($request->user_id);
      if(!Hash::check($request->bearerToken(), $user->auth_token))
      {
        abort(401, "Invalid credentials for this transaction.");
      }
      $carRentOrders = Car::find($request->car_id)->rentOrders;

      if($this->noCollision($carRentOrders, $request)){
          return RentOrders::create($request->all());
      } else {
        abort(403, "Car is already reserved for the selected dates.");
      }

  }

  /**
   * Check there are no date collisions
   *
   * @param  Illuminate\Database\Eloquent\Collection  $carRentOrders
   * @param  \Illuminate\Http\Request  $request
   * @return boolean;
   */
  private function noCollision(Collection $carRentOrders, Request $request)
  {
    $noDateCollision= $carRentOrders->every(function ($value, $key) use ($request) {

        $starting_date = new DateTime($value->starting_date);
        $ending_date = new DateTime($value->starting_date);

        $new_starting_date = new DateTime($request->starting_date);
        $new_ending_date = new DateTime($request->ending_date);

        $starting_date_collision = $new_starting_date>$starting_date && $new_starting_date<$ending_date;
        $ending_date_collision = $new_ending_date>$starting_date && $new_ending_date<$ending_date;

        $engulfing_collision = $new_starting_date<=$starting_date && $new_ending_date>=$ending_date;

        return ($starting_date_collision == false && $ending_date_collision == false && $engulfing_collision == false);
    });
    return $noDateCollision;
  }
}
