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
    },
    mostrar_contenedor_avisos:function(){
    if(this.tiene_mensaje_personalizado || this.debe_plata_pesos || this.debe_plata_dolares)
    {
    return true;
    }
    else
    {
     return false;
    }
    }
},
template:'
<div  v-if="mostrar_contenedor_avisos" class="ocultar-esto contiene-mensaje-empresa-top">

    <span class="mensaje-cerrar-icono">
       <i class="fas fa-times"></i>
    </span> 

    <div v-if="debe_plata_pesos" class="linea-de-aviso-individual"><i class="fas fa-exclamation"></i> Hay un saldo pendiente de pago de $ @{{Math.abs(this.empresa.estado_de_cuenta_saldo_pesos)}} . 
    <br> <strong>Si se trata de algún error te pido que te comuniques. </strong> 
    <br> Si estás atrasado en el pago aquí te dejo los datos para puedas quedar al día: <strong>Caja Ahorro BROU PESOS 00156513100002 (viejo: 177 0469556)</strong> . Puedes hacer el dopósito en <strong> Abitab o Red Pagos </strong>. Luego que lo hagas <strong> envia el comprobante al Whatsapp </strong> que te dejo aquí abajo.
    <br>
    <a :href="this.$root.whatsappContactoPagos"><i class="fab fa-whatsapp-square"></i> enviar mensaje</a>
    
    </div>
    <div v-if="debe_plata_dolares" class="linea-de-aviso-individual"><i class="fas fa-exclamation"></i> Hay al día de hoy un saldo pendiente de pago de U$S @{{this.empresa.estado_de_cuenta_saldo_dolares}} . 
    <br> Si se trata de algún error te pido que te comuniques. 
    <br> Si estás atrasado en el pago aquí te dejo los datos para puedas quedar al día: Caja Ahorro BROU DOLARES 00156513100001 (viejo: 177 0633012). Puedes hacer el dopósito en Abitab o Red Pagos. Luego que lo hagas envia el comprobante al Whatsapp que te dejo aquí abajo.
    <br>
    <a :href="this.$root.whatsappContactoPagos"><i class="fab fa-whatsapp-square"></i> enviar mensaje</a>
    </div>


    <div v-if="tiene_mensaje_personalizado" class="linea-de-aviso-individual"><i class="fas fa-exclamation"></i>  
     <strong>@{{this.empresa.mensaje_aviso_especial}}</strong> 
    </div>

    
  
    

</div>
'

}




);
