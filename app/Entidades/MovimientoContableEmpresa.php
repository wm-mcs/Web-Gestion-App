<?php

namespace App\Entidades;
use Illuminate\Database\Eloquent\Model;




class MovimientoContableEmpresa extends Model
{


    /**
     * Propiedades orgánicas
     * 
     *   id
     *   movimiento_padre_id   
     *   empresa_id	
     *   tipo_de_movimiento_id	
     *   sucursal_id
     *   user_empresa_id
     *   user_id
     *   estado_del_movimiento
     *   nombre_personalizado_desde_la_vista
     *   valor_ponderado_moneda_original
     *   cotizacion_de_la_moneda_respecto_al_dolar   
     *   moneda      
     *   borrado
     *   estado
     *   updated_at
     *   created_at 
     *  
     */

    protected $table    = 'movimientos_contables_de_empresas';   

    
    
    
}