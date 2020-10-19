@include('empresa_gestion_paginas.Vue_logica.Componentes.tipo_servicio_empresa.tipoServicioLista')


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
        showModal:false
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

        var result = confirm("¿Seguro que quieres hacer esto?");

        if(result){            
        
        var url = '/delet_servicio';

        var vue = this;

        var data = {   id:servicio.id,
               empresa_id:this.empresa.id
                       
                   }; 

        app.cargando = true;

              axios.post(url,data).then(function (response){  
              
              

              if(response.data.Validacion == true)
              {  app.cargando = false;
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
 <div   class="admin-user-boton-Crear"  v-on:click="showModal = !showModal" title="Listado de servicios">
        <i class="far fa-list-alt"></i>         
 </div>
 <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <h4 class="modal-title" > Servicios</h4>
            <div class="modal-mensaje-aclarador">
              Existen dos tipos de servicios: periódicos (mensual, semestral y anual) y por clase (cuponeras)
            </div>
          </div>

          <div class="modal-body">            
            <div class="row mb-5">
             <div v-if="empresa.tipo_servicios.length > 0">
               <div  class="empresa-gestion-listado-contenedor flex-justifice-space-between border-bottom-claro">
                  <tipo-servicio-lista  v-for="servicio in empresa.tipo_servicios" 
                                        :key="servicio.id"
                                        :servicio_prop="servicio">                    
                  </tipo-servicio-lista>
               </div>
             </div>
             <div v-else class="col-12 sub-titulos-class text-center color-text-gris">
               Aún no hay servicios creados ¡Crea uno ahora!
             </div>                
            </div>

            <div>
                <div class="titulo-dentro-de-form" >
                     Crear nuevo <i class="fas fa-arrow-circle-down"></i>
                  </div>

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombre del servicio  </label>
                      <input type="text" class="form-control"  v-model="crear_service_name" placeholder="Nombre del servicio" required  />
                  </div> 
                 

                 <div class="form-group">
                      <label class="formulario-label" for="Nombre">Tipo <span class="formulario-label-aclaracion">¿por clase o mensual?</span></label>
                     <select v-model="crear_service_tipo" class="form-control">
                        
                        <option>clase</option>
                        <option>mensual</option>
                        
                      </select>
                  </div>   
                  <div v-if="tipo_clase" class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">Cantidad de clases</label>
                   <input type="number" class="form-control" v-model="cantidad_clases" step="any">
                 </div>

                  <div class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">¿Cuánto cuesta?</label>
                   <input type="text" class="form-control" v-model="valor" step="any">
                 </div>
                 <div class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">¿Pesos o Dolares?</label>
                   <select v-model="moneda" class="form-control">
                        
                        <option>$</option>
                        <option>U$S</option>
                        
                    </select>
                 </div>



               
                  
                  <div v-if="$root.cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  </div>
                  <div v-else v-on:click="agregarServicioCreat" class="boton-simple">@{{$root.boton_aceptar_texto}}</div>
            </div>

             

            
           
            


          </div>

          <div class="modal-footer">
           
              <button class="modal-default-button"  @click="showModal = false">
                @{{$root.boton_cancelar_texto}}
              </button>
           
          </div>
        </div>
      </div>
    </div>
  </transition>



















 

</span>`,

});