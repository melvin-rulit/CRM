<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class UsersFilter
{
    protected $builder;

    protected $request;

    public function __construct(Request $request){

        $this->request = $request;
    }

    public function apply($builder){

    	$this->builder = $builder;

    	foreach ($this->filters() as $filter => $value) {

    		if (method_exists($this, $filter)) {
    			$this->$filter($value);
    		}

    	}

        return $this->builder;
    }

    // Фильтруем по имени
    public function name($value){

        $this->builder->where('child_name', 'like', "%$value%");
    }

    // Фильтруем по фамилии
    public function surname($value){

        $this->builder->where('child_surname', 'like', "%$value%");

    }

    // Фильтруем по дню рождении
    public function birthday($value){

        $this->builder->where('child_birthday', 'like', "%$value%");
    }

    // Фильтруем по все возможным номерам
    public function phone($value){

        $this->builder->where('mother_phone', 'like', "%$value%")
            ->orWhere('mother_dop_phone', 'like', "%$value%")
            ->orWhere('father_phone', 'like', "%$value%")
            ->orWhere('father_dop_phone', 'like', "%$value%")
            ->orWhere('other_relative_phone', 'like', "%$value%")
            ->orWhere('other_relative_dop_phone', 'like', "%$value%");
    }

    public function filters(){

        return $this->request->all();
    }
}
