<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Resources\CategorieCollection;
use App\Http\Resources\CategorieResource;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use App\User;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  new CategorieCollection(Categories::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categorie = Categories::create($request->all());
        return $categorie;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     * Aqui se realiza inyeccion de dependencias, entonces retornamos el objeto de la categoria
     */
    public function show(Categories $categories)
    {
        return new CategorieResource($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $categories)
    {
        $categories->update($request->all());
        return $categories;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $categories)
    {
        $categories->delete();
        return response()->json();
    }
}
