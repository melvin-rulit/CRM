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
    public function changeCallDate(Request $request){

        $date = Carbon::parse($request->call_date)->format('Y-m-d h:i:s');
        $dateFormat = Carbon::parse($request->call_date)->format('d.m.Y');

        $statuses = Statuses::where('base_id', $request->id)->update(['call_date' => $date]);

//         Добавляем в лог информацию что клиент изменил дату звонка
        Loger::create(array(
                'user_id' => Auth::id(),
                'channel' => '4',
                'base_id' => $request->id,
                'level_name' => 'success',
                'message' => 'Сменил дату звонка на '.$dateFormat)
        );
    }

    public function changeCallStatus(Request $request){

        $statuses = Statuses::where('base_id', $request->id)->update(['call_status' => $request->call_status]);

        $call_status = $request->call_status == 1 ? ' Дозвон' : ' Не дозвон';

//         Добавляем в лог информацию что клиент изменил статус звонка
        Loger::create(array(
                'user_id' => Auth::id(),
                'channel' => '4',
                'base_id' => $request->id,
                'level_name' => 'success',
                'message' => 'Сменил статус звонка на' . $call_status)
        );
    }
}
