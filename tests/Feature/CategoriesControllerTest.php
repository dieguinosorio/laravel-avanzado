<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Categories;
use Laravel\Sanctum\Sanctum;
use App\User;
class CategoriesControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        //Se agrega este metodo el el setup para no tenerlo que hacer manualmente en los demas test
        //Crea una autenticacion de token para poder ejecutar los test
        Sanctum::actingAs(
            factory(User::class)->create()
        );
    }

    public function test_index(){
        factory(Categories::class,3)->create();//Crearmos las categorias de prueba
        $response = $this->getJson('/api/categories');//Luego hacemos una peticion get a la url 
        $response->assertSuccessful();//Comprobamos que la respuesta tiene una respuesta exitosa 200 o 300
        //$response->assertJsonCount(3,'data');//Comprueba que la respuesta JSON tiene una matriz con la cantidad esperada de elementos en la clave dada:
    }

    public function test_create_new_categorie(){
        $data = [
            'name' => 'Camisetas',
            'inactive' => 0,
        ];
        $response = $this->postJson('/api/categories', $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_update_categories()
    {
        /** @var Categories $categories */
        $categories = factory(Categories::class)->create();

        $data = [
            'name' => 'Camisetas',
            'inactive' => 0,
        ];
        
        $response = $this->patchJson("/api/categories/{$categories->getKey()}", $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_show_categories()
    {
        /** @var Categories $categorie */
        $categorie = factory(Categories::class)->create();
        $response = $this->getJson("api/categories/{$categorie->getKey()}");
        $response->assertSuccessful();
        $response->assertJsonCount(0,'data');
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_delete_categories()
    {
        /** @var Categories $categorie */
        $categorie = factory(Categories::class)->create();
        $response = $this->deleteJson("api/categories/{$categorie->getKey()}");
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }


}
