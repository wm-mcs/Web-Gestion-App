var Lista = {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],
  props: ["entidad", "actividades"],
  data: function () {
    return {
      cargando: false,
      entidadAEditar: this.entidad,
      showModal: false,
      diasQueRepiteArray: [],
    };
  },
  methods: {
    onChangeActividad: function () {
      let actividad = this.actividades.filter(
        (actividad) => actividad.id == this.entidadAEditar.actividad_id
      )[0];
      this.entidadAEditar.actividad_id = actividad.id;
      this.entidadAEditar.name = actividad.name;
    },
    edit: function () {
      var url = "/editar_agenda";

      var data = {
        empresa_id: this.$root.empresa.id,
        sucursal_id:this.$root.Sucursal.id,
        id: this.entidadAEditar.id,
        name: this.entidadAEditar.name,
        days: this.diasQueRepiteArray,
        hora_inicio: this.entidadAEditar.hora_inicio,
        hora_fin: this.entidadAEditar.hora_fin,
        actividad_id: this.entidadAEditar.actividad_id,
        tiene_limite_de_cupos: this.entidadAEditar.tiene_limite_de_cupos,
        cantidad_de_cupos: this.entidadAEditar.cantidad_de_cupos,
        estado: this.entidadAEditar.estado,
      };

      var vue = this;
      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.showModal = false;
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
    eliminar:function(){
      var url = "/eleminar_actividad";

      var validation = confirm("¿De verdad lo querés borrar?");

      if(!validation)
      {
       return '';
      }
      const data = {
        empresa_id: this.$root.empresa.id,
        id: this.entidadAEditar.id,

      };

      var vue = this;
      vue.cargando = true;

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.showModal = false;
            bus.$emit("se-creo-o-edito", "hola");
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;

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
    this.diasQueRepiteArray = this.entidadAEditar.days.split(",");
  },
  created() {},

  template: `
  <div class="w-100 mb-1">

  <div class="px-2 py-2 agenda-lista-contenedor background-gris-0" :style="{ borderLeftColor: entidadAEditar.actividad.color, opacity:entidadAEditar.estado == 'si' ? '1':'0.5'}">
    <h3 class="agenda-lista-name mb-2 simula_link" @click="showModal = true" >
      <b>@{{entidadAEditar.actividad.name}}</b> <i class="fas fa-edit"></i>
    </h3>
    <p class="agenda-lista-dato mb-2">
      <i class="far fa-clock"></i>  <b>@{{entidadAEditar.hora_inicio}}</b> a   <b>@{{entidadAEditar.hora_fin}}</b> hs.
    </p>

    <p class="agenda-lista-dato mb-0">
      <small>
      <i class="far fa-user"></i> <span v-if="entidadAEditar.tiene_limite_de_cupos == 'si'"> Cupo de personas máximo <b>@{{entidadAEditar.cantidad_de_cupos}}</b>  </span>
      <span v-else> No tiene límite de cupo</span>.

      </small>

    </p>
    <p v-if="entidadAEditar.estado != 'si'" class="agenda-lista-dato mt-2 mb-0 text-uppercase">
      DESACTIVADA
    </p>


  </div>
  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Editar el cronograma de @{{entidadAEditar.name}}</h4>
            <div class="col-12 modal-mensaje-aclarador">

            </div>



          </div>


          <div class="modal-body">

            <div class="row  mx-0 ">


            <div class="formulario-label-fiel">

<div class="modal-mensaje-aclarador">
    Actividad
    </div>
  <fieldset class="float-label">

  <select required name="actividad_id" v-model="entidadAEditar.actividad_id"  @change="onChangeActividad" class="input-text-class-primary">

      <option :value="actividad.id" v-for="actividad in actividades" :key="actividad.id">@{{actividad.name}}</option>


    </select>

    <label for="actividad_id">Actividad</label>
  </fieldset>
</div>





      <div v-if="entidadAEditar.actividad_id != ''" class="row w-100 mx-0 ">
      <div class="modal-mensaje-aclarador col-12 px-1 ">

      Indicá entre qué horas es
      </div>
      <div class="col-6 p-0">
      <div class=" formulario-label-fiel">
        <fieldset class="float-label">
          <input
            name="hora_inicio"
            type="time"
            class="input-text-class-primary"
            v-model="entidadAEditar.hora_inicio"
            required

          />
          <label for="hora_inicio">Hora inicio</label>
        </fieldset>
      </div>
      </div>
      <div class="col-6 p-0">
      <div class=" formulario-label-fiel">
        <fieldset class="float-label">
          <input
            name="hora_fin"
            type="time"
            class="input-text-class-primary"
            v-model="entidadAEditar.hora_fin"
            required

          />
          <label for="hora_fin">Hora fin</label>
        </fieldset>
      </div>
      </div>


      </div>



      <div v-if="entidadAEditar.hora_fin != '' && entidadAEditar.hora_inicio != ''  && entidadAEditar.actividad_id != '' " class="formulario-label-fiel">
      <div  class="col-12 modal-mensaje-aclarador mb-2"
      >
      ¿En qué días se repite @{{entidadAEditar.name}} en el horarío de @{{entidadAEditar.hora_inicio}} hs a @{{entidadAEditar.hora_fin}} hs ? <b>Seleccioná el o los días.</b>
      </div>
      <div class="col-12">
          <label for="lunes">Lunes</label>
          <input type="checkbox" id="lunes" value="1" v-model="diasQueRepiteArray">
      </div>
      <div class="col-12">
          <label for="martes">Martes</label>
          <input type="checkbox" id="martes" value="2" v-model="diasQueRepiteArray">
      </div>
      <div class="col-12">
          <label for="miercoles">Miércoles</label>
          <input type="checkbox" id="miercoles" value="3" v-model="diasQueRepiteArray">
      </div>
      <div class="col-12">
          <label for="jueves">Jueves</label>
          <input type="checkbox" id="jueves" value="4" v-model="diasQueRepiteArray">
      </div>
      <div class="col-12">
          <label for="viernes">Viernes</label>
          <input type="checkbox" id="viernes" value="5" v-model="diasQueRepiteArray">
      </div>
      <div class="col-12">
          <label for="sabado">Sábado</label>
          <input type="checkbox" id="sabado" value="6" v-model="diasQueRepiteArray">
      </div>
      <div class="col-12">
          <label for="domingo">Domingo</label>
          <input type="checkbox" id="domingo" value="7" v-model="diasQueRepiteArray">
      </div>



      </div>




      <div v-if="entidadAEditar.hora_fin != ''
       && entidadAEditar.hora_inicio != ''
       && entidadAEditar.actividad_id != ''
       && diasQueRepiteArray.length > 0  " class="formulario-label-fiel">

         <div class="modal-mensaje-aclarador">
          Indicá si tiene límite de cupos-
        </div>
        <fieldset class="float-label">

        <select required name="tiene_limite_de_cupos" v-model="entidadAEditar.tiene_limite_de_cupos" class="input-text-class-primary">

            <option>si</option>
            <option>no</option>

          </select>

          <label for="tiene_limite_de_cupos">¿Tiene límite de cupos?</label>
        </fieldset>
      </div>


      <div v-if="entidadAEditar.tiene_limite_de_cupos == 'si'" class="formulario-label-fiel">

        <div class="modal-mensaje-aclarador">
           ¿Cuál es la cantidad máxima de personas por clase ?
            </div>
          <fieldset class="float-label">

          <input
            name="cantidad_de_cupos"
            type="number"
            class="input-text-class-primary"
            v-model="entidadAEditar.cantidad_de_cupos"
            required

          />

            <label for="cantidad_de_cupos">Cantidad máxima de personas por clase</label>
          </fieldset>
        </div>



      <div class="formulario-label-fiel">

      <div class="modal-mensaje-aclarador">
          Activar o desactivar está actividad del cronograma. QUITAR ESTO PARA LA PARTE DE CREAR LUEGO DE CREAR LA LISTA
          </div>
        <fieldset class="float-label">

        <select required name="estado" v-model="entidadAEditar.estado" class="input-text-class-primary">

            <option>si</option>
            <option>no</option>

          </select>

          <label for="estado">¿Está activa?</label>
        </fieldset>
      </div>


      <transition name="fade-enter" v-if="errores.length > 0">
        <div class="col-12 my-2 py-2 background-error cursor-pointer"  >
          <div @click="handlerClickErrores" class="color-text-error mb-1" v-for="error in errores">@{{error[0]}}</div>
        </div>
      </transition>


              <button v-if="cargando != true" type="button" @click="edit" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Editar
              </button>
              <div v-else class="my-3  Procesando-text w-100">
        <div class="cssload-container">
            <div class="cssload-tube-tunnel"></div>
        </div>
    </div>

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




  </div>

`,
};
