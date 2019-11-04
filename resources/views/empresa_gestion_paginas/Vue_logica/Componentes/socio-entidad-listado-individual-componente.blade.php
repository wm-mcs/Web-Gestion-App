Vue.component('socio-list' ,
{

props:['socio','empresa']
,  



data:function(){
    return {
         clases_desplegadas:false,
      mensuales_desplegadas:false,
     


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
  nadaDisponible:function(){
    if(this.clasesDisponibles || this.mensualDisponibles  )
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

  },
  getClassLista:function(){

     var saldo_pesos   = this.socio.saldo_de_estado_de_cuenta_pesos;
     var saldo_dolares = this.socio.saldo_de_estado_de_cuenta_dolares;

     if(saldo_pesos < 0 || saldo_dolares < 0 )
     {
       var debe = true;
     }
     else
     {
      var debe = false;
     }
    

    return {      
      
      'contenedor-border-rojo': debe,
      'contiene-socio-tipo-lista': true 
    }
  }


},
template:'  
<div v-if="$root.vista_lista" :class="getClassLista">
  <div class="flex-row-center">
   
       {!! Form::open(['route' => ['get_socio_panel'],
                                'method'=> 'Post',
                                'files' =>  true,
                                'class' => 'contiene-socio-lista_nombre-y-celular'
                              ])               !!}   

           <input type="hidden" name="empresa_id" :value="empresa.id">
           <input type="hidden" name="socio_id" :value="socio.id">
           <span class="simula_link contiene-socio-lista"  v-on:click="enviar_form(socio.id)">@{{socio.name}}</span>
        {!! Form::close() !!} 
      <div class="contiene-socio-celular">  
        <i class="fab fa-whatsapp"></i> @{{socio.celular}}    
      </div>
    </div>
    <div class="contiene-planes-socio-lista">
       <div v-if="nadaDisponible" class="listado-socio-no-tiene" >  Nada disponible <i class="far fa-meh"></i></div> 
       <div v-if="clasesDisponibles" class="listado-socio-tiene-clases socio-clases-contenedor">
          <span>
             Tiene <strong>@{{cantidadDeClasesDisponibles}}</strong>  
             <span v-if="clases_desplegadas" v-on:click="abrir_cerrar_clases"><i class="fas fa-chevron-up"></i>  </span>  
             <span v-else v-on:click="abrir_cerrar_clases"> <i class="fas fa-chevron-down"></i></span>            
          </span> 

          <div v-if="clases_desplegadas" class="listado-socio-contiene-clases-o-mensuales" >
            <div v-for="servicio in socio.servicios_contratados_disponibles_tipo_clase" :key="servicio.id">
              <div class="listado-socio-lista-servicio-disponible">
                <span class="listado-socio-lista-servicio-disponible-servicio"> @{{servicio.name}}</span>
                <span class="listado-socio-lista-servicio-disponible-accion "  v-on:click="consumir_esta_clase(servicio)" title="Indicar que el socio va a usar la clase ahora."> Usar</span>
              </div>
            </div>
          </div>

          <div v-if="mensualDisponibles" class="listado-socio-tiene-mensual">
          
          
              <div v-for="servicio in socio.servicios_contratados_disponibles_tipo_mensual" class="planes-mensuales-cotiene" :key="servicio.id">              
                @{{servicio.name}}           
               
              </div>
           
            

        </div>


        </div>

    </div>
    

  </div>
  <div>
    <estado-de-cuenta-socio-saldo :empresa="empresa" :socio="socio"> </estado-de-cuenta-socio-saldo>
  </div>



</div>
<div v-else class="listado-socios-contenedor-individual">
     

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
              <span class="listado-socios-sub-name-whatsapp"> 
                <i class="fab fa-whatsapp"></i> @{{socio.celular}}  
                <span class="listado-socios-sub-name-email__email_email"><i class="far fa-envelope"></i> @{{socio.email}}</span>
               </span>
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
                <span class="listado-socio-lista-servicio-disponible-accion "  v-on:click="consumir_esta_clase(servicio)" title="Indicar que el socio va a usar la clase ahora."> Usar</span>
              </div>
            </div>
          </div>


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

        <div v-if="nadaDisponible" class="listado-socio-no-tiene" >  Nada disponible <i class="far fa-meh"></i></div>
                
      </div>
          
</div>'  

}




);