<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class Empresa extends Model
{

    protected $table ='empresa_datos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * para verificar si no es null o no es cadena vacia
     */
    public function helper_verificar_nulidad($variable)
    {
      if(($variable != null) || ($variable != ''))
      {
        return $variable;
      }
      else
      {
        return 'no';
      }
    }


    //imagenes
    public function getImgLogoCuadradoAttribute()
    {
        
        return url().'/imagenes/'.$this->logo_cuadrado;
    }

    public function getImgLogoHorizontalAttribute()
    {
        
        return url().'/imagenes/'.$this->logo_horizontal;
    }

    public function getImgLogoVerticalAttribute()
    {
        
        return url().'/imagenes/'.$this->logo_vertical;
    }

    //datos
    public function getTelefonoEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->telefono);
    }

    public function getCelularEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->celular);
    }

    public function getDireccionEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->direccion);
    }

    public function getHorariosEmpresaAttribute()
    {       
    
        return $this->helper_verificar_nulidad($this->horarios_dias);
    }

    public function getEmailEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->email);
    }

    public function getSloganEmpresaAttribute()
    {        
    
        return $this->helper_verificar_nulidad($this->slogan);
    }

    public function getMisionEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->mision);
    }

    public function getVisionEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->vision);
    }

    public function getPalabrasClavesEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->palabras_claves);
    }

    //Socilaes

    public function getFacebookEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->facebook_url);
    }

    public function getInstagramEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->instagram_url);
    }

    public function getTwitterEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->twitter_url);
    }

    public function getLinkedinEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->linkedin_url);
    }

    public function getYoutubeEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->youtube_url);
    }

    public function getWhatsappEmpresaAttribute()
    {        
        return $this->helper_verificar_nulidad($this->Whatsapp_cel);
    }


    public function getLinkWhatsappSendAttribute()
    {

        $numero  = '598'. substr(trim($this->whatsapp_empresa),1);
        $mensaje = 'Hola!%20,%20quiero%20consultar%20por%20los%20planes%20de%20webs%20que%20tienen!';
        $url = 'https://api.whatsapp.com/send?phone='. $numero .'&text='. $mensaje;

        return $url;
    }

    public function getNumeroWhatsappYaArregladoAttribute()
    {
        return '598'. substr(trim($this->whatsapp_empresa),1);
    }



    

    
}