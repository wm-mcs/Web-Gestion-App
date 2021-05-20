Vue.component("administrar-grupos", {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],
  props:['socio'],
  data: function () {
    return {
      cargando: false,
      empresa_id: this.$root.empresa.id,
      sucursal_id: this.$root.Sucursal.id,
      grupos:[],
      grupos_de_socio:[],
      showModal: false,
      grupo_seleccionado_id:''
    };
  },
  methods: {
    limpiar_data_crear: function () {

    },

    getGrupos: function () {
      var url  = "/get_grupos";
      var data = {empresa_id:this.empresa_id,
                  sucursal_id:this.sucursal_id};

      var vue = this;

      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;

            vue.grupos = data.Data;
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    },
    getGruposDeSocio:function (){


      var url  = "/get_grupos_del_socio";
      var data = {empresa_id:this.empresa_id,
                  socio_id:this.socio.id
                 };

      var vue = this;

      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.grupos_de_socio = data.Data;

            vue.cargando = false;
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    },
    abrirModal:function(){

      if(this.grupos.length == 0)
      {
        this.getGrupos();
      }

      this.showModal = true;
    },
    vincularSocioAGrupo:function(){

      if(this.grupo_seleccionado_id == '')
      {
        return '';
      }
      var url  = "/vincular_socio_con_grupo";
      var data = {empresa_id:this.empresa_id,
                  socio_id:this.socio.id,
                  sucursal_id:this.sucursal_id,
                  grupo_id:this.grupo_seleccionado_id};

      var vue = this;

      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.getGruposDeSocio();
            $.notify(response.data.Validacion_mensaje, "success");
            vue.cargando = false;
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    },
    desvincularDeEsteGrupo:function(grupo_id){


      var url  = "/desvincular_socio_con_grupo";
      var data = {empresa_id:this.empresa_id,
                  socio_id:this.socio.id,
                  sucursal_id:this.sucursal_id,
                  grupo_id:grupo_id};

      var vue = this;

      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.getGruposDeSocio();
            $.notify(response.data.Validacion_mensaje, "success");
            vue.cargando = false;
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    }
  },
  computed: {},
  mounted: function () {
    this.getGruposDeSocio();
  },

  template: `<span>


  <div  v-if="!cargando" class=" helper-fuente-pequeña mb-4" >
    <div v-if="grupos_de_socio.length > 0" class="  p-1 d-flex flex-column ">
      <div class="color-text-gris mb-2">
            <b>Forma parte de</b>
      </div>
      <div v-for="grupo in grupos_de_socio" :key="grupo.id"  class="pl-2 mb-2 ">
        <b>@{{grupo.name}} (Sucursal @{{grupo.sucursal.name}})</b>
      </div>
      <div  @click="abrirModal" class="simula_link " >
        Editar grupos <i class="fas fa-edit"></i>
      </div>
    </div>
    <div  @click="abrirModal" v-else class="color-text-gris">
       Aún no forma parte de ningún grupo. <span class="simula_link">Vincular a algún grupo <i class="fas fa-plus-circle"></i></span>
    </div>
  </div>
  <div v-else class="color-text-gris helper-fuente-pequeña my-2">
    Cargando ...
  </div>



  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Grupos</h4>
            <div class="col-12 modal-mensaje-aclarador">

            </div>
          </div>

          <div class="modal-body">

            <div class="row  mx-0 ">


                 <div v-if="grupos_de_socio.length > 0 && !cargando" class="col-12">
                    <div class="text-center helper-fuente-pequeña mb-3">
                      Actualmente @{{socio.name}} ya está vinculado a los siguientes grupos:
                    </div>

                    <ul>
                      <li class=" text-center" v-for="grupo in grupos_de_socio" :key="grupo.id +' ya-vinculado'"> @{{grupo.name}} (@{{ grupo.sucursal.name}}) <span @click="desvincularDeEsteGrupo(grupo.id)" class="simula_link"><i class="fas fa-user-times"></i></span>  </li>
                    </ul>

                  </div>





            <div v-if="grupos.length > 0 && !cargando" class="formulario-label-fiel">



                  <div class="modal-mensaje-aclarador  text-center mb-2">
                     Si quieres vincular a @{{socio.name}} a algún grupo. Simplemente elegí el grupo al cual quieres vincular a @{{socio.name}}
                  </div>

                <fieldset class="float-label">
                  <select required name="estado" v-model="grupo_seleccionado_id" class="input-text-class-primary" @change="vincularSocioAGrupo">
                     <option value=""></option>
                     <option :value="grupo.id" v-for="grupo in grupos" :key="grupo.id + ' grupo a elegir'">@{{grupo.name}}  (sucursal @{{grupo.sucursal.name}})</option>
                  </select>
                  <label for="elegir_grupo">Elegir un grupo</label>
                </fieldset>
              </div>




              <transition name="fade-enter" v-if="errores.length > 0">
                <div class="col-12 my-2 py-2 background-error cursor-pointer"  >
                <div @click="handlerClickErrores" class="color-text-error mb-1" v-for="error in errores">@{{error[0]}}</div>
                </div>
              </transition>

              <div v-if="cargando" class="Procesando-text w-100">Procesado...</div>

            </div>



          </div>

          <div class="modal-footer">

              <button class="modal-default-button" @click="showModal = false" >
                Cancelar
              </button>

          </div>
        </div>
      </div>
    </div>
  </transition>
</span>

`,
});
