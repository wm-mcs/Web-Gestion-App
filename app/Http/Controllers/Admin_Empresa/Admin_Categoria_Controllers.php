<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Repositorios\CategoriaRepo;
use Illuminate\Http\Request;
use App\Managers\Users\user_admin_crear;



class Admin_Categoria_Controllers extends Controller
{

  protected $CategoriaRepo;

  public function __construct(CategoriaRepo $CategoriaRepo)
  {
    $this->CategoriaRepo = $CategoriaRepo;
  }


  public function getPropiedades()
  {
    return  ['name','description','estado'];
  }

  //home admin User
  public function get_admin_categorias(Request $Request)
  { 
    $Categorias = $this->CategoriaRepo->getEntidadesAllPaginadas($Request,20);

    //mostrar marcas de la a a la z (orden)

    return view('admin.categorias.categorias_home', compact('Categorias'));
  }

  //get Crear admin User
  public function get_admin_categorias_crear()
  {  
    return view('admin.categorias.categorias_crear');
  }

  //set Crear admin User
  public function set_admin_categorias_crear(Request $Request)
  {     

      //propiedades para crear
      $Propiedades = $this->getPropiedades();

      //traigo la entidad
      $Categoria = $this->CategoriaRepo->getEntidad();

      //grabo todo las propiedades
      $this->CategoriaRepo->setEntidadDato($Categoria,$Request,$Propiedades);     

      //para la imagen
      $this->CategoriaRepo->setImagen($Categoria,$Request,'img','Categoria/', $Categoria->name,'.png'); 

     return redirect()->route('get_admin_categorias')->with('alert', 'Creado Correctamente');
    
  }

  //get edit admin marca
  public function get_admin_categorias_editar($id)
  {
    $Categoria = $this->CategoriaRepo->find($id);

    return view('admin.categorias.categorias_editar',compact('Categoria'));
  }

  //set edit admin marca
  public function set_admin_categorias_editar($id,Request $Request)
  {
    $Categoria   = $this->CategoriaRepo->find($id);    

    //propiedades para crear
    $Propiedades = $this->getPropiedades();     

    //grabo todo las propiedades
    $this->CategoriaRepo->setEntidadDato($Categoria,$Request,$Propiedades);

    $this->CategoriaRepo->setImagen($Categoria,$Request,'img','Categoria/', $Categoria->name,'.png');

    return redirect()->route('get_admin_categorias')->with('alert', 'Editado Correctamente');  
  }

  
}