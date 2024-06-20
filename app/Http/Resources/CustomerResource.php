<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'contact' => $this->contact,
            'full_address' => $this->full_address,
            'order_details' =>  new OrderDetailsResourceCollection(
                $this->order_details()->select(DB::raw('max(order_details.created_at) as max_created_at'), DB::raw('*'))
                    ->groupBy('item_id')
                    ->get()
            )
        ];
    }
}
