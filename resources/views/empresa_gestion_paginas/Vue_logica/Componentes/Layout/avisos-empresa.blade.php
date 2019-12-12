Vue.component('avisos-empresa' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     

    }
},
methods:{

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
    debe_plata:function(){
     if(this.empresa.estado_de_cuenta_saldo_pesos < 0)
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
<div v-if="debe_plata" class="ocultar-esto contiene-mensaje-empresa-top">

    <span class="mensaje-cerrar-icono">
       <i class="fas fa-times"></i>
    </span> 

    <i class="fas fa-exclamation"></i> 
  
    Hay al día de hoy un saldo pendiente de pago de $ @{{this.empresa.estado_de_cuenta_saldo_pesos}}

</div>
'

}




);
