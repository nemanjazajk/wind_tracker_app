<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiWindResource extends JsonResource
{
    /**s
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'currentWindSpeed' =>$this->currentWindSpeed,
            'created_at'       =>$this->created_at,
            'currentState'     =>$this->currentState,
            'eventError'       =>$this->eventError
            
        ];
    }
}
