<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositorios\ProyectoRepo;
use App\Repositorios\ImgProyectoRepo;
use App\Managers\Proyecto\crear_proyecto_admin_manager;




class Admin_Proyectos_Controllers extends Controller
{

  protected $ProyectoRepo;
  protected $ImgProyectoRepo;

  public function __construct(ProyectoRepo    $ProyectoRepo, 
                              ImgProyectoRepo $ImgProyectoRepo)
  {
    $this->ProyectoRepo    =  $ProyectoRepo;
    $this->ImgProyectoRepo =  $ImgProyectoRepo;
  }

  public function get_admin_proyectos(Request $Request)
  {

    $proyectos = $this->ProyectoRepo->getEntidadesAllPaginadas($Request,20);

    return view('admin.proyectos.proyectos_home', compact('proyectos'));
  }



  //get Crear 
  public function get_admin_proyectos_crear()
  {  
    return view('admin.proyectos.proyectos_crear');
  }



  //set 
  public function set_admin_proyectos_crear(Request $Request)
  {     
      
      $Proyecto    = $this->ProyectoRepo->getEntidad();

      $Proyecto->estado = 'si';      

      $Propiedades = ['name','description','fecha','ubicacion','metodo_de_construccion','autores']; 
     

      $manager = new crear_proyecto_admin_manager(null, $Request->all());

      //valido la data
      if ($manager->isValid())
      {
       $this->ProyectoRepo->setEntidadDato($Proyecto,$Request,$Propiedades); 

       //utilzo la funciona creada en el controlador para subir la imagen
       $this->set_admin_proyectos_img($Proyecto->id, $Request);  

       return redirect()->route('get_admin_proyectos')->with('alert', 'Proyecto Creado Correctamente');       
      }  

    
      return redirect()->back()->withErrors($manager->getErrors())->withInput($manager->getData());        

     
    
  }


  //get edit admin proyecto
  public function get_admin_proyectos_editar($id)
  {
    $proyecto = $this->ProyectoRepo->find($id);

    return view('admin.proyectos.proyectos_editar',compact('proyecto'));
  }

  //set edit admin proyecto
  public function set_admin_proyectos_editar($id,Request $Request)
  {
    $Proyecto = $this->ProyectoRepo->find($id);

    $Propiedades = ['name','description','estado','fecha','ubicacion','metodo_de_construccion','autores'];
      
    $this->ProyectoRepo->setEntidadDato($Proyecto,$Request,$Propiedades); 

    $this->ProyectoRepo->setImagen($Proyecto,$Request,'img','ProyectoImagenPrincipal/',$Proyecto->id ,'.png'); 

    return redirect()->route('get_admin_proyectos')->with('alert', 'Proyecto Editado Correctamente');  
  }

 

  //subo img adicional
  public function set_admin_proyectos_img($id_proyecto,Request $Request)
  {   
      //archivos imagenes
      $files = $Request->file('img');

      if(!empty($files))
      {
        foreach($files as $file)
        {           

          $this->ImgProyectoRepo->set_datos_de_img($file,$this->ImgProyectoRepo->getEntidad(),'proyecto_id',$id_proyecto,$Request,'ProyectosImagenesAdicionales/' );
                    
        }
        
      }

      return redirect()->back()->with('alert', 'Imagen Subida Correctamente');
      
  }


  //elimino img adicional
  public function delete_admin_proyectos_img($id_img)
  {
      $this->ImgProyectoRepo->destroy_entidad($id_img);

      return redirect()->back()->with('alert-rojo', 'Imagen Eliminada');
  }

  //fijo como imagen principal 
  public function establecer_como_imagen_principal($id_img)
  {
      $this->ImgProyectoRepo->cambio_a_imagen_principal($id_img);

      return redirect()->back()->with('alert', 'Imagen principal cambiada');
  }

  
}