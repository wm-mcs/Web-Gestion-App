<?php

namespace App\Repositorios;

use App\Entidades\User;
use App\Repositorios\Traits\imagenesTrait;

class UserRepo extends BaseRepo
{

    use imagenesTrait;
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
            ->orderBy('id', 'desc')
            ->paginate(30);
    }

    public function getPropiedades()
    {
        return ['name', 'email', 'telefono', 'estado', 'role'];
    }

    //setters//////////////////////////////////////////////////////////////////////

    public function setUserAdmin($request)
    {
        $user           = $this->getEntidad();
        $user->password = str_random(8);

        $Contraseña = $user->password;

        $user->password = bcrypt($request->get('telefono'));

        //propiedades para crear
        $Propiedades = $this->getPropiedades();

        $user = $this->setEntidadDato($user, $request, $Propiedades);
        $this->setImagen(null,
            $request,
            'img',
            'UserPerfil/',
            'fotoPerfil_' . $user->id,
            '.jpg',
            100);

        //variables para enviar email
        $nombre_de_quien_envia    = 'EasySocio';
        $email_de_quien_envia     = 'noresponder@gestionsocios.com.uy';
        $Texto                    = 'Bienvenido a Easy Socio!,  te hemos creado una cuenta.';
        $User_name                = $user->email;
        $Contraseña              = $request->get('telefono');
        $email_a_enviar           = $user->email;
        $nombre_de_email_a_enviar = $user->name;
        $titulo_email             = 'Bienvenido a EasySocio';
        $Texto_boton              = 'Incia sesión ahora!';
        $Link_del_boton           = route('auth_login_get');

        //enviar email con la info que se creo el usuario y que la contraseña es tal
        $this->getEmailsRepo()->EnvioDeEmailAlCrearUser($nombre_de_quien_envia,
            $email_de_quien_envia,
            $Texto,
            $User_name,
            $Contraseña,
            $email_a_enviar,
            $nombre_de_email_a_enviar,
            $titulo_email,
            $Texto_boton,
            $Link_del_boton);

        $user->save();

    }

    public function setUserAdminEdit($user, $request)
    {

        //propiedades para crear
        $Propiedades = $this->getPropiedades();

        $this->setEntidadDato($user, $request, $Propiedades);

        $this->setImagen(null,
            $request,
            'img',
            'UserPerfil/',
            'fotoPerfil_' . $user->id,
            '.jpg',
            100);

        $user->save();

    }

    public function setUserRegistro($user, $request)
    {

        $user->role             = 'user';
        $user->envio_publicidad = 'si';
        $user->estado           = 'si';

        //propiedades para crear
        $Propiedades = ['name', 'email', 'password'];

        $this->setEntidadDato($user, $request, $Propiedades);

        $user->save();

        //Encripto la contraseña
        $user->password = bcrypt($user->password);

        //Genero el Token ( campo en la Table User)
        $user->registration_token = str_random(40);

        $user->save();

        $url = route('confirmation', ['token' => $user->registration_token]);

        //envio Correo usuario
        $this->getEmailsRepo()->EnviarEmailDeConfirmacion($user);

        return $user;
    }

    public function getUserSegunRole($Role)
    {
        return $this->getEntidad()
            ->where('role', '>', $Role)
            ->get();
    }

    public function getEmpresasDeEsteUsuario($UserId)
    {
        $empresas = $this->getEntidad()
            ->where('user_id', $UserId)
            ->get();
        $array_id = [];

        foreach ($empresas as $empresa) {
            array_push($array_id, $empresa->id);
        }

        return $array_id;
    }

    public function setUserCuandoCreoEmpresa($name, $email, $telefono)
    {

        if ($this->verificarSiExisteElUser($email)) {
            $user = $this->getEntidad()->where('email', $email)->get()->first();
        } else {
            $user         = $this->getEntidad();
            $user->role   = 3; //usuario dueño
            $user->estado = 'si'; //usuario dueño
        }

        $user->password = str_random(8);
        $Contraseña    = $user->password;
        $user->password = bcrypt($telefono);

        $user->name     = $name;
        $user->email    = $email;
        $user->telefono = $telefono;
        $user->save();

        /*
        //variables para enviar email
        $nombre_de_quien_envia    = 'EasySocio';
        $email_de_quien_envia     = 'noresponder@gestionsocios.com.uy';
        $Texto                    = '¡Bienvenido a Easy Socio!   Te hemos creado una cuenta.';
        $User_name                = $user->email;
        $Contraseña              = $telefono;
        $email_a_enviar           = $user->email;
        $nombre_de_email_a_enviar = $user->name;
        $titulo_email             = 'Bienvenido a EasySocio';
        $Texto_boton              = '¡Inciá sesión ahora!';
        $Link_del_boton           = route('auth_login_get');

        //enviar email con la info que se creo el usuario y que la contraseña es tal
        $this->getEmailsRepo()->EnvioDeEmailAlCrearUser($nombre_de_quien_envia,
        $email_de_quien_envia,
        $Texto,
        $User_name,
        $Contraseña,
        $email_a_enviar,
        $nombre_de_email_a_enviar,
        $titulo_email,
        $Texto_boton,
        $Link_del_boton);
         */
        $user->save();

        return $user;

    }

    public function verificarSiExisteElUser($email)
    {
        $users = $this->getEntidad()->where('email', $email)->get()->count();

        if ($users > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Si no se envia contraseña por defecto tomara la del celular
     */
    public function ActualizarContraseña($User_id, $NuevaContraseña)
    {
        $User = $this->find($User_id);
        if ($NuevaContraseña == null) {
            $Contraseña = trim($User->telefono);
        } else {
            $Contraseña = trim($NuevaContraseña);
        }

        $User->password = bcrypt($Contraseña);
        $User->save();

        //variables para enviar email
        $nombre_de_quien_envia    = 'EasySocio';
        $email_de_quien_envia     = 'noresponder@gestionsocios.com.uy';
        $Texto                    = 'Tu nueva contraseña es';
        $User_name                = $User->email;
        $Contraseña_enviar       = $Contraseña;
        $email_a_enviar           = $User->email;
        $nombre_de_email_a_enviar = $User->name;
        $titulo_email             = 'Tu nueva contraseña en EasySocio';
        $Texto_boton              = 'Inciá sesión ahora!';
        $Link_del_boton           = route('auth_login_get');

        //enviar email con la info que se creo el usuario y que la contraseña es tal
        $this->getEmailsRepo()->EnvioDeEmailAlCrearUser($nombre_de_quien_envia,
            $email_de_quien_envia,
            $Texto,
            $User_name,
            $Contraseña_enviar,
            $email_a_enviar,
            $nombre_de_email_a_enviar,
            $titulo_email,
            $Texto_boton,
            $Link_del_boton);
    }

}
