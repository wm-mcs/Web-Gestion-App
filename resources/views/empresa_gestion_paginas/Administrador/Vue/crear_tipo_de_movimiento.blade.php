Vue.component('crear-tipo-de-movimientos' ,
{

data:function(){
    return {
     
     showModal: false,
     cargando:false,
     data_crear:{
                  name:'',
                  tipo_saldo:'',
                  movimiento_de_empresa_a_socio:'',
                  movimiento_de_la_empresa:'',
                  descripcion_breve:'',
                  estado:'si',
                  se_muestra_en_panel:'si',
                  socio_opcion_de_pago:'no',
                  se_paga:'no',
                }

    }
},
methods:{

  limpiar_data_crear:function()
  {
    this.data_crear = {
                        name:'',
                        tipo_saldo:'',
                        movimiento_de_empresa_a_socio:'',
                        movimiento_de_la_empresa:'',
                        descripcion_breve:'',
                        estado:'si',
                        socio_opcion_de_pago:'no',
                        se_paga:'no',
                      };
  },
  cancelar:function(){
    this.limpiar_data_crear();
    this.showModal = false;

  },
  agregar:function(){

       let url = '/set_un_tipo_de_movimiento';     
       let vue = this; 

       this.cargando = true;         

     axios.post(url,this.data_crear).then(function (response){  
            let data = response.data;              

            if(data.Validacion == true)
            {
               vue.cargando  = false; 
               bus.$emit('se-creo-un-movimiento', 'hola'); 
               vue.showModal = false;
               vue.limpiar_data_crear();
                
               $.notify(response.data.Validacion_mensaje, "success"); 
            }
            else
            {
              vue.cargando = false; 
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){
                
               vue.cargando = false;  
               $.notify(error, "error");      
            
           });

   
  }
 

},
mounted: function () {
	

},

template:`

<span>
<div class="Boton-Fuente-Chica Boton-Primario-Relleno" @click="showModal = true">
  Crear un tipo de movimiento <i class="fas fa-plus"></i>
</div>  

  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>

          
          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Tipo de movimientos</h4>
            <div class="col-12 modal-mensaje-aclarador">
              Crear un tipo de movimiento
            </div>
          </div>

          <div class="modal-body">
            
            <div class="row">
              <div class="col-lg-6 formulario-label-fiel">
               <label class="formulario-label">Nombre</label> 
               <input v-model="data_crear.name" type="text" min="1" class="formulario-field" placeholder="hola">
              </div>

              <div class="col-lg-12 formulario-label-fiel">
               <label class="formulario-label">Breve descripción</label> 
               <input v-model="data_crear.descripcion_breve" type="text"  class="formulario-field" placeholder="Algo que explique">                
              </div>
              
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Interactua con un socio?</label>                                
                <select v-model="data_crear.movimiento_de_empresa_a_socio" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                <div class="formulario-label-aclaracion">
                  ¿Tiene que ver con algo de un socio? Ejemplo: ingresar pago de cuota.
                </div> 
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Movimiento de la propia empresa?</label> 
                              
                <select v-model="data_crear.movimiento_de_la_empresa" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                <div class="formulario-label-aclaracion">
                  Agregar un gasto de tarifas estatales sería un ejemplo.
                </div>  
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Tipo de saldo?</label> 
                <select v-model="data_crear.tipo_saldo" class="formulario-field">
                  <option>deudor</option>
                  <option>acredor</option>
                </select>
                
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Se muestra?</label> 
                <div class="formulario-label-aclaracion">
                  Si se muestra cómo opción en la vista
                </div>
                <select v-model="data_crear.se_muestra_en_panel" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                
              </div>

              

              <div class="col-6 formulario-label-fiel">
                <label class="formulario-label">¿Activo?</label> 
                <select v-model="data_crear.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                
              </div>
              <div v-if="data_crear.movimiento_de_empresa_a_socio == 'si'" class="col-6 formulario-label-fiel">
                <label class="formulario-label">¿Muestra opción de pago al crear movimeinto a socio?</label> 
                <div class="formulario-label-aclaracion">
                  Si fuera un cobro se da por entendido que se paga. Si es agregar un cargo se da por entendido que se paga.
                </div>
                <select v-model="data_crear.socio_opcion_de_pago" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                
              </div>
              <div v-if="data_crear.movimiento_de_empresa_a_socio == 'si'" class="col-6 formulario-label-fiel">
                <label class="formulario-label">¿Se paga?</label> 
                <div class="formulario-label-aclaracion">
                  Es para cuando se ingresa un movimiento desde la cuenta del socio. ejemplo un cobro se da por entendido que se paga.
                </div>
                <select v-model="data_crear.se_paga" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                
              </div>

              

              <div @click="agregar" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Confirmar
              </div>
            </div>
            


          </div>

          <div class="modal-footer">
           
              <button class="modal-default-button" @click="cancelar" >
                Cancelar
              </button>
           
          </div>
        </div>
      </div>
    </div>
  </transition>
</span>


`
}




);