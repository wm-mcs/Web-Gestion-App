Vue.component("avisos-crear-masivos", {
  mixins: [onKeyPressEscapeCerrarModalMixIn, erroresMixIn],




  data: function() {
    return {
      empresas:{!! json_encode($Empresas) !!},
      mostrar_activas:true,

      cargando: false,
      showModal: false,
      mostrarCrearMensaje: false,
      creando: false,
      tipo_de_mensaje_opciones: ["success", "error", "info", "warning"],
      dataCrear: {
        type: "",
        title: "",
        text: "",
        call_to_action: "",
        call_to_action_url: "",
        se_envia_email:'no',
        empresas_a_enviar:[],
      }
    };
  },
  methods: {
    abrir: function() {


      this.showModal = true;
    },
    setAviso: function() {},

    crear: function() {
      var url = "/crear_aviso_empresa_masivo";
      var vue = this;
      vue.creando = true;

      let data = this.dataCrear;
      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {

            vue.creando = false;
            vue.showModal = false;
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            $.notify(response.data.Validacion_mensaje, "error");
            vue.creando = false;
          }
        })
        .catch(function(error) {
          vue.creando = false;
        });
    }
  },
  computed: {
    classType: function() {
      var success =
        this.dataCrear.type == "success"
          ? "text-success border border-success"
          : "";
      var error =
        this.dataCrear.type == "error"
          ? "text-danger border border-danger"
          : "";
      var info =
        this.dataCrear.type == "info" ? "text-info border border-info" : "";
      var warning =
        this.dataCrear.type == "warning"
          ? "text-warning border border-warning"
          : "";

      var clase = `${success} ${error} ${info} ${warning}`;

      return clase;
    },
    empresasFiltradas:function(){
       var empresas = this.empresas;

       if(this.mostrar_activas)
       {
            empresas = empresas.filter(
                empresa => empresa.estado == 'si'
            );
       }

       return empresas;
    }
  },
  mounted: function() {},
  created() {},

  template: `

  <span class="w-100">



	<div class="col-12">
     <div @click="abrir" class="Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
        Crear aviso masivo
     </div>

    </div>
    <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>





          <div class="modal-body">

            <div class="row  mx-0 ">









            <transition name="fade-enter" >
            <div  class="w-100  p-2 mb-4" :class="classType" >


                <h2 class="text-center mb-5
                ">Crear aviso masivo</h2>

            <div class="formulario-label-fiel">


                <fieldset class="float-label">
                    <select required name="type" v-model="dataCrear.type" class="input-text-class-primary" :class="classType">
                        <option></option>
                        <option v-for="type in tipo_de_mensaje_opciones" :value="type"> @{{type}}</option>
                    </select>
                    <label for="type">¿Qué tipo de mensaje es?</label>
                </fieldset>
            </div>

            <div class="formulario-label-fiel">


            <fieldset class="float-label">
                <select required name="se_envia_email" v-model="dataCrear.se_envia_email" class="input-text-class-primary" :class="classType">

                    <option  value="si">si</option>
                    <option  value="no">no</option>
                </select>
                <label for="se_envia_email">¿Se envía email?</label>
            </fieldset>
            </div>




            <div class="formulario-label-fiel">

                <fieldset class="float-label">

                 <textarea name="title" id="" cols="30"  class="input-text-class-primary" :class="classType"
                    v-model="dataCrear.title" required rows="10"></textarea>

                    <label for="title">Título</label>
                </fieldset>
            </div>
            <div class="formulario-label-fiel">

                <fieldset class="float-label">

                 <textarea name="text" id="" cols="30"  class="input-text-class-primary" :class="classType"
                    v-model="dataCrear.text" required rows="30"></textarea>

                    <label for="text">Texto</label>
                </fieldset>
            </div>
             <div class="formulario-label-fiel">

                <fieldset class="float-label">

                <input
                        name="call-to-action"
                        type="text"
                        class="input-text-class-primary"
                        v-model="dataCrear.call_to_action"
                        required
                        :class="classType"

                      />

                    <label for="call-to-action">Call to action</label>
                </fieldset>
            </div>
             <div class="formulario-label-fiel">

                <fieldset class="float-label">

                <input
                        name="link-call-to-action"
                        type="text"
                        class="input-text-class-primary"
                        v-model="dataCrear.call_to_action_url"
                        required
                        :class="classType"

                      />

                    <label for="link-call-to-action">Url call to action</label>
                </fieldset>
            </div>


                 <div class="formulario-label-fiel">
                  <div  class="col-12 formulario-label"
                  >
                  ¿A quién le enviamos?
                  </div>
                  <div class="mb-5">
                      <small>Solo empresas activas </small>   <input type="checkbox" v-model="mostrar_activas">

                  </div>
                  <div v-for="empresa in empresasFiltradas" :key="empresa.id + 'empresa'" class="col-12">
                      <label :for="empresa.name">@{{empresa.name}}</label>
                      <input type="checkbox" :id="empresa.name" :value="empresa.id" v-model="dataCrear.empresas_a_enviar">
                  </div>






                </div>



                <transition name="fade-enter" v-if="errores.length > 0">
                    <div class="col-12 my-2 py-2 background-error cursor-pointer"  >
                        <div @click="handlerClickErrores" class="color-text-error mb-1" v-for="error in errores">@{{error[0]}}</div>
                    </div>
                </transition>

                <div v-if="creando != true"  class="d-flex flex-column align-items-center w-100">
                    <button  type="button" @click="crear" class="mt-4 btn btn-lg " :class="classType">
                            Crear mensaje
                    </button>
                </div>
                <div v-else class="my-3  Procesando-text w-100">
                    <div class="cssload-container">
                        <div class="cssload-tube-tunnel"></div>
                    </div>
                </div>
            </div>
            </transition>































            </div>



          </div>

          <div class="modal-footer">

              <div class="w-100 text-right" @click="showModal = false" >
                Cerrar
</div>

          </div>
        </div>
      </div>
    </div>
  </transition>



  </span>
`
});
