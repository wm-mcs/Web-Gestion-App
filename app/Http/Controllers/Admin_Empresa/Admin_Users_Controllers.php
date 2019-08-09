<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Repositorios\UserRepo;
use Illuminate\Http\Request;
use App\Managers\Users\user_admin_crear;
use App\Repositorios\EmpresaConSociosoRepo;



class Admin_Users_Controllers extends Controller
{

  protected $UserRepo;
  protected $EmpresaConSociosoRepo;

  public function __construct(UserRepo              $UserRepo,
                              EmpresaConSociosoRepo $EmpresaConSociosoRepo )
  {
    $this->UserRepo               = $UserRepo;
    $this->EmpresaConSociosoRepo  = $EmpresaConSociosoRepo;
  }

  //home admin User
  public function get_admin_users(Request $Request)
  { 
    $users = $this->UserRepo->getUsersAll($Request);



    return view('admin.users.users_home', compact('users'));
  }

  //get Crear admin User
  public function get_admin_users_crear()
  {  
    

    return view('admin.users.users_crear');
  }

  //set Crear admin User
  public function set_admin_users_crear(Request $Request)
  {          

    $manager = new user_admin_crear(null, $Request->all());

    if ($manager->isValid())
    {
     //me traigo la funcion del repositorio UserRepo   
     $this->UserRepo->setUserAdmin($Request);

     return redirect()->route('get_admin_users')->with('alert', 'Usuario Creado Correctamente');       
    }  

    
    return redirect()->back()->withErrors($manager->getErrors())->withInput($manager->getData());
    
  }

  //get edit admin user
  public function get_admin_users_editar($id)
  {
    $user = $this->UserRepo->find($id);
     $EmpresasDeGestion = $this->EmpresaConSociosoRepo->getEntidadActivas();

    return view('admin.users.users_editar',compact('user','EmpresasDeGestion'));
  }

  //set edit admin user
  public function set_admin_users_editar($id,Request $Request)
  {
    $user = $this->UserRepo->find($id);

    $this->UserRepo->setUserAdminEdit($user,$Request); 

    return redirect()->route('get_admin_users')->with('alert', 'Usuario Editado Correctamente');  
  }

  
}