<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Repositorios\MarcaRepo;
use Illuminate\Http\Request;
use App\Managers\Users\user_admin_crear;



class Admin_Marcas_Controllers extends Controller
{

  protected $MarcaRepo;

  public function __construct(MarcaRepo $MarcaRepo)
  {
    $this->MarcaRepo = $MarcaRepo;
  }

  //home admin User
  public function get_admin_marcas(Request $Request)
  { 
    $marcas = $this->MarcaRepo->getMarcasParaAdminOrdenadasAlfabeticamente($Request,30);

    //mostrar marcas de la a a la z (orden)

    return view('admin.marcas.marcas_home', compact('marcas'));
  }

  //get Crear admin User
  public function get_admin_marcas_crear()
  {  
    return view('admin.marcas.marcas_crear');
  }

  //set Crear admin User
  public function set_admin_marcas_crear(Request $Request)
  {     

      //propiedades para crear
      $Propiedades = ['name','description','estado','rank'];

      //traigo la entidad
      $marca = $this->MarcaRepo->getEntidad();

      //grabo todo las propiedades
      $this->MarcaRepo->setEntidadDato($marca,$Request,$Propiedades);     

      //para la imagen
      $this->MarcaRepo->setImagen($marca,$Request,'img','Marcas/', $marca->name,'.png'); 

     return redirect()->route('get_admin_marcas')->with('alert', 'Marca Creado Correctamente');
    
  }

  //get edit admin marca
  public function get_admin_marcas_editar($id)
  {
    $marca = $this->MarcaRepo->find($id);

    return view('admin.marcas.marcas_editar',compact('marca'));
  }

  //set edit admin marca
  public function set_admin_marcas_editar($id,Request $Request)
  {
    $marca = $this->MarcaRepo->find($id);    

    //propiedades para crear
    $Propiedades = ['name','description','estado','rank'];    

    //grabo todo las propiedades
    $this->MarcaRepo->setEntidadDato($marca,$Request,$Propiedades);

    $this->MarcaRepo->setImagen($marca,$Request,'img','Marcas/', $marca->name,'.png');

    return redirect()->route('get_admin_marcas')->with('alert', 'Marca Editado Correctamente');  
  }

  
}