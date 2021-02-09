<?php

use App\Loger;
use Illuminate\Support\Facades\Auth;

/**
 * Логирование данных
 *
 *  1 = Пользовтаели
 *  2 = База
 *  3 = Регионы и филиалы
 *  4 = Статусы
 *  5 = Комментарии
 *  6 = Склады
 *  7 = Коментарии товарных позиций склада
 *
 */

function loger($chanel, $base_id = null, $warehouse_article_id = null, $message = null)
{
    Loger::create([
            'user_id' => Auth::id(),
            'channel' => $chanel,
            'base_id' => $base_id,
            'level_name' => 'success',
            'warehouse_article_id' => $warehouse_article_id,
            'message' => $message
        ]
    );
}
