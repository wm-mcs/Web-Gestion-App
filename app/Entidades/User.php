<?php

namespace App\Entidades;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['name_para_select',
        'gerarqui_con_nombre',
        'route_admin', 'first_name', 'foto_de_perfil', 'path_foto_de_perfil', 'link_whatsapp_send'];

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
        if (trim($name) != "") {
            $query->where('name', "LIKE", "%$name%");
        }

    }
    /**
     * Busqueda por Rol formulario Admin
     */
    public function scopeRole($query, $role)
    {
        //los tipo de roles que estan en el archivo config option
        $types = config('options.role');

        if ($role != "" && isset($types[$role])) {
            //                  "=" con elocuent no es necesario ponerlo
            $query->where('role', $role);
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
        return $this->name . ' -> ' . $this->email;
    }

    public function getGerarquiConNombreAttribute()
    {
        $array = [
            1 => 'Simple',
            2 => 'Operador',
            3 => 'Dueño',
            4 => 'Vendedor',
            10 => 'Admin supremo',

        ];

        return $array[$this->role];
    }

    public function getRouteAdminAttribute()
    {
        return route('get_admin_users_editar', $this->id);
    }

    public function getFotoDePerfilAttribute()
    {
        return url() . '/imagenes/UserPerfil/fotoPerfil_' . $this->id . '.jpg';
    }

    public function getPathFotoDePerfilAttribute()
    {
        return public_path() . '/imagenes/UserPerfil/fotoPerfil_' . $this->id . '.jpg';
    }

    public function getLinkWhatsappSendAttribute()
    {

        $numero = '598' . substr(trim(str_replace(' ', '', $this->telefono)), 1);
        $mensaje = 'Hola';
        $url = 'https://api.whatsapp.com/send?phone=' . $numero . '&text=' . $mensaje;

        return $url;
    }

}
