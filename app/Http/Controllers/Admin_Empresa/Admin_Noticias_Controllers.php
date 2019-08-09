<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Repositorios\NoticiasRepo;
use Illuminate\Http\Request;
use App\Managers\noticia_manager;



class Admin_Noticias_Controllers extends Controller
{

  protected $NoticiasRepo;

  public function __construct(NoticiasRepo $NoticiasRepo)
  {
    $this->NoticiasRepo = $NoticiasRepo;
  }


  public function getPorpiedades()
  {
    return ['name','sub_name','description','estado','url_video'];
  }

  //home admin User
  public function get_admin_noticias(Request $Request)
  { 
    $Entidades = $this->NoticiasRepo->getEntidadesAllPaginadas($Request,3);

    return view('admin.noticias.noticias_home', compact('Entidades'));
  }

  //get Crear admin User
  public function get_admin_noticias_crear()
  {  
    return view('admin.noticias.noticias_crear');
  }

  //set Crear admin User
  public function set_admin_noticias_crear(Request $Request)
  {     

    $noticia = $this->NoticiasRepo->getEntidad();

    $Propiedades = $this->getPorpiedades();

    $manager = new noticia_manager(     null, $Request->all()  );


    if ($manager->isValid())
    {

      $this->NoticiasRepo->setEntidadDato($noticia,$Request,$Propiedades );

     $this->NoticiasRepo->setImagen( $noticia ,$Request , 'img', 'Noticias/',  $noticia->name_slug .$noticia->id.'-portada'   ,'.jpg');
     $this->NoticiasRepo->setImagen( null ,$Request , 'img2', 'Noticias/', $noticia->name_slug .$noticia->id.'-adicional' ,'.jpg');

     $this->NoticiasRepo->setImagen( $noticia ,$Request , 'img', 'Noticias/',  $noticia->name_slug .$noticia->id.'-portada-chica'   ,'.jpg',250);
     
      
      return redirect()->route('get_admin_noticias')->with('alert', 'Noticia Creado Correctamente');
    }

   
    return redirect()->back()->withErrors($manager->getErrors())->withInput($manager->getData());
    
    
  }

  //get edit admin noticia
  public function get_admin_noticias_editar($id)
  {
    $Entidad = $this->NoticiasRepo->find($id);

    return view('admin.noticias.noticias_editar',compact('Entidad'));
  }

  //set edit admin marca
  public function set_admin_noticias_editar($id,Request $Request)
  {
    $noticia = $this->NoticiasRepo->find($id);

    $Propiedades = $this->getPorpiedades();

    $this->NoticiasRepo->setEntidadDato($noticia,$Request,$Propiedades );

    $this->NoticiasRepo->setImagen( $noticia ,$Request , 'img', 'Noticias/',  $noticia->name_slug .$noticia->id.'-portada'   ,'.jpg');
    $this->NoticiasRepo->setImagen( null ,$Request , 'img2', 'Noticias/', $noticia->name_slug .$noticia->id.'-adicional' ,'.jpg');

         $this->NoticiasRepo->setImagen( $noticia ,$Request , 'img', 'Noticias/',  $noticia->name_slug .$noticia->id.'-portada-chica'   ,'.jpg',250);
     $this->NoticiasRepo->setImagen( null ,$Request , 'img2', 'Noticias/', $noticia->name_slug .$noticia->id.'-adicional-chica' ,'.jpg',250);

    return redirect()->route('get_admin_noticias')->with('alert', 'Noticia Editado Correctamente');  
  }

  
}