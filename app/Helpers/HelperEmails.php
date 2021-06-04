<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

class HelperEmails
{
    /**
     * Cuando mensajes a socio.ç
     *
     * @param $Empresa - Objeto de empresa que envia email
     * @param $Socio   - Objeto Socio
     * @param $Data    - Array asociativo del tipo [ 'subject' => 'ssdsd' , 'text' => '' ]
     *
     * @return array
     */
    public static function sendEmailToSocio($Empresa, $Socio, $Data)
    {

        if ($Socio->email == null || $Socio->email == '' || $Socio->mensajes_sistema == 'no') {
            return false;
        }

        Mail::send('emails.envio_de_email_de_empresas_a_socio',

            //con esta funcion le envia los datos a la vista.
            compact('Empresa',
                'Socio',
                'Data'),
            function ($m) use ($Empresa, $Socio, $Data) {

                $m->from($Empresa->email, $Empresa->name);

                $m->to($Socio->email,
                    $Socio->name)->subject($Data['subject']);
            }
        );

        return true;
    }

}
