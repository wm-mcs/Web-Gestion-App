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

  
},
consumir_esta_clase:function(servicio){

  

       var mensaje    = "¿Seguro quieres consumir está clase? (de " + this.socio.name + ' )' ;

       var validation = confirm(mensaje);

       if(!validation)
       {
        return '';
       }


       var url = '/indicar_que_se_uso_el_servicio_hoy';

       var vue = this;

       var data = {servicio_a_editar:servicio,
                            socio_id:this.socio.id,
                         servicio_id:servicio.id,
                          empresa_id:this.empresa.id};

       axios.post(url,data).then(function(response){ 


          
          if(response.data.Validacion == true)
          {
            
            
             
             vue.$emit("ActualizarSocios", response.data.Empresa.socios_de_la_empresa);

             $.notify(response.data.Validacion_mensaje, "success");
          }
          else
          {
            $.notify(response.data.Validacion_mensaje, "warn");
          }    
           
           
           }).catch(function (error){

                     
            
           });



  

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
           {{-- <span class="listado-socio-icono"><i class="fas fa-portrait"></i></span>  --}}
           {!! Form::open(['route' => ['get_socio_panel'],
                                'method'=> 'Post',
                                'files' =>  true,
                              ])               !!}   

           <input type="hidden" name="empresa_id" :value="empresa.id">
           <input type="hidden" name="socio_id" :value="socio.id">
           <span :id="socio.id"></span>
           <div class="listado-socios-sub-name-email"> 
              <span class="simula_link"  v-on:click="enviar_form(socio.id)">@{{socio.name}}</span>
              <span class="listado-socios-sub-name-email__email"> @{{socio.email}}</span>
           </div>
          
           {!! Form::close() !!} 
        </div>
        <estado-de-cuenta-socio-saldo :empresa="empresa" :socio="socio"> </estado-de-cuenta-socio-saldo>
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
              <div class="listado-socio-lista-servicio-disponible">
                <span class="listado-socio-lista-servicio-disponible-servicio"> @{{servicio.name}}</span>
                <span class="listado-socio-lista-servicio-disponible-accion simula_link"  v-on:click="consumir_esta_clase(servicio)" title="Consumir está clase"> <i class="far fa-check-square"></i></span>
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
             <span v-else v-on:click="abrir_cerrar_mensual" > <i class="fas fa-chevron-down"></i></span>  
          </span>
           <div v-if="mensuales_desplegadas" class="listado-socio-contiene-clases-o-mensuales">
              <div v-for="servicio in socio.servicios_contratados_disponibles_tipo_mensual" :key="servicio.id">
               <div class="listado-socio-lista-servicio-disponible">
                <span class="listado-socio-lista-servicio-disponible-servicio"> @{{servicio.name}}</span>               
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