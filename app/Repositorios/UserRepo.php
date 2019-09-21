<?php 

namespace App\Repositorios;

use App\Entidades\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


/**
* Repositorio de consultas a la base de datos User
*/
class UserRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new User();
  }

  //guetters/////////////////////////////////////////////////////////////////////

  public function getUsersAll($request)
  {
    return $this->getEntidad()
                ->name($request->get('name'))
                ->role($request->get('role'))
                ->orderBy('id','desc')
                ->paginate(30);
  }

  public function getPropiedades()
  {
    return ['name','email','telefono','estado','role','contrato_pagina_web'];
  }


  //setters//////////////////////////////////////////////////////////////////////

  public function setUserAdmin($request)
  {
    $user           = $this->getEntidad();
    $user->password = str_random(8);

    $Contraseña     = $user->password;

    $user->password = bcrypt($user->password);

    //propiedades para crear
    $Propiedades    = $this->getPropiedades();

    $this->setEntidadDato($user,$request,$Propiedades);

    //variables para enviar email
    $nombre_de_quien_envia = 'EasySocios';
    $email_de_quien_envia  = 'noresponder@gestionsocios.com.uy';
    $mensaje               = ' Felicitaciones '. $user->name .' , ya eres un usuario en EasySocio. Tu usuario es '.$user->email.' y tu contraseña es ' . $Contraseña . '  (podrás cambiarla cuando quieras! ) ' ;
    $email_a_enviar        = $user->email;
    $nombre_de_quien_envia = $user->name;
    $titulo_email          = 'Bienvenido a EasySocios';
    $llamado_accion_texto  = 'Incia sesion ahora!';
    $llamado_accion_link   = route('auth_login_get');

    //enviar email con la info que se creo el usuario y que la contraseña es tal
    $this->getEmailsRepo()->EnvioDeEmailSimple($nombre_de_quien_envia, 
                                               $email_de_quien_envia, 
                                               $mensaje, 
                                               $email_a_enviar, 
                                               $nombre_de_email_a_enviar, 
                                               $titulo_email,
                                               $llamado_accion_texto,
                                               $llamado_accion_link);

    $user->save(); 

  }

  public function setUserAdminEdit($user,$request)
  {
    
    //propiedades para crear
    $Propiedades = $this->getPropiedades();

    $this->setEntidadDato($user,$request,$Propiedades);

    $user->save(); 

  }

  public function setUserRegistro($user,$request)
  {
   
    
    $user->role                 = 'user';
    $user->envio_publicidad     = 'si';
    $user->estado               = 'si';

    //propiedades para crear
    $Propiedades = ['name','email','password'];

    $this->setEntidadDato($user,$request,$Propiedades);
    
    $user->save();

    //Encripto la contraseña
    $user->password = bcrypt($user->password);

    //Genero el Token ( campo en la Table User)
    $user->registration_token = str_random(40);

    $user->save();

    $url = route('confirmation' , [ 'token' => $user->registration_token ]);

    //envio Correo usuario
    $this->getEmailsRepo()->EnviarEmailDeConfirmacion($user);

    return $user;
  }


  public function getUserSegunRole($Role)
  {
    return $this->getEntidad()
                ->where('role','>' ,$Role)
                ->get();
  }
  

  
}
