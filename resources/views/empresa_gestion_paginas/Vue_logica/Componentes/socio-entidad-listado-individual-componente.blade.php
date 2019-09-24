Vue.component('socio-list' ,
{

props:['socio','empresa']
,  



data:function(){
    return {
         clases_desplegadas:false,
      mensuales_desplegadas:false


    }
}, 



methods:{
enviar_form:function(id){
  var id = '#'+ id.toString();

   $( id ).parent().submit();
},
abrir_cerrar_clases:function(){
  if(this.clases_desplegadas)
  {
    this.clases_desplegadas = false;
  }
  else
  {
    this.clases_desplegadas = true;
  }
},
abrir_cerrar_mensual:function(){

  if(this.mensuales_desplegadas)
  {
    this.mensuales_desplegadas = false;
  }
  else
  {
    this.mensuales_desplegadas = true;
  }

  
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
        return cantidad + ' mensuales disponibles';
      }
      else
      {
         return cantidad + ' mensual disponible';
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
        <span class="listado-socios-datos"><i class="fas fa-mobile-alt"></i> @{{socio.celular}}</span>
        
      </div>
      <div class="listado-socio-contiene-los-hay">
        <div v-if="clasesDisponibles" class="listado-socio-tiene-clases">
          <span>
             Tiene <strong>@{{cantidadDeClasesDisponibles}}</strong>  
             <span v-if="clases_desplegadas" v-on:click="abrir_cerrar_clases"><i class="fas fa-chevron-up"></i>  </span>  
             <span v-else v-on:click="abrir_cerrar_clases"> <i class="fas fa-chevron-down"></i></span>            
          </span> 

          <div v-if="clases_desplegadas" class="listado-socio-contiene-clases-o-mensuales">
            <div v-for="servicio in socio.servicios_contratados_disponibles_tipo_clase" :key="servicio.id">
              <div>
                @{{servicio.name}}
              </div>
            </div>
          </div>


        </div>
        <div v-else class="listado-socio-no-tiene">
            No tiene clases disponibles <i class="far fa-meh"></i>
        </div>
        <div v-if="mensualDisponibles" class="listado-socio-tiene-mensual">
          <span>
             Tiene <strong>@{{cantidadDeMensualesDisponibles}}</strong> 
             <span v-if="mensuales_desplegadas" v-on:click="abrir_cerrar_mensual"><i class="fas fa-chevron-up"></i>  </span>  
             <span v-else v-on:click="abrir_cerrar_mensual"> <i class="fas fa-chevron-down"></i></span>  
          </span>
           <div v-if="mensuales_desplegadas">
              <div v-for="servicio in socio.servicios_contratados_disponibles_tipo_mensual" :key="servicio.id">
              <div>
                @{{servicio.name}}
              </div>
            </div>
           </div>
            

        </div>
         <div v-else class="listado-socio-no-tiene">
            No tiene mensual disponible <i class="far fa-meh"></i>
        </div>        
      </div>
          
</div>'  

}




);