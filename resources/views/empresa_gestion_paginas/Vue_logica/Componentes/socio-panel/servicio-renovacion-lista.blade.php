Vue.component('servicio-renovacion-lista' ,
{
props:[ 'empresa','servicio_renovacion' ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'<span>

  
   <span>@{{servicio_renovacion.servicio_tipo.name}} </span>
   <span>Ultima renovación:@{{servicio_renovacion.fecha_ultima_renovacion}} </span>
   <span>Se renueva automáticamente:@{{servicio_renovacion.se_renueva_automaticamente}} </span>
  

</span>'

}




);