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

    /**
     * Entidades Activas 
     */
    public function getEntidadActivas()
    {
      return $this->entidad                  
                  ->active()               
                  ->orderBy('id','desc')
                  ->get();
    }

    /**
     * Entidades Activas Paginadas
     */
    public function getEntidadActivasPaginadas($request,$paginacion)
    {
      return $this->entidad
                  ->name($request->get('name')) 
                  ->active()               
                  ->orderBy('id','desc')
                  ->paginate($paginacion);
    }

    /**
     * Entidades Activas Paginadas y ordenadas
     */
    public function getEntidadActivasYOrdenadasSegunPaginadas($request,$OrdenadasSegunAtributo,$Orden,$paginacion)
    {
      return $this->entidad
                  ->name($request->get('name')) 
                  ->active()               
                  ->orderBy($OrdenadasSegunAtributo,$Orden)
                  ->paginate($paginacion);
    }

    /**
     * Entidades All ya paginadas Paginadas 
     */
    public function getEntidadesAllPaginadas($request,$paginacion)
    {

    return $this->entidad
                ->name($request->get('name'))                
                ->orderBy('id','desc')
                ->paginate($paginacion);
  
    }

    public function getEntidadesAllPaginadasYOrdenadas($request,$OrdenadasSegunAtributo,$Orden,$paginacion)
    {

    return $this->entidad
                ->name($request->get('name'))                
                ->orderBy($OrdenadasSegunAtributo,$Orden)
                ->paginate($paginacion);
  
    }

    /**
     * Devuelve una coleccion de una entidad segun un atributo variable y ordenada como queramos y Paginadas.
     */
    public function getEntidadActivasAll_Segun_Atributo_y_Ordenadas($atributo,$valor_atributo,$orden,$paginacion)
    {
      return $this->entidad
                  ->where($atributo,$valor_atributo)             
                  ->orderBy('id',$orden)
                  ->paginate($paginacion);
    }


    /**
     * Ultimas Entidades Activas
     */
    public function getUltimasEntidadesRegistradasRandomActive($request,$cantidad)
    {

      $cantidad_de_entidades =  $this->entidad->active()->get()->count();

      if($cantidad_de_entidades >= $cantidad)
      {
        $entidades = $this->entidad
                          ->name($request->get('name'))                
                          ->active()
                          ->orderBy('id','DESC')
                          ->take($cantidad)
                          ->get();
      }
      else
      {
        $entidades = $this->entidad
                          ->name($request->get('name'))                
                          ->active()
                          ->orderBy('id','DESC')
                          ->get();
      }  

    return $entidades;
  
    }


    public function getEntidadesActivasYOrdenadas($Cantidad,$Orden)
    {
      $cantidad_de_entidades =  $this->entidad->active()->get()->count();

      if($cantidad_de_entidades >= $Cantidad)
      {
        $entidades = $this->entidad               
                          ->active()
                          ->orderBy('id',$Orden)
                          ->take($Cantidad)
                          ->get();
      }
      else
      {
        $entidades = $this->entidad              
                          ->active()
                          ->orderBy('id',$Orden)
                          ->get();
      }  

    return $entidades;
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
            $Entidad->$Propiedad = $request->input($Propiedad);
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

     /**
       * Para subidas multiples  
       */  
    public function setImagenMultiples($Entidad,$file,$nombreDelCampoForm,$carpetaDelArchivo,$nombreDelArchivo,$ExtensionDelArchivo)
    {   
         //nombre del Archico / Carpeta Incluido
         $nombre = $carpetaDelArchivo.$nombreDelArchivo.$ExtensionDelArchivo;
         $Entidad->$nombreDelCampoForm= $nombre;              
         
         //indicamos que queremos guardar un nuevo archivo en el disco local
         $imagen_insert = Image::make(File::get($file));
         $imagen_insert->save('imagenes/'.$nombre,70);    
         $Entidad->save();  


       
         
       
    }


    /**
     * De vuelve las imagenes segun el campo e id a buscar de la entidad
     */
    public function get_imagen_principal_de_entidad_especifica($atributo_name,$id_del_atributo)
    {
      return $this->entidad
                  ->where($atributo_name,$id_del_atributo)
                  ->where('foto_principal','si')
                  ->get();
    }

    public function set_datos_de_img($file, $Entidad,$nombre_de_la_propiedad,$id_de_la_propiedad,$request,$LugarDondeSeAloja)
    {

          
          $Imagen = $Entidad;    

          //nombre de la calve foraña y su valor  
          $Imagen->$nombre_de_la_propiedad = $id_de_la_propiedad;

          //estado activo  
          $Imagen->estado = 'si';

          //guardo  
          $Imagen->save();

          $this->setImagenMultiples($Imagen,$file,'img',$LugarDondeSeAloja, $Imagen->id,'.png'); 

          $Imagen->save();  

        

      }

       
    

    //base Repo. Ahorro codigo
    public function cambio_a_imagen_principal_desde_base_repo($imagen_pricipal,$imagen)
    {
      //cuento si es que hay
      if($imagen_pricipal->count() > 0)
      {
        //agarro la imagen
        $imagen_principal_efectiva = $imagen_pricipal->first();
        $imagen_principal_efectiva->foto_principal = null;
        $imagen_principal_efectiva->save();


        //le indico que es la imagen pricnipal 
        $imagen->foto_principal = 'si';
        $imagen->save();
      }
    }


     /**
     * grabar entidad atributo especifico
     */
    public function setAtributoEspecifico($Entidad,$atributo,$valor)
    {
      if($valor != '')
      {
        $Entidad->$atributo = $valor;
        $Entidad->save();
      }
      
    }
    

}   
