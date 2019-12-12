Vue.component('avisos-empresa' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     

    }
},
methods:{

   

},
computed:{
	 tiene_algo_activo:function(){
     if(this.empresa.servicios_contratados_a_empresas_activos.length)
     {
     	return true;
     }
     else
     {
        return false;
     }
    },
    debe_plata_pesos:function(){
     if(this.empresa.estado_de_cuenta_saldo_pesos < 0)
     {
     	return true;
     }
     else
     {
        return false;
     }
    },
    debe_plata_dolares:function(){
     if(this.empresa.estado_de_cuenta_saldo_dolares < 0)
     {
     	return true;
     }
     else
     {
        return false;
     }
    },
    tiene_mensaje_personalizado:function(){
     if(this.empresa.mensaje_aviso_especial != '')
     {
     	return true;
     }
     else
     {
     	return false;
     }
    }
}
template:'
<div  class="ocultar-esto contiene-mensaje-empresa-top">

    <span class="mensaje-cerrar-icono">
       <i class="fas fa-times"></i>
    </span> 

    <div v-if="debe_plata_pesos" class="linea-de-aviso-individual"><i class="fas fa-exclamation"></i> Hay al día de hoy un saldo pendiente de pago de $ @{{this.empresa.estado_de_cuenta_saldo_pesos}} 
    </div>
    <div v-if="debe_plata_pesos" class="linea-de-aviso-individual"><i class="fas fa-exclamation"></i> Hay al día de hoy un saldo pendiente de pago de U$S @{{this.empresa.estado_de_cuenta_saldo_dolares}} 
    </div>


    <div v-if="tiene_mensaje_personalizado" class="linea-de-aviso-individual"><i class="fas fa-exclamation"></i>  
     <strong>@{{this.empresa.mensaje_aviso_especial}}</strong> 
    </div>

    
  
    

</div>
'

}




);
