@include('empresa_gestion_paginas.Vue_logica.Componentes.tipoServicioEmpresa.cantidadDeDiasArray')
@include('empresa_gestion_paginas.Vue_logica.Componentes.tipoServicioEmpresa.tipoServicioLista')


Vue.component('tipo-de-servicios-modal',
{

components: {
   'tipo-servicio-lista': tipoServicioLista

},

props:['empresa'],

data:function(){
    return {
        crear_service_name:'',
        crear_service_tipo:'',
        valor:'',
        moneda:'$',
        cantidad_clases:0,
        renovacion_cantidad_en_dias:30,
        showModal:false,
        array_cantidad_de_dias:cantidadDeDiasArray
      }
},
mounted: function mounted () {





},
computed: {
 listaDeServicios:function(){
    return this.empresa.tipo_servicios.sort();
 },
 tipo_clase:function(){
   if(this.crear_service_tipo == 'clase')
   {
    return true;
   }
   else
   {
    return false
   }
 }

},
methods:{
     valores_a_cero:function(){
      this.crear_service_name = '';
      this.crear_service_tipo = '';
      this.moneda = '$';
      this.valor = '';
      this.cantidad_clases = 0;
      this.renovacion_cantidad_en_dias = 30;
     },



     agregarServicioCreat:function(){

       var url = '/set_nuevo_servicio';

       var vue = this;

       var data = {    name:this.crear_service_name,
                       tipo:this.crear_service_tipo ,
                 empresa_id:this.empresa.id,
                     moneda:this.moneda,
                      valor:this.valor,
            cantidad_clases:this.cantidad_clases,
            renovacion_cantidad_en_dias:this.renovacion_cantidad_en_dias
                   };

      app.cargando = true;

              axios.post(url,data).then(function (response){



              if(response.data.Validacion == true)
              {
                  app.cargando = false;
                  app.empresa = response.data.empresa;
                  $.notify(response.data.Validacion_mensaje, "success");
                  vue.valores_a_cero();
              }
              else
              {
                  app.cargando = false;
                  $.notify(response.data.Validacion_mensaje, "error");
              }

             }).catch(function (error){



             });

     },
     deletServicio:function(servicio)
     {

        var result = confirm("¿Seguro qué quieres hacer esto?");

        if(result){

        var url = '/delet_servicio';

        var vue = this;

        var data = {   id:servicio.id,
               empresa_id:this.empresa.id

                   };

        app.cargando = true;

              axios.post(url,data).then(function (response){



              if(response.data.Validacion == true)
              {
                  app.cargando = false;
                  vue.empresa = response.data.empresa;
                  $.notify(response.data.Validacion_mensaje, "success");
              }
              else
              {
                  app.cargando = false;
                  $.notify(response.data.Validacion_mensaje, "error");
              }

             }).catch(function (error){



             });
        }
     }




},
template:`
<span>
 <button type="button"   class="admin-user-boton-Crear"  v-on:click="showModal = !showModal" title="Listado de servicios">
        <i class="far fa-list-alt"></i>
 </button>
 <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Servicios</h4>
            <div class="col-12 modal-mensaje-aclarador">
              Existen dos tipos de servicios mensual y por clase.
              <b>Mensula</b>  significa que no se controla la cantidad de veces que el socio asiste. Ejemplo de mensual sería un pase libre.
              <b>Clase</b>  sería para el caso de una cuponera. Cada vez que el socio toma una clase se descontará de la cuponera.
              En ambos caso tiene vencimientos y estos podrán ser editados.
            </div>
          </div>

          <div class="modal-body">

             <div class="row mb-5" v-if="empresa.tipo_servicios.length > 0">

                  <tipo-servicio-lista  v-for="servicio in empresa.tipo_servicios"
                                         :key="servicio.id"
                                         :servicio_prop="servicio">
                  </tipo-servicio-lista>

             </div>
             <div v-else class="row">
               <div class="col-12  sub-titulos-class text-center color-text-gris">
                  Aún no hay servicios creados ¡Crea uno ahora!
               </div>
             </div>


            <div class="row">
                <div class="col-12 titulos-class text-center" >
                    Crear nuevo <i class="fas fa-arrow-circle-down"></i>
                </div>
                <div class="col-12 col-lg-6 formulario-label-fiel">
                    <label class="formulario-label" for="Nombre">Nombre del servicio  </label>
                    <input type="text" class="formulario-field"  v-model="crear_service_name" placeholder="Nombre del servicio" required  />
                </div>
                <div class="col-12 col-lg-6 formulario-label-fiel">
                  <label class="formulario-label" for="Nombre">Tipo <span class="formulario-label-aclaracion">¿Por clase o mensual?</span></label>
                  <select v-model="crear_service_tipo" class="formulario-field">
                    <option>clase</option>
                    <option>mensual</option>
                  </select>
                </div>
                <div v-if="tipo_clase" class="col-12 col-lg-4 formulario-label-fiel">
                  <label class="formulario-label">Cantidad de clases</label>
                  <input type="number" class="formulario-field" v-model="cantidad_clases" step="any">
                </div>
                <div class="col-12 col-lg-4 formulario-label-fiel">
                  <label class="formulario-label">¿Cuánto cuesta?</label>
                  <input type="text" class="formulario-field" v-model="valor" step="any">
                </div>
                <div v-if="$root.aceptaDolares" class="col-12 col-lg-4 formulario-label-fiel">
                  <label class="formulario-label">¿Pesos o Dolares?</label>
                  <select v-model="moneda" class="formulario-field">
                    <option>$</option>
                    <option>U$S</option>
                  </select>
                </div>
                <div class="col-12 col-lg-4 formulario-label-fiel">
                  <label class="formulario-label">Se vence en</label>
                  <select v-model="renovacion_cantidad_en_dias" class="formulario-field">
                    <option v-for="cantidad_dias in array_cantidad_de_dias" :value="cantidad_dias.cantidad_de_dias_numero">
                      @{{cantidad_dias.cantidad_de_dias_texto}}
                    </option>
                  </select>
                </div>

                <div class="col-12 d-flex flex-column align-items-center">
                  <div v-if="$root.cargando" class="Procesando-text">
                    <div class="cssload-container">
                      <div class="cssload-tube-tunnel"></div>
                    </div>
                  </div>
                  <div v-else v-on:click="agregarServicioCreat" title="Editar este servicio" class="w-100  mt-4 Boton-Primario-Relleno Boton-Fuente-Grande">
                      @{{$root.boton_aceptar_texto}}
                  </div>
                </div>

            </div>
          </div>

          <div class="modal-footer">
            <button class="modal-default-button"   @click="showModal = !showModal">
              @{{$root.boton_cancelar_texto}}
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>





















</span>`,

});
