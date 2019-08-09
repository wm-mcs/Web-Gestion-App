<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Repositorios\HomeWebRepo;
use Illuminate\Http\Request;
use App\Repositorios\ImgHomeRepo;



class Admin_HomeWeb_Controllers extends Controller
{

  protected $HomeWebRepo;
  protected $ImgHomeRepo;

  public function __construct(HomeWebRepo $HomeWebRepo,
                              ImgHomeRepo $ImgHomeRepo  )
  {
    $this->HomeWebRepo = $HomeWebRepo;
    $this->ImgHomeRepo = $ImgHomeRepo;
  }

  public function get_datos_home_web()
  {

    $Home = $this->HomeWebRepo->getHomeWebDatos();

    return view('admin.home.home_web_home', compact('Home'));

    
  }

  public function set_datos_home_web(Request $Request)
  {
    $this->HomeWebRepo->setDatos($Request);

    return redirect()->back()->with('alert', 'has actualizado la información de manera correcta');
  }


  public function set_img_home(Request $Request)
  {
    $this->ImgHomeRepo->setDatos($Request);
    
    return redirect()->back()->with('alert', 'has subido una imagen al Home');
  }


  public function get_img_home($id)
  {
    $Imagen = $this->ImgHomeRepo->find($id);
    return view('admin.home.editarImagen', compact('Imagen'));
  }

  public function edit_img_home($id,Request $Request)
  {
    $Imagen = $this->ImgHomeRepo->find($id);

     $this->ImgHomeRepo->setAdminEdit($Imagen,$Request);
    
    return redirect()->back()->with('alert', 'has editado una imagen al Home');
  }


  public function delet_img_home($id)
  {
    $this->ImgHomeRepo->destroy($id); 

    return redirect()->back();
  }
}