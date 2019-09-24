Vue.component('socio-list' ,
{

props:['socio','empresa']
,  



methods:{
enviar_form:function(id){
  var id = '#'+ id.toString();

   $( id ).parent().submit();
}
         

},
computed:{
  
  clasesDisponibles:function(){
    if(this.socio.servicios_contratados_disponibles_tipo_clase.length > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  },
  mensualDisponibles:function(){
    if(this.socio.servicios_contratados_disponibles_tipo_mensual.length > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  },
  cantidadDeClasesDisponibles:function(){

    var cantidad = this.socio.servicios_contratados_disponibles_tipo_clase.length;

    if(cantidad > 0)
    {
      if(cantidad > 1)
      {
        return cantidad + ' clases disponibles';
      }
      else
      {
         return cantidad + ' clase disponible';
      }
    }
    else
    {
      return 0;
    }

  },
  cantidadDeMensualesDisponibles:function(){

    var cantidad = this.socio.servicios_contratados_disponibles_tipo_mensual.length;
    if( cantidad > 0)
    {
      if(cantidad > 1)
      {
        return cantidad + ' abonos mensuales disponibles';
      }
      else
      {
         return cantidad + ' abono mensual disponible';
      }

      return cantidad;
    }
    else
    {
      return 0;
    }

  }


},
template:'  
<div class="listado-socios-contenedor-individual">
     

      <div class="listado-socios-sub-contenedor-name-estado">
        <div class="listado-socios-name"> 
           <span class="listado-socio-icono"><i class="fas fa-portrait"></i></span> 
           {!! Form::open(['route' => ['get_socio_panel'],
                                'method'=> 'Post',
                                'files' =>  true,
                              ])               !!}   

           <input type="hidden" name="empresa_id" :value="empresa.id">
           <input type="hidden" name="socio_id" :value="socio.id">
           <span :id="socio.id"></span>
           <span class="simula_link"  v-on:click="enviar_form(socio.id)">@{{socio.name}}</span>
           {!! Form::close() !!} 
        </div>
        <div>@{{socio.estado}}</div>
      </div>

      <div class="listado-socios-sub-contenedor-datos">
        <span class="listado-socios-datos"><i class="fas fa-envelope"></i> @{{socio.email}}</span>
        <span class="listado-socios-datos"><i class="far fa-id-badge"></i> @{{socio.cedula}}</span>
        <span class="listado-socios-datos"><i class="fas fa-mobile-alt"></i> @{{socio.celular}}</span>
        
      </div>
      <div class="listado-socio-contiene-los-hay">
        <div v-if="clasesDisponibles" class="listado-socio-tiene-clases">Tiene <strong>@{{cantidadDeClasesDisponibles}}</strong>   </div>
        <div v-if="mensualDisponibles" class="listado-socio-tiene-mensual">Tiene <strong>@{{cantidadDeMensualesDisponibles}}</strong>   </div>        
      </div>
          
</div>'  

}




);