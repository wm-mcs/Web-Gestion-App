<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositorios\TipoDeMovimientoRepo;

class TipoDeMovimientosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testConexion()
    {
    	$Repo = new TipoDeMovimientoRepo();

    	$TipoDeMovimientos = $Repo->getEntidadActivasOrdenadasSegun('name','asc');    	

    	if( $TipoDeMovimientos->count() > 0)
    	{
    	  $this->assertTrue(true);
    	}
    	else
    	{
    	  $this->assertTrue(false);
    	}        
    }
}
