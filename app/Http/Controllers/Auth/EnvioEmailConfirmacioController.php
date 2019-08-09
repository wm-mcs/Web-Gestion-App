<?php

namespace App\Http\Controllers\Auth;

use App\Entidades\User;

use App\Http\Controllers\Controller;

use App\Repositorios\UserRepo;
use App\Managers\Users\user_registro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositorios\Emails\EmailsRepo;

class EnvioEmailConfirmacioController extends Controller
{
    

    protected $UserRepo;
    protected $EmailsRepo;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserRepo  $UserRepo,
                               EmailsRepo $EmailsRepo )
    {
        $this->UserRepo   = $UserRepo;        
        $this->EmailsRepo = $EmailsRepo;
    }
    


    // Reenvio email de Confirmacion
    public function reenvioEmailConfirmacion()
    {
      $user = Auth::user();
      
      
      $this->EmailsRepo->EnviarEmailDeConfirmacion($user);

      return redirect()->route('get_home')
                       ->with('alert' , $user->name . ' Ve a tu Email: ' . $user->email .' y verifica tu cuenta');
    }

    /**
     * el envio de toquen de la Ruta
     */
    public function getConfirmation($token)
    {
        $user = $this->UserRepo->getEntidad()->where('registration_token' , $token)->firstOrFail();
        $user->registration_token = null;
        $user->save();

        return redirect()->route('get_home')

                        //Genero una variable de sesion de tipo flash para enviar
                        //a la vista
                         ->with('alert' ,  
                            'Listo ' . $user->name . ' ya has confirmado tu email tu cuenta ya esta ok');
    }


 }   