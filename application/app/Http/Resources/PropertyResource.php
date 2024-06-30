<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        $amenities=amentities()->whereIn('id',$this->amenities)->toArray();
        $discount_amount=($this->roomsData()->first()?->discount_percent/100)*($this->roomsData()->first()->onepersonprice??0);
         $price_before_discount=$this->onepersonprice+$discount_amount;
         $avg_rating=$this->ratings()->avg('rating')??0;
        return [
            'name'=>$this->name,
            'id'=>$this->id,
            'price'=>$this->roomsData()->first()?->onepersonprice??null,
            'discount_percent'=>$this->roomsData()->first()?->discount_percent??0,
            'price_before_discount'=>$price_before_discount,
            'hourlyprice'=>$this->roomsData()->first()?->hourlyprice??0,
            'thumbnail'=>$this->thumbnail?getImageUrl($this->thumbnail):null ,
            'address'=>$this->address,
            'avg_rating'=> number_format($avg_rating, 0),
            'rating_count'=>$this->ratings()->get()->count(),
            'amenitiesList'=>$amenities,
            'route'=>route('place_detail', $this->slug),
            'couple_friendly'=>$this->couple_friendly??null
        ];
    }

}
