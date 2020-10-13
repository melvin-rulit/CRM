<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Loger;
use App\Statuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatusesController extends Controller
{
    public function changeCallDate(Request $request)
    {


        $date = Carbon::parse($request->call_date)->format('Y-m-d h:i:s');
        $dateFormat = Carbon::parse($request->call_date)->format('d.m.Y');

        $statuses = Statuses::where('base_id', $request->id)->update(['call_date' => $date]);

        // Добавляем в лог информацию что клиент изменил дату звонка
        loger(4, $request->id, 'Сменил дату звонка на ' . $dateFormat);
    }

    public function changeCallStatus(Request $request)
    {

        $statuses = Statuses::where('base_id', $request->id)->update(['call_status' => $request->call_status]);

        $call_status = $request->call_status == 1 ? ' Дозвон' : ' Не дозвон';

        // Добавляем в лог информацию что клиент изменил статус звонка
        loger(4, $request->id, 'Сменил статус звонка на' . $call_status);


        if ($request->comment) {

            // Прибавляем 8 часов к дате звонка
            $statuses = Statuses::query()->where('base_id', $request->id)->first();

            $statuses->update([
                'call_date' => Carbon::parse($statuses->call_date)->addHours(8)
            ]);


            // Добавляем в лог коментарий
            loger(5, $request->id, $request->comment);

        }
    }
}
