<?php 

namespace App\Repositorios;

use App\Entidades\Empresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class EmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new Empresa();
  }


  public function getEmpresaDatos()
  {
     return $this->getEntidad()->find(1);
  }

  public function setDatos($request)
  {
    $Empresa = $this->getEmpresaDatos();

    $Propiedades = ['name','slogan','vision','mision','telefono','direccion','horarios_dias','celular','email','email_no_reply','palabras_claves','descripcion_breve'];  
    
    $this->setEntidadDato($Empresa,$request,$Propiedades);
       

      $this->setImagen($Empresa,$request,'logo_cuadrado','Empresa/','logo_cuadrado','.png');
      $this->setImagen($Empresa,$request,'logo_horizontal','Empresa/','logo_horizontal','.png');
      $this->setImagen($Empresa,$request,'logo_vertical','Empresa/','logo_vertical','.png');

    $Empresa->save();   
  }
}
