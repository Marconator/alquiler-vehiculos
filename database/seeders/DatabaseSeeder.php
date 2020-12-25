<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Car;
use App\Models\RentOrders;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      Schema::disableForeignKeyConstraints();
      User::truncate();
      Car::truncate();
      RentOrders::truncate();
      Schema::enableForeignKeyConstraints();

      User::factory()
      ->times(3)
      ->create();

      Car::factory()
      ->times(10)
      ->create();

      DB::table('rent_orders')->insert([
        'car_id' => 1,
        'user_id' => 1,
        'starting_date' => '2021/1/1',
        'ending_date' => '2020/1/12',
      ]);
    }
}
