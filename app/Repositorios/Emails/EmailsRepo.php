<?php 

namespace App\Repositorios\Emails;

use Illuminate\Support\Facades\Mail;


class EmailsRepo 
{

     /**
     * Envio de un email simple
     */
    public function EnvioDeEmailSimple($nombre_de_quien_envia,
                                       $email_de_quien_envia,
                                       $mensaje,
                                       $email_a_enviar,
                                       $nombre_de_email_a_enviar,
                                       $titulo_email,
                                       $llamado_accion_texto,
                                       $llamado_accion_link)               
    {
        
         

         Mail::send('emails.envio_email_simple' ,

                   //con esta funcion le envia los datos a la vista.
                   compact('nombre_de_quien_envia' , 
                           'email_de_quien_envia',
                           'mensaje',
                           'titulo_email',
                           'llamado_accion_texto',
                           'llamado_accion_link')       ,
                   function($m) use ($nombre_de_quien_envia,
                                     $email_de_quien_envia,
                                     $email_a_enviar,
                                     $nombre_de_email_a_enviar,
                                     $titulo_email) 
                   {

                     $m->from($email_de_quien_envia, $nombre_de_quien_envia);

                     $m->to( $email_a_enviar, 
                             $nombre_de_email_a_enviar)->subject($titulo_email);
                   }
         );

    }

    public function EnvioDeEmailAlCrearUser($nombre_de_quien_envia,
                                            $email_de_quien_envia,
                                            $Texto,
                                            $User_name,
                                            $Contraseña,
                                            $email_a_enviar,
                                            $nombre_de_email_a_enviar,
                                            $titulo_email,
                                            $Texto_boton,
                                            $Link_del_boton
                                              )
    {

       Mail::send('emails.envio_email_creacion_user' ,

                   //con esta funcion le envia los datos a la vista.
                   compact('nombre_de_quien_envia' , 
                           'email_de_quien_envia',
                           'Texto',
                           'User_name', 
                           'Contraseña',
                           'titulo_email',
                           'Texto_boton',
                           'Link_del_boton')       ,
                   function($m) use ($nombre_de_quien_envia,
                                     $email_de_quien_envia,
                                     $email_a_enviar,
                                     $nombre_de_email_a_enviar,
                                     $titulo_email) 
                   {

                     $m->from($email_de_quien_envia, $nombre_de_quien_envia);

                     $m->to( $email_a_enviar, 
                             $nombre_de_email_a_enviar)->subject($titulo_email);
                   }
         );
      
    }
  


}