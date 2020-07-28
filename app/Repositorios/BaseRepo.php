<?php 
namespace App\Repositorios;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Repositorios\Emails\EmailsRepo;
use Input;
use Intervention\Image\ImageManagerStatic as Image;

/**
* Contiene metodos comunes para todo los repositorios
*/
abstract class BaseRepo 
{
    /**
     * entidad que ingresamos por parametro
     */
    protected $entidad;
    

    public function __construct()
    {
      
      $this->entidad      = $this->getEntidad();
    }

   public function getEmailsRepo()
   {
    return new EmailsRepo();
   }

    public function find($id)
    {
      return $this->entidad->find($id);
    }

     public function destroy_entidad($id)
    {
      $entidad_a_borrar = $this->find($id);
      $entidad_a_borrar->delete();
    }

    //elimina esta entidad
    public function destruir_esta_entidad($Entidad)
    {
      $Entidad->delete();
    }

    //se cambia la propiedad borrado a si
    public function destruir_esta_entidad_de_manera_logica($Entidad)
    {

      $Entidad->borrado = 'si';
      $Entidad->save();
    }

    /**
     * Entidades Activas 
     */
    public function getEntidadActivas()
    {
      return $this->entidad                  
                  ->where('estado','si')              
                  ->orderBy('id','desc')
                  ->get();
    }

    /**
     * Entidades Activas 
     */
    public function getEntidadActivasOrdenadasSegun($Order_by,$Asc_desc)
    {
      return $this->entidad                  
                  ->where('estado','si')  
                  ->where('borrado','no')            
                  ->orderBy($Order_by,$Asc_desc)
                  ->get();
    }

    /**
     * Entidades Activas Paginadas
     */
    public function getEntidadActivasPaginadas($request,$paginacion)
    {
      return $this->entidad
                  ->name($request->get('name')) 
                  ->where('estado','si')               
                  ->orderBy('id','desc')
                  ->paginate($paginacion);
    }


    public function getEntidadesConEstosId($ids)
    {
       $array = array_unique($ids);

       return  $this->entidad
                    ->where('estado','si') 
                    ->whereIn('id',$array)
                    ->get();
    }

   


   

  
     

    /**
     * funcion que va a hacer creada el los repo que extiendan.
     */
    abstract public function getEntidad();



    //setters
    public function setEntidadDato($Entidad,$request,$Propiedades)
    {
        foreach ($Propiedades as $Propiedad) 
        {
          if($request->input($Propiedad) != null)
          {            
           $Entidad->$Propiedad = $request->input($Propiedad);
          }
          elseif($request->input($Propiedad) == '')
          {
            $Entidad->$Propiedad = trim($request->input($Propiedad));
          }
         
        } 

        $Entidad->save();     

        return $Entidad;
    }

    //setters recibe un objeto en lugar del reques
    public function setEntidadDatoObjeto($Entidad,$objeto,$Propiedades)
    {
        foreach ($Propiedades as $Propiedad) 
        {         
           $Entidad->$Propiedad = $objeto->$Propiedad; 
        } 

        $Entidad->save();     

        return $Entidad;
    }


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


    public function setImagenDesdeVue($File, $carpeta,$nombre,$extens,$redimencionar_a = null)
    {

       $nombre = $carpeta.$nombre.$extens;
       if($File == '' )
       {
        return '';
       }

       if($redimencionar_a != null)
        {
            $imagen_insert = Image::make($File)->resize($redimencionar_a, null, function ($constraint) {
                                                                           $constraint->aspectRatio();
                                                                       })->save('imagenes/'.$nombre,70);
        }
        else
        {
           $imagen_insert = Image::make($File); 

           $imagen_insert->save('imagenes/'.$nombre,70);   

        }
      
    }


     /**
     * grabar entidad atributo especifico
     */
    public function setAtributoEspecifico($Entidad,$atributo,$valor)
    {
      if($valor != '')
      {
        $Entidad->$atributo = trim($valor);
        $Entidad->save();

        return $Entidad;
      }
      
    }

    

    

   

    

    /**
     * Valido para movimiento de caja o estado de cuenta
     */
    public function getDetalleAlAnular($EntidadAAnular)
    {
      return 'Anulación del movimiento ' . $EntidadAAnular->id . ' : ' . $EntidadAAnular->detalle;
    }
    

}   
