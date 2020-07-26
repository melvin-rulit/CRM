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

    public function name($value){

        $this->builder->where('child_name', 'like', "%$value%");
    }

    public function surname($value){

        $this->builder->where('child_surname', 'like', "%$value%");
    }

    public function birthday($value){

        $this->builder->where('child_birthday', 'like', "%$value%");
    }
    
    public function filters(){

        return $this->request->all();
    }
}
