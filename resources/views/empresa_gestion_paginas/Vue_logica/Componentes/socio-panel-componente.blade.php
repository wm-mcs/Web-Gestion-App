Vue.component("socio-panel-componente", {
  props: ["empresa", "sucursal"],

  data: function() {
    return {
      socio: "",
      cargando: false,
      socio_id:{!! json_encode($Socio_id) !!},
      imagen: ""
    };
  },
  mounted: function mounted() {
    this.get_socio();
  },
  methods: {
    onImageChange: function(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage: function(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.imagen = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    get_socio: function() {
      var url = "/get_socio";

      var data = {
        empresa_id: this.empresa.id,
        socio_id: this.socio_id
      };
      var vue = this;
      this.cargando = true;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.socio = data.Socio;
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {});
    },

    getServiciosDelSocio: function(servicios) {
      if (servicios == "mounted") {
        var url = "/get_servicios_de_socio";

        var data = {
          socio_id: this.socio.id,
          empresa_id: this.empresa.id
        };

        var vue = this;

        axios
          .post(url, data)
          .then(function(response) {
            var data = response.data;

            if (data.Validacion == true) {
              $.notify(data.Validacion_mensaje, "success");

              vue.servicios_del_socio = data.servicios;
            } else {
              $.notify(response.data.Validacion_mensaje, "warn");
            }
          })
          .catch(function(error) {});
      } else {
        this.servicios_del_socio = servicios;
      }
    },
    editSocioShow: function() {
      $("#modal-editar-socio")
        .appendTo("body")
        .modal("show");
    },

    editSocioPost: function() {
      var url = "/post_editar_socio_desde_modal";

      var data = {
        id: this.socio.id,
        name: this.socio.name,
        cedula: this.socio.cedula,
        email: this.socio.email,
        celular: this.socio.celular,
        direccion: this.socio.direccion,
        rut: this.socio.rut,
        razon_social: this.socio.razon_social,
        mutualista: this.socio.mutualista,
        nota: this.socio.nota,
        estado: this.socio.estado,
        socio_id: this.socio.id,
        empresa_id: this.empresa.id,
        celular_internacional: this.socio.celular_internacional,
        imagen: this.imagen
      };

      app.cargando = true;

      var vue = this;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            app.cargando = false;
            app.cerrarModal("#modal-editar-socio");
            $.notify(data.Validacion_mensaje, "success");

            vue.socio = response.data.Socio;
          } else {
            app.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {
          app.cargando = false;
          $.notify(error, "error");
        });
    },
    actualizar_socio: function(socio) {
      this.socio = socio;
    }
  },
  computed: {
    servicios_disponibles: function() {
      return this.socio.servicios_contratados_del_socio.filter(function(
        servicio
      ) {
        if (servicio.esta_vencido == true || servicio.se_consumio == true) {
          return false;
        } else {
          return true;
        }
      });
    },
    servicios_no_disponibles: function() {
      return this.socio.servicios_contratados_del_socio.filter(function(
        servicio
      ) {
        return servicio.esta_vencido == true || servicio.se_consumio == true;
      });
    },
    socio_cargado: function() {
      if (this.socio != "") {
        return true;
      }
    }
  },
  template: `<span v-if="!cargando && socio_cargado">

<div class="row mx-0 align-items-center mb-5">
    <div class="col-12 col-lg-8 mb-2 mb-lg-0 ">
    <div class="row align-items-center justify-content-center justify-content-lg-start w-100">

      <div class="d-flex flex-row align-items-center mb-3 mb-lg-0">
        <div @click="editSocioShow" class="mr-3 cursor-pointer">
            <img class="socio-img  " :src="socio.url_img" />
        </div>
        <div >
            @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.modal-editar-socio')
        </div>
       </div>

    </div>


    </div>
    <div class="col-4 col-lg-1">
    <ingresar-movimiento-a-socio  @actualizar_socio="actualizar_socio" :empresa="empresa" :sucursal="sucursal" :socio="socio"></ingresar-movimiento-a-socio>
    </div>
    <div class="col-8 col-lg-3">
    <agregar-al-socio-un-servicio :socio="socio"
                                   :empresa="empresa"
                                   @actualizar_socio="actualizar_socio" ></agregar-al-socio-un-servicio>


    </div>

  </div>



  <div  v-if="socio.servicios_renovacion_del_socio.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones mb-3">
        Servicios más frecuentemente comprados. Se usan para renovar de forma automática
      </div>
      <div class="panel-socio-contiene-servicios">
            <servicio-renovacion-lista
                                  :empresa="empresa"
                                  :servicio_renovacion="servicio_renovacion"
                          @actualizar_socio="actualizar_socio"

                           v-for="servicio_renovacion in socio.servicios_renovacion_del_socio" :key="servicio_renovacion.id">
            </servicio-renovacion-lista>
      </div>
  </div>
  <div v-else class="cuando-no-hay-socios">
    No hay servicios renovación creados <i class="far fa-frown"></i>
  </div>

  <div  v-if="servicios_disponibles.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones mb-3">
         Servicios que contrató <span class="color-text-success">disponibles</span>
      </div>
      <div class="panel-socio-contiene-servicios">
        <servicio-socio-lista :servicio="servicio"
                              :empresa="empresa"
                      @actualizar_socio="actualizar_socio"
                       v-for="servicio in servicios_disponibles" :key="servicio.id">
        </servicio-socio-lista>
      </div>
  </div>
  <div v-else class="cuando-no-hay-socios">
    No hay servicios disponibles <i class="far fa-frown"></i>
  </div>

   <div v-if="servicios_no_disponibles.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones mb-3">
        Servicios que contrató el socio <span class="color-text-gris">No disponibles</span>
      </div>
      <div class="panel-socio-contiene-servicios">




            <servicio-socio-lista :servicio="servicio"
                                  :empresa="empresa"

                          @actualizar_socio="actualizar_socio"

                           v-for="servicio in servicios_no_disponibles" :key="servicio.id">
            </servicio-socio-lista>



      </div>
  </div>


  <div v-if="socio.estado_de_cuenta_socio.length" class="empresa-contendor-de-secciones">
      <div class="estado-de-cuenta-titulo-saldo-contenedor mb-3">

          <span class="empresa-titulo-de-secciones">Estado de cuenta del socio</span>

          <estado-de-cuenta-socio-saldo :empresa="empresa" :socio="socio"> </estado-de-cuenta-socio-saldo>
      </div>
      <div class="contiene-estados-de-cuenta-lista">







           <estado-de-cuenta-socio v-for="estado in socio.estado_de_cuenta_socio"
                                   :estado_de_cuenta="estado"
                                   :empresa="empresa"
                                   :socio="socio"
                                   :key="estado.id"
                                   @actualizar_socio="actualizar_socio">

           </estado-de-cuenta-socio>





      </div>
  </div>
  <div v-else class="cuando-no-hay-socios">
    Aún no hay movimientos de estado de cuenta  <i class="far fa-frown"></i>
  </div>













</span>
<span v-else class="Procesando-text w-100">
 <div class="cssload-container">
       <div class="cssload-tube-tunnel"></div>
 </div>
</span>`
});
