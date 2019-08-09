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
    return ['name','email','telefono','estado','role','contrato_pagina_web','contrato_sistema_gestion','empresa_gestion_id'];
  }


  //setters//////////////////////////////////////////////////////////////////////

  public function setUserAdmin($request)
  {
    $user           = $this->getEntidad();
    $user->password = 'secret';
    $user->password = bcrypt($user->password);

    //propiedades para crear
    $Propiedades = $this->getPropiedades();

    $this->setEntidadDato($user,$request,$Propiedades);

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
  

  
}
