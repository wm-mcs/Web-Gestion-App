Vue.component("avisos-empresa-admin", {


    mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],

  data: function() {
    return {
      empresa:this.$root.empresa.id,
      avisos: [],
      cargando: false,
      showModal:false,
      mostrarCrearMensaje:false,
      creando:false,
      tipo_de_mensaje_opciones:['success','error','info','warning'],
      dataCrear:{
          empresa_id:this.$root.empresa.id,
          type:'',
          title:'',
          text:'',
          call_to_action:'',
          call_to_action_url:''


      }
    };
  },
  methods: {


    abrir:function(){

        if(this.avisos.length == 0)
        {
            this.getAvisos();
        }

        this.showModal = true;

    },
    setAviso:function(){

    },
    getAvisos: function() {
      var url = "/get_paises_todos";
      var vue = this;
      vue.cargando = true;


      let data = this.dataCrear;
      axios
        .post(url,data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.avisos = data.Data;
            $.notify(response.data.Validacion_mensaje, "success");
            vue.cargando = false;
          } else {
            $.notify(response.data.Validacion_mensaje, "error");
            vue.cargando = false;
          }
        })
        .catch(function(error) {
          vue.cargando = false;
        });
    }
  },
  computed: {

    classType:function(){

        var success = this.dataCrear.type == 'success' ? 'text-success border border-success':'';
        var error = this.dataCrear.type ==  'error' ? 'text-danger border border-danger':'';
        var info = this.dataCrear.type == 'info' ? 'text-info border border-info':'';
        var warning = this.dataCrear.type == 'warning' ? 'text-warning border border-warning':'';

        var clase = `${success} ${error} ${info} ${warning}`;

        return clase;


    }

  },
  mounted: function() {

  },
  created() {

  },

  template: `

  <span class="w-100">



	<div class="col-12">
     <div @click="abrir" class="Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
        Administrar avisos
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






            <div @click="mostrarCrearMensaje = !mostrarCrearMensaje" class="w-100 my-3 text-center simula_link">
                 Crear un mensaje  <i v-if="!mostrarCrearMensaje" class="fas fa-chevron-down"></i><i v-else class="fas fa-chevron-up"></i>
            </div>

            <transition name="fade-enter" v-if="mostrarCrearMensaje">
            <div  class="w-100 background-gris-1 p-2 mb-4" :class="classType" >


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



                <transition name="fade-enter" v-if="errores.length > 0">
                    <div class="col-12 my-2 py-2 background-error cursor-pointer"  >
                        <div @click="handlerClickErrores" class="color-text-error mb-1" v-for="error in errores">@{{error[0]}}</div>
                    </div>
                </transition>

                <div v-if="creando != true"  class="d-flex flex-column align-items-center w-100">
                    <button  type="button" @click="setAviso" class="mt-4 btn btn-lg " :class="classType">
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


            <div v-if="avisos.length > 0">
                <p class="text-center col-12">Historial de mensajes</p>






            </div>
            <div v-else class="color-text-gris my-4 text-center col-12">
                    Aún no se le ha creado ningun mensaje a esta empresa
            </div>





























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
