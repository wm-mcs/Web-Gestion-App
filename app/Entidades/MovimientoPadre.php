<?php

namespace App\Entidades;
use Illuminate\Database\Eloquent\Model;




class MovimientoPadre extends Model
{


    /**
     * Propiedades orgánicas
     * 
     *   id
     *   empresa_id	
     *   tipo_de_movimiento_id	
     *   sucursal_id
     *   user_empresa_id
     *   user_id
     *   estado_del_movimiento
     *   borrado
     *   estado
     *   updated_at
     *   created_at 
     * 
     */

    protected $table    = 'movimientos_padres';   

    
    
    
}