<?php

namespace App\Entidades;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];




    //scoups
    /**
     * PAra busqueda por nombre
     */
    public function scopeName($query, $name)
    {
        //si el paramatre(campo busqueda) esta vacio ejecutamos el codigo
        /// trim() se utiliza para eliminar los espacios.
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
        $name = explode(" ", $this->name);
      
        return $name[0];
    }
}
