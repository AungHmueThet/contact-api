<?php

namespace App\Http\Resources;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

//        if($this->contact_id == $favourite->contact()->id ){
//            return
//        }
       return parent::toArray($request);
    }
}
