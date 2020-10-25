Vue.component('tipo_de_movimiento_lista' ,
{
props:['tipo_de_movimiento'],
data:function(){
    return {
     
     showModal: false,
     cargando:false,
     data_editar:''

    }
},
methods:{
  editar:function(){
     let url = '/edit_un_tipo_de_movimiento';     
     let vue = this; 

     this.cargando = true;         

     axios.post(url,this.data_editar).then(function (response){  
      let data = response.data;        

      if(data.Validacion == true)
      {
         vue.cargando  = false; 
         bus.$emit('se-creo-un-movimiento', 'hola'); 
         vue.showModal = false;
         
          
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
computed:{
  class_saldo:function(){
    
    return {
            'color-text-success background-success':this.tipo_de_movimiento.tipo_saldo == 'deudor',
            'color-text-error background-error':this.tipo_de_movimiento.tipo_saldo == 'acredor'     
           }
  }
},
mounted: function () {
  
 this.data_editar = this.tipo_de_movimiento;
},

template:'


  <div class="col-6 col-lg-4 p-4 mb-3 border-radius-estandar borde-gris background-white">
    <div class="row">
     <p class="col-10 mb-1 text-color-black ">
      <b>@{{tipo_de_movimiento.name}}</b> 
     </p>
     <p class="col-2 sub-titulos-class text-center simula-link">
      <i  @click="showModal = true" class="far fa-edit"></i>
     </p>
     <p class="col-12 mb-1 " >
       <small class="py-1 px-2" :class="class_saldo">Saldo <b>@{{tipo_de_movimiento.tipo_saldo}}</b></small> 
     </p>
     <p class="col-12 mb-0 color-text-gris" >
       <small>@{{tipo_de_movimiento.descripcion_breve}}</small>
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
            <h4 class="col-12 sub-titulos-class" > Editar @{{tipo_de_movimiento.name}}</h4>
            <div class="col-12 modal-mensaje-aclarador">
              Editar
            </div>
          </div>

          <div class="modal-body">
            
            <div class="row">
              <div class="col-lg-6 formulario-label-fiel">
               <label class="formulario-label">Nombre</label> 
               <input v-model="data_editar.name" type="text" min="1" class="formulario-field" placeholder="hola">
              </div>

              <div class="col-lg-12 formulario-label-fiel">
               <label class="formulario-label">Breve descripción</label> 
               <input v-model="data_editar.descripcion_breve" type="text"  class="formulario-field" placeholder="Algo que explique">                
              </div>
              
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Interactua con un socio?</label> 
                               
                <select v-model="data_editar.movimiento_de_empresa_a_socio" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                <div class="formulario-label-aclaracion">
                  ¿Tiene que ver con algo de un socio? Ejemplo: ingresar pago de cuota.
                </div> 
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Movimiento de la propia empresa?</label> 
                              
                <select v-model="data_editar.movimiento_de_la_empresa" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                <div class="formulario-label-aclaracion">
                  Agregar un gasto de tarifas estatales sería un ejemplo.
                </div>  
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Tipo de saldo?</label> 
                <select v-model="data_editar.tipo_saldo" class="formulario-field">
                  <option>deudor</option>
                  <option>acredor</option>
                </select>
                
              </div>
               <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Se muestra?</label> 
                <div class="formulario-label-aclaracion">
                  Si se muestra cómo opción en la vista
                </div> 
                <select v-model="data_editar.se_muestra_en_panel" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                
              </div>


              <div class="col-6 formulario-label-fiel">
                <label class="formulario-label">¿Activo?</label> 
                <select v-model="data_editar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                
              </div>

              <div @click="editar" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Confirmar
              </div>
            </div>
            


          </div>

          <div class="modal-footer">
           
              <button class="modal-default-button"  @click="showModal = false">
                Cancelar
              </button>
           
          </div>
        </div>
      </div>
    </div>
  </transition>
  </div>  
'
}




);