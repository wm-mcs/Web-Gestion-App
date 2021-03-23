Vue.component("socio-list", {
  props: ["socio", "empresa", "acceso"],
  data: function() {
    return {
      clases_desplegadas: false,
      mensuales_desplegadas: false,
      cargando: false
    };
  },

  methods: {
    enviar_form: function(id) {
      var id = "#" + id.toString();

      $(id)
        .parent()
        .submit();
    },
    abrir_cerrar_clases: function() {
      if (this.clases_desplegadas) {
        this.clases_desplegadas = false;
      } else {
        this.clases_desplegadas = true;
      }
    },
    abrir_cerrar_mensual: function() {
      if (this.mensuales_desplegadas) {
        this.mensuales_desplegadas = false;
      } else {
        this.mensuales_desplegadas = true;
      }
    },
    consumir_esta_clase: function(servicio) {
      var mensaje =
        "¿Seguro quieres consumir está clase? (de " + this.socio.name + " )";

      var validation = confirm(mensaje);

      if (!validation) {
        return "";
      }

      var url = "/indicar_que_se_uso_el_servicio_hoy";

      var vue = this;

      var data = {
        servicio_a_editar: servicio,
        socio_id: this.socio.id,
        servicio_id: servicio.id,
        empresa_id: this.empresa.id
      };

      this.cargando = true;

      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.cargando = false;

            vue.$emit("ActualizarSocios", response.data.Socios);

            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {});
    },
    cargar_servicios: function() {
      var mensaje =
        "¿Seguro quieres renovar los servicios? (de " + this.socio.name + " )";

      var validation = confirm(mensaje);

      if (!validation) {
        return "";
      }

      var url = "/cargar_servicios_recuerrentes_a_socio";

      var vue = this;

      var data = {
        socio_id: this.socio.id,
        empresa_id: this.empresa.id
      };

      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.$emit("ActualizarSocios", response.data.Socios);

            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {});
    }
  },
  computed: {
    desactivado: function() {
      if (this.socio.estado != "si") {
        return true;
      } else {
        return false;
      }
    },

    clasesDisponibles: function() {
      if (this.socio.servicios_contratados_disponibles_tipo_clase.length > 0) {
        return true;
      } else {
        return false;
      }
    },
    mensualDisponibles: function() {
      if (
        this.socio.servicios_contratados_disponibles_tipo_mensual.length > 0
      ) {
        return true;
      } else {
        return false;
      }
    },
    nadaDisponible: function() {
      if (this.clasesDisponibles || this.mensualDisponibles) {
        return false;
      } else {
        return true;
      }
    },
    cantidadDeClasesDisponibles: function() {
      var cantidad = this.socio.servicios_contratados_disponibles_tipo_clase
        .length;

      if (cantidad > 0) {
        if (cantidad > 1) {
          return cantidad + " clases disponibles";
        } else {
          return cantidad + " clase disponible";
        }
      } else {
        return 0;
      }
    },
    cantidadDeMensualesDisponibles: function() {
      var cantidad = this.socio.servicios_contratados_disponibles_tipo_mensual
        .length;
      if (cantidad > 0) {
        if (cantidad > 1) {
          return cantidad + " mensuales disponibles";
        } else {
          return cantidad + " mensual disponible";
        }

        return cantidad;
      } else {
        return 0;
      }
    },
    getClassLista: function() {
      var saldo_pesos = this.socio.saldo_de_estado_de_cuenta_pesos;
      var saldo_dolares = this.socio.saldo_de_estado_de_cuenta_dolares;

      if (saldo_pesos < 0 || saldo_dolares < 0) {
        var debe = true;
      } else {
        var debe = false;
      }

      return {
        "contiene-socio-tipo-lista": true
      };
    },
    mostrarEstadoDeCuenta: function() {
      if (this.nadaDisponible) {
        if (
          this.socio.saldo_de_estado_de_cuenta_dolares != 0 ||
          this.socio.saldo_de_estado_de_cuenta_pesos != 0
        ) {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    },
    tieneServiciosRenovacion: function() {
      if (this.socio.servicios_renovacion_del_socio.length) {
        return true;
      } else {
        return false;
      }
    },
    whatsAppLink: function() {
      if (
        this.socio.celular_internacional == "" ||
        this.socio.celular_internacional == null
      ) {
        var celular =
          this.empresa.codigo_pais_whatsapp + this.socio.celular.substr(1);
      } else {
        var celular = this.socio.celular_internacional;
      }

      var url = "https://api.whatsapp.com/send?phone=" + celular + "&text=Hola";

      return url;
    },
    whatsAppnumero: function() {
      if (
        this.socio.celular_internacional == "" ||
        this.socio.celular_internacional == null
      ) {
        return this.socio.celular;
      } else {
        return this.socio.celular_internacional;
      }
    }
  },
  template: `  
<div v-if="$root.vista_lista" :class="getClassLista">
  
    
       {!! Form::open([         'route' => ['get_socio_panel'],
                                'method'=> 'Post',
                                'files' =>  true,
                                'class' => 'contiene-socio-lista_nombre-y-celular'
                              ])               !!}   

           <input type="hidden" name="empresa_id" :value="empresa.id">
           <span :id="socio.id" class="no-mostrar"></span>
           <input type="hidden" name="socio_id" :value="socio.id">


           <img  class="socio-img mx-3 " :src="socio.url_img"/>
           <span class="contiene-socio-lista"  v-on:click="enviar_form(socio.id)">@{{socio.name}}</span>

      
     
      <a :href="whatsAppLink"  target="_blank">
        <div class="contiene-socio-celular">  
          <i class="fab fa-whatsapp"></i> @{{whatsAppnumero}}    
        </div>
      </a> 
     {!! Form::close() !!} 

   
    <div class="contiene-planes-socio-lista">
       <div v-if="nadaDisponible" class="listado-socio-no-tiene" >  Nada disponible <i class="far fa-meh"></i></div> 
       <div v-if="clasesDisponibles" class="listado-socio-tiene-clases socio-clases-contenedor">
          <span>
             
             <span v-if="clases_desplegadas" v-on:click="abrir_cerrar_clases"> Tiene <strong>@{{cantidadDeClasesDisponibles}}</strong>  <i class="fas fa-chevron-up"></i>  </span>  
             <span v-else v-on:click="abrir_cerrar_clases"> Tiene <strong>@{{cantidadDeClasesDisponibles}}</strong>  <i class="fas fa-chevron-down"></i></span>            
          </span> 

          <div v-if="clases_desplegadas" class="listado-socio-contiene-clases-o-mensuales" >
            <div v-for="servicio in socio.servicios_contratados_disponibles_tipo_clase" :key="servicio.id">
              <div class="listado-socio-lista-servicio-disponible">
                <span class="listado-socio-lista-servicio-disponible-servicio"> @{{servicio.name}}</span>
                <div v-if="cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                </div>
                <span v-else class="listado-socio-lista-servicio-disponible-accion "  v-on:click="consumir_esta_clase(servicio)" title="Indicar que el socio va a usar la clase ahora."> Usar</span>
              </div>
            </div>
          </div>



        </div>

         
          
          
              <div v-if="mensualDisponibles" v-for="servicio in socio.servicios_contratados_disponibles_tipo_mensual" 
                   class="planes-mensuales-cotiene" :key="servicio.id">              
                <span>@{{servicio.name}}</span>  
                <span class="plan-mensual-fecha-vencimiento">Vence: @{{servicio.fecha_vencimiento_formateada}}</span>       
               
              </div>
           
            

        


        

    </div>
    

  <div v-if="desactivado"></div>
  
  <div class="socio-lista-contiene-estado-de-cuenta" >
    
    <estado-de-cuenta-socio-saldo v-if="mostrarEstadoDeCuenta" :empresa="empresa" :socio="socio"> </estado-de-cuenta-socio-saldo>

     <p class="color-text-gris mt-2 mb-0" v-if="acceso != null && acceso != undefined"> 
      <small>@{{acceso.fecha_formateada }}</small>  
     </p>
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
        <span v-if="mostrarEstadoDeCuenta">          
          <estado-de-cuenta-socio-saldo  :empresa="empresa" :socio="socio"> </estado-de-cuenta-socio-saldo>
        </span>
        
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
          
</div>`
});
