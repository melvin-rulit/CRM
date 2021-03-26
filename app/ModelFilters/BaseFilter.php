<?php

namespace App\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class BaseFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /*
     * Фильтр по фамилии клиента.
     *
     * @var string
     */
    public function surname($child_surname) {

        return $this->where('child_surname', 'LIKE', '%' . $child_surname);
    }

    /*
     * Фильтр по имени клиента.
     *
     * @var string
     */
    public function name($child_name) {

        return $this->where('child_name', 'LIKE', '%' . $child_name);
    }

    /*
     * Фильтр по году рождения клиента.
     *
     * @var string (year)
     */
    public function birthday($birthday) {

        return $this->where('child_birthday', 'LIKE', '%' . $birthday);
    }

    /*
     * Фильтр по телефону.
     *
     * @var string
     */
    public function phone($phone) {

        return $this->where(function($q) use ($phone)
        {
            return $q->where('mother_phone', 'LIKE', '%' . $phone)
                ->orWhere('mother_dop_phone', 'LIKE', $phone)
                ->orWhere('father_phone', 'LIKE', $phone)
                ->orWhere('father_dop_phone', 'LIKE', $phone)
                ->orWhere('other_relative_phone', 'LIKE', $phone)
                ->orWhere('other_relative_phone', 'LIKE', $phone)
                ->orWhere('other_relative_dop_phone', 'LIKE', '%' . $phone.'%');
        });
    }

    /*
     * Действующий контракт - все у кого на данный момент действует контракт
     *
     */
    public function activeContract($type){

        if ($type){
            return $this->related('contracts', 'end_actually', '>',
                Carbon::today()->toDateString());
        }
    }

    /*
     * Контракт закончился - все у кого окончился контракт
     *
     */
    public function notActiveContract($type){

        if ($type){
            return $this->related('contracts', 'end_actually', '<',
                Carbon::today()->toDateString());
        }
    }

    /*
     * Окончание контракта до - все у кого дата окончания контракта меньше введенной даты
     *
     */
    public function contractBefore($date){


        $this->related('contracts', function($query) use ($date) {
            return $query->where('end_actually', '>=' , $date);
        });

    }

    /*
     * Окончание контракта после - все у кого дата окончания контракта больше введенной даты
     *
     */
    public function contractAfter($date){

        $this->related('contracts', function($query) use ($date) {
            return $query->where('end_actually', '<=', $date);
        });
    }

//    /*
//     * Возраст от - Все у кого актуальный возраст больше введенного значения
//     *
//     */
//    public function ageAfter($age){
//
//        return $this->where('child_birthday', '>', '%' . Carbon::now()->subYear($age)->format('Y'));
//    }
//
//    /*
//     * Возраст до - Все у кого актуальный возраст меньше введенного значения
//     *
//     */
//    public function ageBefore($date){
//
//
//    }

}
