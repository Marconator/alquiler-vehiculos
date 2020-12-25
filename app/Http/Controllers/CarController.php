<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{

  /**
   * Return all available cars
   *
   * @return \App\Models\Car;
   */
  public function index()
  {
      return Car::all();
  }
}
