<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      $faker = (new \Faker\Factory())::create();
      $faker->addProvider(new \Faker\Provider\Fakecar($faker));

        return [
            'model' => $faker->vehicle,
            'description' => ('Motor '.$this->faker->randomElement($array = array ('1500','1600','1800','1700','2000')).' cc, '.$this->faker->randomElement($array = array ('Gasolina','Diesel')).', '.$this->faker->randomElement($array = array ('4','8','6')).' cilindros.'),
            'rate' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 12, $max = 70),
        ];
    }
}
