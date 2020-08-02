<?php

namespace App\Repositorios\Traits;

use Intervention\Image\ImageManagerStatic as Image;



trait imagenesTrait{


	public function setImagen($Entidad,$request,$nombreDelCampoForm,$carpetaDelArchivo,$nombreDelArchivo,$ExtensionDelArchivo,$redimencionar_a = null,$file = null)
    {
      //nombre del Archico / Carpeta Incluido
      $nombre = $carpetaDelArchivo.$nombreDelArchivo.$ExtensionDelArchivo;

      if($file == null)
      {
        //obtenemos el campo file definido en el formulario
        $file    = $request->file($nombreDelCampoForm);
        $validator = $request->hasFile($nombreDelCampoForm);

      }
      else
      {
        $archivo   = $file;
        $validator = true;
      }
      
       if($validator != null)
       {
        $archivo = File::get($file);

        if($redimencionar_a != null)
        {
            $imagen_insert = Image::make($archivo)->resize($redimencionar_a, null, function ($constraint) {
                                                                           $constraint->aspectRatio();
                                                                       })->save('imagenes/'.$nombre,70);
        }
        else
        {
           $imagen_insert = Image::make($archivo); 
           $imagen_insert->save('imagenes/'.$nombre,70);   
        }           


         //guardo_el_img
         if($Entidad != null)
         {
           try
           {
            $this->setAtributoEspecifico($Entidad,'img',$Entidad->name_slug);
           }
           catch (Exception $e){}           
         }         
       }
    }	


}
