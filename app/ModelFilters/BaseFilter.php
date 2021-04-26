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
    public function surname($child_surname)
    {
        return $this->where('child_surname', 'LIKE', "%$child_surname%");
    }

    /*
     * Фильтр по имени клиента.
     *
     * @var string
     */
    public function name($child_name)
    {
        return $this->where('child_name', 'LIKE', "%$child_name%");
    }

    /*
     * Фильтр по году рождения клиента.
     *
     * @var string (year)
     */
    public function yearBirthday($birthday)
    {
        return $this->where('birthday', 'LIKE', "%$birthday%");
    }

    /*
     * Фильтр по телефону.
     *
     * @var string
     */
    public function phone($phone)
    {
        return $this->where(function($q) use ($phone)
        {
            return $q->where('mother_phone', 'LIKE', "%$phone%")
                ->orWhere('mother_dop_phone', 'LIKE', "%$phone%")
                ->orWhere('father_phone', 'LIKE', "%$phone%")
                ->orWhere('father_dop_phone', 'LIKE', "%$phone%")
                ->orWhere('other_relative_phone', 'LIKE', "%$phone%")
                ->orWhere('other_relative_phone', 'LIKE', "%$phone%")
                ->orWhere('other_relative_dop_phone', 'LIKE', "%$phone%");
        });
    }

    /*
     * Действующий контракт - все у кого на данный момент действует контракт
     *
     */
    public function activeContract($type)
    {
        if ($type == 'active'){
            return $this->related('contracts', 'end_actually', '>',
                Carbon::today()->toDateString());
        }

        if ($type == 'notActive'){
            return $this->related('contracts', 'end_actually', '<',
                Carbon::today()->toDateString());
        }
    }


    /*
     * Окончание контракта до - все у кого дата окончания контракта меньше введенной даты
     *
     */
    public function contractDate($date)
    {
        if ($date[0] && $date[1]){
            $this->related('contracts', function($query) use ($date) {
                return $query->whereBetween('end_actually', [$date[0], $date[1]]);
            });
        }

        if ($date[0] && !$date[1]){
            $this->related('contracts', function($query) use ($date) {
            return $query->where('end_actually', '>=' , $date[0]);
            });
        }

        if (!$date[0] && $date[1]){
            $this->related('contracts', function($query) use ($date) {
                return $query->where('end_actually', '<=' , $date[1]);
            });
        }
    }

    /*
     * Тип контракта
     *
     */
    public function typeContract($type)
    {
        if ($type == 'vm'){
            return $this->related('contracts', 'contract_type', '=', 'vm');
        }

        if ($type == 'main'){
            return $this->related('contracts', 'contract_type', '=', 'main');
        }
    }


    /*
     * Возраст between
     *
     */
    public function birthdayDate($age){

        if ($age[0] && $age[1]){
            $this->whereBetween('birthday',
                [Carbon::now()->subYear($age[1]), Carbon::now()->subYear($age[0])]);
        }

        if ($age[0] && !$age[1]){
            return $this->where('birthday', '>=', Carbon::now()->subYear($age[0])->format('Y'));
        }

        if (!$age[0] && $age[1]){
            return $this->where('birthday', '<=', Carbon::now()->subYear($age[1])->format('Y'));
        }
    }

    /*
     * Программа в контракте
     *
     */
    public function programm($programm)
    {
        if ($programm){
            $this->related('contracts', function($query) use ($programm) {
                return $query->whereIn('programm', $programm);
            });
        }
    }


}
