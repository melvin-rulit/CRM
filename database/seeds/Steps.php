<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Steps extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $steps = [
            [
                'id'        => 1,
                'name'      => 'Холодный',
                'code'      => 'cold',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 2,
                'name'      => 'Тёплый',
                'code'      => 'warm',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 3,
                'name'      => 'Горячий',
                'code'      => 'hot',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 4,
                'name'      => 'Закрыт',
                'code'      => 'close',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
        ];

        DB::table('steps')->insert($steps);
    }
}
