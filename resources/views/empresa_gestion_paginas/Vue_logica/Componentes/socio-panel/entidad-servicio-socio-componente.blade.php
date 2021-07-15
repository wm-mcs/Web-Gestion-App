Vue.component("servicio-socio-lista", {
  props: ["servicio", "empresa"],

  data: function() {
    return {
      destroy_modal: false,
      cargando: false
    };
  },
  mounted: function mounted() {},
  methods: {
    ditintoDeNull: function(valor) {
      if (valor != null) {
        return valor;
      }
      return false;
    },

    borrar_servicio: function(servicio) {
      var validation = confirm("¿Quieres eliminar el servicio?");

      if (!validation) {
        return "";
      }

      var url = "/borrar_servicio_de_socio";

      var vue = this;

      this.cargando = true;

      var data = {
        socio_id: this.servicio.socio_id,
        servicio_id: this.servicio.id,
        empresa_id: this.empresa.id
      };

      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            var id_modal = "#" + vue.open_modal;
            bus.$emit("sucursal-set", response.data.sucursal);
            vue.cargando = false;
            app.cerrarModal(id_modal);
            vue.$emit("actualizar_socio", response.data.Socio);

            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {});
    },
    EditarServicio: _.debounce(function(servicio) {
      var url = "/editar_servicio_a_socio";

      var vue = this;

      var data = {
        servicio_a_editar: this.servicio,
        socio_id: this.servicio.socio_id,
        servicio_id: this.servicio.id,
        empresa_id: this.empresa.id
      };

      this.cargando = true;

      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.$emit("actualizar_socio", response.data.Socio);
            vue.cargando = false;
            app.cerrarModal(
              "#" + "modal-editar-servicio-socio-" + String(servicio.id)
            );
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {});
    }, 1000),
    abrir_modal_editar: function() {
      $("#" + this.open_modal)
        .appendTo("body")
        .modal("show");
    },
    indicar_que_se_uso_hoy: function() {
      var validation = confirm("¿Quieres indicar que se usó este servicio?");

      if (!validation) {
        return "";
      }

      var url = "/indicar_que_se_uso_el_servicio_hoy";

      var vue = this;

      var data = {
        servicio_a_editar: this.servicio,
        socio_id: this.servicio.socio_id,
        servicio_id: this.servicio.id,
        empresa_id: this.empresa.id
      };

      this.cargando = true;

      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.cargando = false;
            vue.$emit("actualizar_socio", response.data.Socio);
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {});
    }
  },
  computed: {
    esta_activo: function() {
      if (
        this.servicio.esta_vencido == true ||
        this.servicio.se_consumio == true
      ) {
        return false;
      } else {
        return true;
      }
    },
    se_consumio: function() {
      if (this.servicio.se_consumio == true) {
        return true;
      } else {
        return false;
      }
    },
    es_clase: function() {
      if (this.servicio.tipo === "mensual") {
        return false;
      } else {
        return true;
      }
    },
    open_modal: function() {
      return "modal-editar-servicio-socio-" + String(this.servicio.id);
    },
    donde_se_emitio: function() {
      if (this.servicio.sucursal_donde_se_emitio != null) {
        return (
          "Se compró en sucursal " + this.servicio.sucursal_donde_se_emitio.name
        );
      } else {
        return false;
      }
    },
    donde_se_uso: function() {
      if (this.servicio.sucursal_donde_se_uso != "") {
        return "Se usó en sucursal " + this.servicio.sucursal_donde_se_uso.name;
      } else {
        return false;
      }
    }
  },
  template: `


  <div class="contiene-entidad-lista-servicio">

       <div class="d-flex flex-row w-100 justify-content-between">
        
          <div class="d-flex flex-column w-50 p-1">       
                <div class="entidad-lista-name" >
                  @{{servicio.name}} 
                  <span class="margin-left-8px simula_link" v-on:click="abrir_modal_editar" title="Editar el servicio">              
                    <i class="fas fa-pen"></i>
                  </span>
                </div>
                <div class="flex-row-center entidad-lista-servicio-fecha">
                  Precio: @{{servicio.moneda}} @{{servicio.valor}} 
                </div>                  
                <div v-if="cargando" class="Procesando-text">
                  <div class="cssload-container">
                    <div class="cssload-tube-tunnel"></div>
                  </div>
                </div>
                <span v-else>                
                  <span  v-show="!servicio.se_consumio && es_clase"  class="listado-socio-lista-servicio-disponible-accion helper_cursor_pointer " v-on:click="indicar_que_se_uso_hoy" title="Marcar el servicio como ya usado">
                    <i class="far fa-check-square"></i> Usar
                  </span>
                </span>     
                <div  class="entidad-lista-servicio-fecha" > ID: @{{servicio.id}}</div>             
                <div  v-if="servicio.editado_por != null" class="entidad-lista-servicio-fecha" > 
                  Editado por @{{servicio.editado_por}} el @{{servicio.fecha_editada_formateada}}
                </div>
          </div>   
              
          <div class="d-flex flex-column align-items-end w-50 p-1">
             <div v-if="es_clase" class="lista-estado-por-clase">
               <i class="fas fa-undo"></i> Tipo @{{servicio.tipo}}
             </div>
             <div v-else class="lista-estado-por-mensual">
               <i class="fas fa-hourglass-start"></i> Tipo @{{servicio.tipo}}
             </div>        
            <div class="entidad-lista-servicio-contiene-fecha">
              <span class="entidad-lista-servicio-fecha" >
                Contratado el @{{servicio.fecha_contratado_formateada}}                    
              </span>    
              <span  v-if="servicio.creado_por  != null" class="entidad-lista-servicio-fecha text-right" > 
                Vendido por @{{servicio.creado_por}}
              </span>            
              <span v-if="!servicio.esta_vencido" class="entidad-lista-servicio-fecha text-right" >
                Se vence el @{{servicio.fecha_vencimiento_formateada}}
              </span>  
              <div v-if="servicio.esta_vencido" class="lista-estado-consumido" >
               <i class="fas fa-exclamation-circle"></i> Se venció el @{{servicio.fecha_vencimiento_formateada}}
              </div>           
              <div v-if="servicio.se_consumio" class="lista-estado-consumido" > 
                <i class="fas fa-exclamation-circle"></i> Se consumió el @{{servicio.fecha_consumido_formateada}}              
                <span v-if="servicio.quien_marco_que_se_uso  != null"> marcó su uso @{{servicio.quien_marco_que_se_uso}}</span>
              </div>
              <span v-if="donde_se_emitio" class="entidad-lista-servicio-fecha text-right" >@{{donde_se_emitio}}</span> 
              <span v-if="donde_se_uso" class="entidad-lista-servicio-fecha text-right" >@{{donde_se_uso}}</span> 
            </div>
            <div v-if="esta_activo" class="lista-estado-activo" > 
                <i class="fas fa-check"></i> Disponible
            </div>
          </div>

      </div>

             




    <div class="modal fade" :id="open_modal" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div v-if="!destroy_modal" class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Editar @{{servicio.name}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div v-if="!destroy_modal" class="modal-body text-center"> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombres  </label>
                      <input type="text" class="form-control"  v-model="servicio.name" placeholder="Nombre" required  />
                  </div> 
                   <div  class="form-group">
                      <label class="formulario-label" for="Nombre">¿Es por clase o mensual?  </label>
                      <select v-model="servicio.tipo" class="form-control">
                        <option>clase</option>
                        <option>mensual</option>
                      </select>
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Fecha de vencimiento  </label>
                      <input type="date" class="form-control"  v-model="servicio.fecha_vencimiento_formateada"  required  />
                  </div> 

                  <div v-show="se_consumio" class="form-group">
                      <label class="formulario-label" for="Nombre">¿Ya se usó?  </label>
                      <select v-model="servicio.esta_consumido" class="form-control">
                        <option>si</option>
                        <option>no</option>
                      </select>
                  </div> 

                  <div v-show="se_consumio" class="form-group">
                      <label class="formulario-label" for="Nombre">Fecha de cuando se usó  </label>
                      <input type="date" class="form-control"  v-model="servicio.fecha_consumido_formateada"  required  />

                  </div> 
               
                 <div v-if="cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                      </div>
                  <div v-else v-on:click="EditarServicio(servicio)" class="boton-simple">@{{$root.boton_aceptar_texto}}</div>


                   <br>
                   <br>
                  <div v-if="cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                      </div>
                   <div v-if="esta_activo && !cargando" class="simula_link" v-on:click="borrar_servicio(servicio)">
                     Eliminar el servicio <i class="fas fa-trash-alt"></i>
                   </div>
                  
                 
        </div>
        <div v-else>
          <button type="button" class="btn btn-default" data-dismiss="modal">@{{$root.boton_cancelar_texto}}</button>           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">@{{$root.boton_cancelar_texto}}</button>        
        </div>
      </div>
    </div>
  </div>





























            
    </div>
       
       

        

         























  


`
});
