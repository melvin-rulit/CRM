<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /*
 * Фильтр по имени пользователя.
 *
 * @var string
 */
    public function name($name)
    {
        return $this->where('name', 'LIKE', '%' . $name . '%');
    }

    /*
 * Фильтр по фамилии клиента.
 *
 * @var string
 */
    public function surname($surname)
    {
        return $this->where('surname', 'LIKE', '%' . $surname . '%');
    }

    /*
 * Фильтр по телефону.
 *
 * @var string
 */
    public function phone($phone)
    {
        return $this->where('phone', 'LIKE', '%' . $phone . '%');
    }

    /*
* Фильтр по логину или Email.
*
* @var string
*/
    public function email($email)
    {
        return $this->where('email', 'LIKE', '%' . $email . '%');
    }
}
