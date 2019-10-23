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
use Illuminate\Support\Facades\Auth;
use App\Repositorios\Emails\EmailsRepo;



class Admin_Users_Controllers extends Controller
{

  protected $UserRepo;
  protected $EmpresaConSociosoRepo;
  protected $EmailsRepo;

  public function __construct(UserRepo              $UserRepo,
                              EmpresaConSociosoRepo $EmpresaConSociosoRepo,
                              EmailsRepo            $EmailsRepo )
  {
    $this->UserRepo               = $UserRepo;
    $this->EmpresaConSociosoRepo  = $EmpresaConSociosoRepo;
    $this->EmailsRepo             = $EmailsRepo;
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


  //cambiar la contraseña desde el User
  public function cambiarContraseñaUser(Request $Request)
  {
    $User = Auth::user(); 

    if($Request->get('pass') != '')
    {
      $Contraseña = $Request->get('pass'); 

      $this->UserRepo->setAtributoEspecifico($User,'password',bcrypt($Contraseña));
      
      //variables para enviar email
      $nombre_de_quien_envia    = 'EasySocios';
      $email_de_quien_envia     = 'noresponder@gestionsocios.com.uy';
      $Texto                    = $User->first_name . '!, cambiaste tú contraseña en Easy Socios.';
      $User_name                = $User->email;
      $Contraseña               = $Contraseña;
      $email_a_enviar           = $User->email;
      $nombre_de_email_a_enviar = $User->name;
      $titulo_email             = 'Cambiaste tú contraseña en Easy Socios';
      $Texto_boton              = 'Incia sesión ahora!';
      $Link_del_boton           = route('auth_login_get');

      //enviar email con la info que se creo el usuario y que la contraseña es tal
      $this->EmailsRepo->EnvioDeEmailAlCrearUser($nombre_de_quien_envia, 
                                                      $email_de_quien_envia, 
                                                      $Texto, 
                                                      $User_name,
                                                      $Contraseña,
                                                      $email_a_enviar, 
                                                      $nombre_de_email_a_enviar, 
                                                      $titulo_email,
                                                      $Texto_boton,
                                                      $Link_del_boton);

        return ['Validacion'          => true,
                'Validacion_mensaje'  => 'Cambiaste tú contraseña de forma exitosa'];

    }

     return ['Validacion'          => false,
             'Validacion_mensaje'  => 'Debes poner una contraseña válida'];
  }

  
}