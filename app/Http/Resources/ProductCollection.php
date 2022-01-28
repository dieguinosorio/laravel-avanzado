<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    //Con esta variable publica le decimos que convierta la coleccion en tipo ProductResource que tiene la conversion de datos
    public $collects = ProductResource::class;
    
    public function toArray($request)
    {
        return [
            'data'=>$this->collection,
            'links'=> 'metadata'
        ];
    }
}
