<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaRepo;
use Illuminate\Http\Request;



class Admin_Datos_Corporativos_Controller extends Controller
{

  protected $Empresa;

  public function __construct(EmpresaRepo $EmpresaRepo)
  {
    $this->Empresa = $EmpresaRepo;
  }

  public function get_datos_corporativos()
  {

    $Empresa = $this->Empresa->getEmpresaDatos();

    return view('admin.empresa.empresa_home', compact('Empresa'));
  }

  public function set_datos_corporativos(Request $Request)
  {
     

    $Empresa = $this->Empresa->getEmpresaDatos();

      $Propiedades = ['name','slogan','vision','mision','telefono','direccion','horarios_dias','celular','email','email_no_reply','palabras_claves','descripcion_breve','facebook_url','instagram_url','twitter_url','linkedin_url','youtube_url','Whatsapp_cel'];  
    
      $this->Empresa->setEntidadDato($Empresa,$Request,$Propiedades);
       

      $this->Empresa->setImagen($Empresa,$Request,'logo_cuadrado','Empresa/','logo_cuadrado','.png');
      $this->Empresa->setImagen($Empresa,$Request,'logo_horizontal','Empresa/','logo_horizontal','.png');
      $this->Empresa->setImagen($Empresa,$Request,'logo_vertical','Empresa/','logo_vertical','.png');

      $Empresa->save();  

    return redirect()->back()->with('alert', 'has actualizado la información de manera correcta');
  }
}