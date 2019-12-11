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
    }

},
template:'
<div class="mensajes-contenedor ocultar-esto">

    <span class="mensaje-cerrar-icono">
       <i class="fas fa-times"></i>
    </span> 
  
    avisos

</div>
'

}




);
