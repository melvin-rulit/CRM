<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Schedule_hallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'time'                => $this->time,
            'day'                 => $this->day,
            'total_children'      => $this->total_children,
            'category_time'       => $this->category_time,
            'children_count'      => $this->group->children->count(),
            'programm'            => $this->group->programm,
            'group'               => $this->group,
            // Метод group->programm->map->only('id', 'name') не работает по чему то
        ];
    }
}
