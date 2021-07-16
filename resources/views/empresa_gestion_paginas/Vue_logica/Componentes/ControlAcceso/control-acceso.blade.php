Vue.component("control-acceso", {
  data: function() {
    return {
      cargando: false,
      sucursal:{!! json_encode(Session::get('sucursal'.$Empresa->id)) !!},
      celular: "",
      socio: "",
      countDown: false,
      tiempoCountDown:{{$Empresa->tiempo_luego_consulta_control_access}}, /*Crear porpiedad en la empresa que configure esto*/
    };
  },
  mounted() {
    this.focusInput();
  },
  ready() {},
  methods: {
    focusInput: function() {
      this.$refs.celular.focus();
    },
    verificar_celular: _.debounce(function(celular) {

      if (celular.toString().length > 4) {
        this.consultarSocio(celular);
      }
    }, 800),
    countDownTimer() {
      if (this.countDown == false) {
        if (this.socio != "" && this.validacion.validacion == false) {
          this.countDown = this.tiempoCountDown;
        } else {
          this.countDown = this.tiempoCountDown;
        }
      }
      if (this.countDown > 0) {
        setTimeout(() => {
          this.countDown -= 1;

          if (this.countDown == 0) {
            this.cargando = true;
            location.reload();
          } else {
            this.countDownTimer();
          }
        }, 1000);
      }
    },
    consultarSocio: function(busqueda) {
      this.cargando = true;

      var url = "/control_acceso_socio";

      var data = {
        celular: busqueda,
        empresa_id:{{$Empresa->id}},
        sucursal_id: this.sucursal.id
      };

      var vue = this;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.socio = data.Data;
            vue.cargando = false;

            if (vue.validacion.validacion) {
              let audio = new Audio("sonidos/notificaciones/success.mp3");
              audio.play();
            } else {
              let audio = new Audio("sonidos/notificaciones/warning.mp3");
              audio.play();
            }

            vue.countDownTimer();
          } else {
            vue.cargando = false;
            let audio = new Audio("sonidos/notificaciones/warning.mp3");
            audio.play();
            vue.countDownTimer();
          }
        })
        .catch(function(error) {
          vue.cargando = false;
          $.notify(error, "error");
        });
    }
  },
  watch: {
    celular: {
      immediate: true,
      deep: true,
      handler(newValue, oldValue) {
        this.verificar_celular(newValue);
      }
    }
  },
  computed: {
    estaAlDia: function() {
      if (
        this.socio.saldo_de_estado_de_cuenta_dolares < 0 ||
        this.socio.saldo_de_estado_de_cuenta_pesos < 0
      ) {
        return false;
      }

      return true;
    },
    tieneAlgoContratado: function() {
      if (
        this.socio.servicios_contratados_disponibles_tipo_mensual.length ||
        this.socio.servicios_contratados_disponibles_tipo_clase.length
      ) {
        return true;
      } else {
        return false;
      }
    },
    validacion: function() {
      let Validation;
      let Mensaje;

      if (this.estaAlDia && this.tieneAlgoContratado) {
        Validation = true;
        Mensaje = "";
      }

      if (this.estaAlDia && !this.tieneAlgoContratado) {
        Validation = false;
        Mensaje = "No tenés ningún plan o cuponera vigente";
      }

      if (!this.estaAlDia && !this.tieneAlgoContratado) {
        Validation = false;
        Mensaje =
          "No tenés ningún plan o cuponera vigente y además tenés una deuda de $ " +
          this.socio.saldo_de_estado_de_cuenta_pesos;
      }

      if (!this.estaAlDia && this.tieneAlgoContratado) {
        Validation = false;
        Mensaje =
          "Tenés una deuda de $ " + this.socio.saldo_de_estado_de_cuenta_pesos;
      }

      return {
        validacion: Validation,
        mensaje: Mensaje
      };
    }
  },
  template: `

<div class="controll-access-contenedor d-flex flex-row align-items-center justify-content-center " style="min-height:100vh;" :class="{ 'bg-success': countDown != false && socio != '' && validacion.validacion }">
<div v-if="cargando" class="Procesando-text">

    <div class="cssload-container">
          <div class="cssload-tube-tunnel"></div>
    </div>

</div>

<div v-else class="w-100 d-flex flex-column align-items-center" >
<div  v-if="countDown == false" class="controll-access-easy-socio-logo-wraper d-flex flex-row align-items-center justify-content-center">
  <img class="controll-access-easy-socio-logo" src="/imagenes/Empresa/logo_rectangular.png" alt="EasySocio">
</div>

   <div  class="col-8 col-lg-8 d-flex flex-column align-items-center">

    @if(file_exists($Empresa->path_url_img))
      <div class="col-10 col-lg-5 p-3 p-lg-5">
        <img v-show="countDown === false" class="mb-3 img-fluid" src="{{$Empresa->url_img}}">
      </div>
    @endif

   <div v-show="countDown === false" class="h6 color-text-gris text-center mb-1">
     Para ingresar <i class="fas fa-hand-point-down"></i>
   </div>

    <input v-show="countDown === false" ref="celular" class="controll-access-input-celular my-4" v-model="celular" type="number"  placeholder="Escribí tu celular">
    <div v-if="countDown != false" class="px-0 col-12 col-lg-10">
            <div v-if="socio != ''" class="container d-flex flex-column align-items-center">
               <div :class="{ 'color-text-success': validacion.validacion, 'color-text-gris': validacion.validacion == false }" class="w-100">

               <div class="text-center mb-4 h5 text-white" v-if="validacion.validacion">¡Excelente, estás al día!</div>
               <div class="col-12 row mx-0 shadow p-2 -p-lg-5 rounded mb-4 align-items-center justify-content-center bg-white">
                 <div class="col-12 col-lg-6 row mx-0 align-items-center">
                    <div class="mr-3 w-100">
                      <img class="socio-img" width="60" height="60" :src="socio.url_img" />
                    </div>
                    <div>
                      <div class="text-dark h3 mb-0">
                        @{{socio.name}}
                      </div>
                      <div class="color-text-gris">
                        <small>Cel: @{{socio.celular}}</small>
                      </div>
                    </div>
                 </div>
                 <div class="col-12 col-lg-6 d-flex flex-column align-items-end">
                    <div v-if="validacion.validacion" class="h1  mb-0 color-text-success">
                     <i class="fas fa-check-circle"></i>
                    </div>
                    <div v-if="!validacion.validacion" class="h1 mb-0  color-text-gris">
                      <i class="fas fa-exclamation-triangle"></i>
                    </div>
                 </div>

                 <div v-if="this.socio.servicios_contratados_disponibles_tipo_mensual.length + this.socio.servicios_contratados_disponibles_tipo_clase.length > 0" class="col-12 mt-2 py-3 borde-top-gris ">
                  <div v-if="this.socio.servicios_contratados_disponibles_tipo_mensual.length" class="mb-3">
                    <h4 class="mb-3 h5  text-dark">
                      Membresía vigente <i class="fas fa-hand-point-down"></i>
</h4>
                    <p  v-for="servicio in this.socio.servicios_contratados_disponibles_tipo_mensual" class="mb-1 color-text-gris">
                      <b class="color-text-mensual">@{{servicio.name}}</b>. Se vence el @{{servicio.fecha_vencimiento_formateada}}
                    </p>
                  </div>

                  <div v-if="this.socio.servicios_contratados_disponibles_tipo_clase.length" class="">
                    <h4 class="mb-3 h5  text-dark">
                     Te quedan @{{ this.socio.servicios_contratados_disponibles_tipo_clase.length}}  @{{ this.socio.servicios_contratados_disponibles_tipo_clase.length == 1 ? 'clase' : 'clases' }}   <i class="fas fa-hand-point-down"></i>
</h4>
                    <p  v-for="servicio in this.socio.servicios_contratados_disponibles_tipo_clase" class=" mb-1 color-text-gris">
                      <b class="color-text-clases">@{{servicio.name}}</b>.  Se vence el @{{servicio.fecha_vencimiento_formateada}} .
                    </p>
                  </div>



                 </div>

                </div>
               </div>







                <div v-if="!validacion.validacion" class=" mb-4 color-text-gris p-4 background-error color-text-error">
                  @{{validacion.mensaje}}
                </div>







               <div class="sub-titulos-class color-text-gris text-center mt-4">
                @{{countDown}}
               </div>

            </div>
            <div v-else class="d-flex flex-column align-items-center">
               <div class="sub-titulos-class color-text-gris text-center mb-4">
                 No tenemos ese celular <i class="fas fa-hand-point-right"></i> <b>@{{celular}}</b> en la base de datos  ¿Está bien el número?
               </div>
               <div class="sub-titulos-class color-text-gris text-center mt-4">
                @{{countDown}}
               </div>

            </div>
    </div>
   </div>




</div>
  </div>




`
});
