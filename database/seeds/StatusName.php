<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StatusName extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusName = [
            [
                'id'        => 1,
                'name'      => 'Новый',
                'code'      => 'new',
                'color'     => '#00FF00',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 2,
                'name'      => 'В работе',
                'code'      => 'work',
                'color'     => '#FFD700',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 3,
                'name'      => 'Запись на ПК',
                'code'      => 'new_pk',
                'color'     => '#00FFFF',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 4,
                'name'      => 'Явка на ПК',
                'code'      => 'ok_pk',
                'color'     => '#008080',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 5,
                'name'      => 'Покупка ВМ',
                'code'      => 'new_vm',
                'color'     => '#008080',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 6,
                'name'      => 'Явка на ВМ 1',
                'code'      => 'ok_vm_1',
                'color'     => '#008080',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 7,
                'name'      => 'Явка на ВМ 2',
                'code'      => 'ok_vm_2',
                'color'     => '#008080',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 8,
                'name'      => 'Явка на ВМ 3',
                'code'      => 'ok_vm_3',
                'color'     => '#008080',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 9,
                'name'      => 'Занимается',
                'code'      => 'success',
                'color'     => '#008080',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 10,
                'name'      => 'Продление',
                'code'      => 'extension',
                'color'     => '#008080',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id'        => 11,
                'name'      => 'Архив',
                'code'      => 'archive',
                'color'     => '#008080',
                'active'    => 1,
                'created_at' => Carbon::now(),
            ],
        ];

        DB::table('status_names')->insert($statusName);
    }
}
