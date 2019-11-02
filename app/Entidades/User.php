<?php

namespace App\Entidades;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Entidades\UserEmpresa;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    
    protected $table    = 'users';
    
    protected $fillable = ['name','email','password'];
   
    protected $hidden   = ['password', 'remember_token'];

    protected $appends  = ['name_para_select','gerarqui_con_nombre','route_admin','first_name'];



   




    //scoups
    /**
     * PAra busqueda por nombre
     */
    public function scopeName($query, $name)
    {
        // si el paramatre(campo busqueda) esta vacio ejecutamos el codigo
        // trim() se utiliza para eliminar los espacios.
        ////Like se usa para busqueda incompletas
        /////%% es para los espacios adelante y atras
        if (trim($name) !="")
        {                        
           $query->where('name', "LIKE","%$name%"); 
        }
        
    }
    /**
     * Busqueda por Rol formulario Admin
     */
    public function scopeRole($query, $role)
    {
        //los tipo de roles que estan en el archivo config option
        $types = config('options.role');

        if($role !="" && isset($types[$role]))
        {
            //                  "=" con elocuent no es necesario ponerlo
            $query->where('role',$role);
        }

    }



    //Atributes////////////////////
    public function getFirstNameAttribute()
    {

        $name = trim($this->name);
        $name = explode(" ", $name);
      
        return $name[0];
    }

    public function getNameParaSelectAttribute()
    {
        return $this->name . ' -> ' .$this->email;
    }


    public function getGerarquiConNombreAttribute()
    {
        $array = [
                    1 => 'Simple',
                    2 => 'Operador',
                    3 => 'Dueño',
                    4 => 'Vendedor',
                10    => 'Admin supremo'

               ];

           return $array[$this->role];    
    }


    public function getRouteAdminAttribute()
    {
        return route('get_admin_users_editar',$this->id);
    }
}
