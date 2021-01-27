var pais = {
    props: ["pais"],
    data: function() {
        return {
            cargando: false,
            showModal: false,
            imagen: ""
        };
    },
    methods: {
        onImageChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = e => {
                vm.imagen = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        editarPais: function(pais) {
            var url = "/editar_pais";

            var data = { pais: this.pais, imagen: this.imagen };
            var vue = this;

            axios
                .post(url, data)
                .then(function(response) {
                    var data = response.data;

                    if (data.Validacion == true) {
                        vue.paises = data.Paises;
                        $.notify(response.data.Validacion_mensaje, "success");
                    } else {
                        $.notify(response.data.Validacion_mensaje, "error");
                    }
                })
                .catch(function(error) {});
        }
    },
    template: `<div class="col-6 col-lg-4 p-1 ">
    <div class="p-3  border-radius-estandar borde-gris background-white h-100">
      <div class="row mx-0 align-items-center">
        <div class="col-3 cursor-pointer" @click="showModal = true">
          <img :src="pais.url_img" :alt="'Bandera de ' + pais.url_img" class="img-fluid rounded-circle">
        </div>
        <p class="col-9 mb-0 text-color-black h5 cursor-pointer" @click="showModal = true">
          <b>@{{pais.name}}</b>
        </p>
        <p :class="pais.estado === 'si' ? 'color-text-success' : 'color-text-gris'"> @{{ pais.estado === 'si' ? 'Activo':'Desactivado')}}  </p>
  
      </div>
  
      <transition name="modal" v-if="showModal">
        <div class="modal-mask ">
          <div class="modal-wrapper">
            <div class="modal-container position-relative">
              <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris"
                @click="showModal = !showModal">
                <i class="fas fa-times"></i>
              </span>
  
  
              <div class="row">
                <h4 class="col-12 sub-titulos-class"> Editar @{{pais.name}}</h4>
                <div class="col-12 modal-mensaje-aclarador">
                  Editar los datos correspondientes al país <b>@{{pais.name}}</b>. 
                </div>
              </div>
  
              <div class="modal-body">
  
                <div class="row">
                
                    <div class=" col-lg-6 formulario-label-fiel">
                      <img :src="pais.url_img" class="img-fluid">
                    </div>
                  
  
  
                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Nombre </label>
                    <input type="text" class="formulario-field" v-model="pais.name" placeholder="Nombre del país" />
                  </div>
                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Código</label>
                    <input type="text" class="formulario-field" v-model="pais.code" placeholder="Código del país" />
                  </div>
                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Código de moneda</label>
                    <input type="text" class="formulario-field" v-model="pais.currencyCode"
                      placeholder="Código de la moneda" />
                  </div>
                  <div class="col-12 formulario-label-fiel">
                    <label class="formulario-label">Imagen</label>
                    <input class="formulario-field" type="file" name="image" v-on:change="onImageChange" accept="image/*">
                  </div>

                  <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Activo?</label> 
                    <select v-model="pais.estado" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>                        
                   </div>
                  
  
                  <div @click="editarPais" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                    Confirmar
                  </div>
                </div>
  
  
  
              </div>
  
              <div class="modal-footer">
  
                <button class="modal-default-button" @click="showModal = false">
                  Cancelar
                </button>
  
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>`
};