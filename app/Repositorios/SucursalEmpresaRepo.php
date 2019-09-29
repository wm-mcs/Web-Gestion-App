<?php 

namespace App\Repositorios;

use App\Entidades\SucursalEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class SucursalEmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new SucursalEmpresa();
  }



  public function crearSucursal($Request)
  {
  	$Entidad = $this->getEntidad();

  	$Propiedades = ['name','telefono','direccion','empresa_id'];

  	$this->setEntidadDato($Entidad,$Request,$Propiedades);
  }


  public function editarSucursal($Request)
  {
  	$Entidad = $this->find($Request->get('id'));

  	$Propiedades = ['name','telefono','direccion','empresa_id'];

  	$this->setEntidadDato($Entidad,$Request,$Propiedades);
  }


 


  
}