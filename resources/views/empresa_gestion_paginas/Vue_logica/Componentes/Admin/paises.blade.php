Vue.component('paises',
{


data:function(){
    return { 
     modal: '#modal-paises',
     datos_a_enviar:{
                      name:'',
                      tipo:'',
                      moneda:'',
                      valor:'',
                      cantidad_socios:'',
                      cantidad_sucursales:''
                    },
    planes:[]
      }
},
methods:{

 abrir_modal:function(){

   $(this.modal).appendTo("body").modal('show');  
   this.getPlanes();

 },
 crear_plan:function(){

      var url  = '/crear_plan';

      var data = this.datos_a_enviar; 
      var vue  = this;

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {

               vue.planes = data.planes;
               $.notify(response.data.Validacion_mensaje, "success");
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
 
},
editarServicio:function(plan){
      var url  = '/editar_plan_empresa';

      var data = {plan:plan};
      var vue  = this;

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {

               vue.planes = data.planes;
               $.notify(response.data.Validacion_mensaje, "success");
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
},
getPlanes:function(){
      var url  = '/get_planes_empresa';
      var vue  = this;

     axios.get(url).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.planes = data.planes;
               $.notify(response.data.Validacion_mensaje, "success");
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
}

},
template:'

<span >
   <div  class="simula_link columna-lista-texto" v-on:click="abrir_modal">
         Planes       
   </div>

         <div class="modal fade" id="modal-paises" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
         <div class=""> 
          <h4 class="modal-title" id="myModalLabel">Planes a empresas</h4>
          <div class="modal-mensaje-aclarador">
                Los paises donde vamos a vender Easysocio
          </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center">  


          <div v-if="planes.length">
            <div v-for="plan in planes" class="empresa-gestion-listado-contenedor flex-justifice-space-between" >
              <div class="get_width_80">

                <div class="formulario-label-fiel">                   
                 <input type="text" class="formulario-field"  v-model="plan.name" placeholder="Nombre"  />
                </div> 
                 <div class="contiene-fase-2-moneda">
                  <div class="flex-row-center flex-justifice-space-around get_width_40">
                    <div class="contiene-opcion-moneda">
                      <input type="radio" value="principal" v-model="plan.tipo">
                      <label class="moneda-label" for="principal">Principal</label>
                    </div>
                    
                    <div class="contiene-opcion-moneda">
                      <input type="radio" value="mejora" v-model="plan.tipo">
                      <label class="moneda-label" for="mejora">Mejora</label>
                    </div>
                  </div>
                 </div>
                  <div class="contiene-fase-2-moneda">
                  <div class="flex-row-center flex-justifice-space-around get_width_40">
                    <div class="contiene-opcion-moneda">
                      <input type="radio" value="$" v-model="plan.moneda">
                      <label class="moneda-label" for="$">Pesos</label>
                    </div>
                    
                    <div class="contiene-opcion-moneda">
                      <input type="radio" value="U$S" v-model="plan.moneda">
                      <label class="moneda-label" for="U$S">Dolares</label>
                    </div>
                  </div>
                 </div>
                 <div class="formulario-label-fiel">                   
                 <input type="number" class="formulario-field"  v-model="plan.valor" placeholder="Valor"  />
                </div>
                <div class="formulario-label-fiel">                   
                 <input type="number" class="formulario-field"  v-model="plan.cantidad_socios" placeholder="Cantidad de socios"  />
                </div> 
                 <div class="formulario-label-fiel">                   
                 <input type="number" class="formulario-field"  v-model="plan.cantidad_sucursales" placeholder="Cantidad de sucursales"  />
                </div>






                
              </div>


              <div class="get_width_20 flex-row-center flex-justifice-space-around">
                      <div v-on:click="editarServicio(plan)" title="Editar esté servicio" class="boton-simple-chico">
                        <i class="fas fa-edit"></i>
                     </div>    
              </div>


            </div>
            
          </div>


          <div class="titulo-dentro-de-form" >
                     Crear nuevo <i class="fas fa-arrow-circle-down"></i>
          </div>

          <div class="formulario-label-fiel">                   
           <input type="text" class="formulario-field"  v-model="datos_a_enviar.name" placeholder="Nombre"  />
          </div> 
           <div class="contiene-fase-2-moneda">
            <div class="flex-row-center flex-justifice-space-around get_width_40">
              <div class="contiene-opcion-moneda">
                <input type="radio" value="principal" v-model="datos_a_enviar.tipo">
                <label class="moneda-label" for="principal">Principal</label>
              </div>
              
              <div class="contiene-opcion-moneda">
                <input type="radio" value="mejora" v-model="datos_a_enviar.tipo">
                <label class="moneda-label" for="mejora">Mejora</label>
              </div>
            </div>
           </div>
            <div class="contiene-fase-2-moneda">
            <div class="flex-row-center flex-justifice-space-around get_width_40">
              <div class="contiene-opcion-moneda">
                <input type="radio" value="$" v-model="datos_a_enviar.moneda">
                <label class="moneda-label" for="$">Pesos</label>
              </div>
              
              <div class="contiene-opcion-moneda">
                <input type="radio" value="U$S" v-model="datos_a_enviar.moneda">
                <label class="moneda-label" for="U$S">Dolares</label>
              </div>
            </div>
           </div>
           <div class="formulario-label-fiel">                   
                 <input type="number" class="formulario-field"  v-model="datos_a_enviar.valor" placeholder="Valor"  />
                </div>
          <div class="formulario-label-fiel">                   
           <input type="number" class="formulario-field"  v-model="datos_a_enviar.cantidad_socios" placeholder="Cantidad de socios"  />
          </div> 
           <div class="formulario-label-fiel">                   
           <input type="number" class="formulario-field"  v-model="datos_a_enviar.cantidad_sucursales" placeholder="Cantidad de sucursales"  />
          </div>
               

          <div  v-on:click="crear_plan" class="boton-simple">Crear</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>













</span> 

 

'

}

);