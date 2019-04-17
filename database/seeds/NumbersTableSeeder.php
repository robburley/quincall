<?php

use App\Number;
use Illuminate\Database\Seeder;

class NumbersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Number::create([
            'number'   => '447403936678',
            'user_id'  => 1,
        ]);
    }
}
