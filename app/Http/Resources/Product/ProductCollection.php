<?php

namespace App\Http\Resources\Product;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;


class ProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[

       'name' => $this->name,
            
        'description' => $this->detail,
        
        'price' => $this->price,
        'href' => [
            'url' => route('products.show',$this->id)
        ]

        
        ];
    }
}
