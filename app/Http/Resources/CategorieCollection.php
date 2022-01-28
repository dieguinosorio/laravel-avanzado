<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategorieCollection extends ResourceCollection
{
    public $collects = CategorieResource::class;
    public function toArray($request)
    {
        return [
            'data'=>$this->collection,
            'links'=>'metadata'
        ];
    }
}
