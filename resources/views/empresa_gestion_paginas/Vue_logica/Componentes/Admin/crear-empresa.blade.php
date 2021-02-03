Vue.component("crear-empresa", {
  data: function() {
    return {
      modal: "#modal-crear-empresa",
      data_post: {
        empresa_name: "",
        empresa_celular: "",
        empresa_email: "",
        user_name: "",
        user_email: "",
        user_celular: "",
        plan_id: "",
        factura_con_iva: "no",
        razon_social: "",
        rut: "",
        pais: "UY"
      },
      cargando: false,
      planes: [],
      paises: []
    };
  },
  methods: {
    abrir_modal: function() {
      this.getPlanes();
      this.getPaises();
      $(this.modal)
        .appendTo("body")
        .modal("show");
    },
    crear_empresa_post: function() {
      var validation = confirm("¿Seguros quieres crear la empresa?");
      if (!validation) {
        return "";
      }
      var url = "/crear_empresa_nueva";
      var vue = this;
      var data = this.data_post;
      app.cargando = true;
      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            app.cargando = false;
            app.cerrarModal("#modal-crear-empresa");
            bus_empresas.$emit("empresas-set", response.data.empresas);
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            app.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {});
    },
    getPlanes: function() {
      const url = "/get_planes_empresa";
      let vue = this;
      this.cargando = true;
      axios
        .get(url)
        .then(function(response) {
          var data = response.data;
          if (data.Validacion == true) {
            vue.planes = data.Data;
            vue.cargando = false;
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
    },
    getPaises: function() {
      const url = "/get_paises_todos";
      let vue = this;
      this.cargando = true;

      axios
        .get(url)
        .then(function(response) {
          var data = response.data;
          if (data.Validacion == true) {
            vue.paises = data.Data;
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {
          vue.cargando = false;
        });
    },
    get_valor_dependiendo_si_es_conIva: function(valor) {
      if (this.data_post.factura_con_iva == "no") {
        return valor;
      } else {
        return;
        parseFloat(valor * 1.22).toFixed(1) + " iva inc ";
      }
    }
  },
  computed: {
    es_con_rut: function() {
      if (this.data_post.factura_con_iva == "si") {
        return;
        true;
      } else {
        return false;
      }
    }
  },
  template: `

<span>
  <div
    style="position:relative;"
    class="admin-user-boton-Crear"
    v-on:click="abrir_modal"
  >
    Crear Empresa
  </div>

  <div
    class="modal fade"
    id="modal-crear-empresa"
    tabindex="+1"
    role="dialog"
    aria-labelledby="myModalLabel"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="">
            <h4 class="modal-title" id="myModalLabel">Crear nueva empresa</h4>
            <div class="modal-mensaje-aclarador">
              Aquí tu como vendedor, vas a crear una empresa y el usuario para
              que la persona pueda comenzar a operar. Por defecto ya quedarás
              asociado como vendeor, el usuario será asociado como dueño y se
              creará una Sucursal como principal. Se le enviará un email al
              usuario con los datos para ingresar.
            </div>
          </div>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true"><i class="fas fa-times"></i></span>
          </button>
        </div>
        <div class="modal-body">
          {{-- empresa datos --}}
          <div class="contenedor-grupo-datos">
            <div class="contenedor-grupo-datos-titulo">Empresa datos</div>
            <div class="contenedor-formulario-label-fiel">
              <p v-if="cargando" class="Procesando-text">Cargando...</p>
              <div v-else class="formulario-label-fiel">
                {!! Form::label('pais', 'País', array('class' =>
                'formulario-label ')) !!}

                <select class="formulario-field" v-model="data_post.pais">
                  <option v-for="pais in paises" :value="pais.code">
                    @{{ pais.name }}</option
                  >
                </select>
              </div>
              <div class="formulario-label-fiel">
                {!! Form::label('empresa_name', 'Nombre', array('class' =>
                'formulario-label ')) !!} {!! Form::text('empresa_name', null
                ,['class' => 'formulario-field', 'v-model' =>
                'data_post.empresa_name' ]) !!}
              </div>
              <div class="formulario-label-fiel">
                {!! Form::label('empresa_email', 'Email', array('class' =>
                'formulario-label ')) !!} {!! Form::text('empresa_email', null
                ,['class' => 'formulario-field', 'v-model' =>
                'data_post.empresa_email' ]) !!}
              </div>
              <div class="formulario-label-fiel">
                {!! Form::label('empresa_celular', 'Celular', array('class' =>
                'formulario-label ')) !!}
                <div v-if="data_post.pais != 'UY'"  class="modal-mensaje-aclarador">
    Si la empresa es de fuera de Uruguay se debe poner todos los dígitos menos el simbolo de +.
  </div> {!! Form::text('empresa_celular', null
                ,['class' => 'formulario-field', 'v-model' =>
                'data_post.empresa_celular' ]) !!}
              </div>
            </div>
          </div>

          {{-- usuario datos --}}
          <div class="contenedor-grupo-datos">
            <div class="contenedor-grupo-datos-titulo">Usuario datos</div>
            <div class="modal-mensaje-aclarador">
              Los datos del usuario que va a operar el negocio. Esto le creara
              el usuario y lo asociara a la empresa que se crea de forma
              automática.
            </div>
            <div class="contenedor-formulario-label-fiel">
              <div class="formulario-label-fiel">
                {!! Form::label('user_name', 'Nombre del usuario', array('class'
                => 'formulario-label ')) !!} {!! Form::text('user_name', null
                ,['class' => 'formulario-field', 'v-model' =>
                'data_post.user_name' ]) !!}
              </div>
              <div class="formulario-label-fiel">
                {!! Form::label('user_email', 'Email del usuario', array('class'
                => 'formulario-label ')) !!} {!! Form::text('user_email', null
                ,['class' => 'formulario-field', 'v-model' =>
                'data_post.user_email' ]) !!}
              </div>
              <div class="formulario-label-fiel">
                {!! Form::label('user_celular', 'Celular del usuario',
                array('class' => 'formulario-label ')) !!}
                <div v-if="data_post.pais != 'UY'" class="modal-mensaje-aclarador">
                Si la empresa es de fuera de Uruguay se debe poner todos los dígitos menos el simbolo de +.
              </div> {!!
                Form::text('user_celular', null ,['class' => 'formulario-field',
                'v-model' => 'data_post.user_celular' ]) !!}
              </div>
            </div>
          </div>
          <div class="contenedor-grupo-datos">
            <div class="contenedor-grupo-datos-titulo">¿Factura con Rut?</div>
            <div class="modal-mensaje-aclarador">
              Si el cliente solciita factura con ruto marcar en si
            </div>

            <div class="contiene-fase-2-moneda">
              <div class="crear-empresa-contiene-opciones-planes">
                <div class="contiene-opcione-planes">
                  <input
                    type="radio"
                    value="si"
                    v-model="data_post.factura_con_iva"
                  />
                  <label class="moneda-label" for="si">
                    <span>Si</span>
                  </label>
                </div>
                <div class="contiene-opcione-planes">
                  <input
                    type="radio"
                    value="no"
                    v-model="data_post.factura_con_iva"
                  />
                  <label class="moneda-label" for="no">
                    <span>No</span>
                  </label>
                </div>
              </div>
            </div>

            <div v-if="es_con_rut" class="contenedor-formulario-label-fiel">
              <div class="formulario-label-fiel">
                {!! Form::label('user_name', 'Razon Social', array('class' =>
                'formulario-label ')) !!} {!! Form::text('user_name', null
                ,['class' => 'formulario-field', 'v-model' =>
                'data_post.razon_social' ]) !!}
              </div>
              <div class="formulario-label-fiel">
                {!! Form::label('user_email', 'Rut', array('class' =>
                'formulario-label ')) !!} {!! Form::number('user_email', null
                ,['class' => 'formulario-field', 'v-model' => 'data_post.rut' ])
                !!}
              </div>
            </div>
          </div>
          <p v-if="cargando" class="Procesando-text">Cargando...</p>
          <div v-else class="contenedor-grupo-datos">
            <div class="contenedor-grupo-datos-titulo">Plan</div>
            <div class="modal-mensaje-aclarador">
              El plan con el cual va a iniciar. Al comienzo se le otorgara 15
              días gratis. Luego si tendra que abonar.
            </div>

            {!! Form::label('user_name', 'Elegir un plan', array('class' =>
            'formulario-label ')) !!}
            <div class="contiene-fase-2-moneda">
              <div class="crear-empresa-contiene-opciones-planes">
                <div v-for="plan in planes" class="contiene-opcione-planes">
                  <input
                    type="radio"
                    :value="plan.id"
                    v-model="data_post.plan_id"
                  />
                  <label class="moneda-label">
                    <span>@{{ plan.name }}</span>
                    <span class="contiene-opcione-planes-aclaracion"
                      >Por mes @{{ plan.moneda }} @{{
                        get_valor_dependiendo_si_es_conIva(plan.valor)
                      }}
                      hasta @{{ plan.cantidad_socios }} socios</span
                    >
                  </label>
                </div>
              </div>
            </div>
          </div>
          <br />

          <div v-if="$root.cargando" class="Procesando-text">Procesado...</div>
          <div v-else v-on:click="crear_empresa_post" class="boton-simple">
            Crear
          </div>
        </div>
        <br />
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>
</span>

`
});
