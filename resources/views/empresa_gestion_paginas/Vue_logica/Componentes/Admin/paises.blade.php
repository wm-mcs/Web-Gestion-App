Vue.component('paises',
{


data:function(){
    return { 
     modal: '#modal-paises',
     datos_a_enviar:{
                      name:'',
                      code:'',
                      currencyCode:'',
                      estado:'si',
                      imagen:''
                    },
    paises:[],

    }
},
methods:{

 abrir_modal:function(){

   $(this.modal).appendTo("body").modal('show');  
   this.getPaises();

 },
 onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
          return;
      this.createImage(files[0]);
},
createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
          vm.datos_a_enviar.imagen = e.target.result;
      };
      reader.readAsDataURL(file);
},
 crear_plan:function(){

      var url  = '/crear_pais';

      var data = this.datos_a_enviar; 
      

      
      

      var vue  = this;

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {

               vue.paises = data.Paises;
               $.notify(response.data.Validacion_mensaje, "success");
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
 
},
editarPais:function(pais){
      var url  = '/editar_pais';

      var data = {pais:pais,
                imagen:this.datos_a_enviar.imagen};
      var vue  = this;

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {

               vue.paises = data.Paises;
               $.notify(response.data.Validacion_mensaje, "success");
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
},
getPaises:function(){
      var url  = '/get_paises';
      var vue  = this;

     axios.get(url).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.paises = data.Paises;
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
         Países       
   </div>

         <div class="modal fade" id="modal-paises" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
         <div class=""> 
          <h4 class="modal-title" id="myModalLabel">Países</h4>
          <div class="modal-mensaje-aclarador">
                Los países donde vamos a vender Easysocio
          </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center">  


          <div v-if="paises.length">
            <div v-for="pais in paises" class="empresa-gestion-listado-contenedor flex-justifice-space-between" >
              <div class="get_width_80">

                <div class="formulario-label-fiel">                   
                 <input type="text" class="formulario-field"  v-model="pais.name" placeholder="Nombre del país"  />
                </div> 
                 <div class="formulario-label-fiel">                   
                 <input type="text" class="formulario-field"  v-model="pais.code" placeholder="Código del país"  />
                </div>
                <div class="formulario-label-fiel">                   
                 <input type="text" class="formulario-field"  v-model="pais.currencyCode" placeholder="Código de la moneda"  />
                </div>
                <div class="formulario-label-fiel">                   
                 <input type="file" name="image" v-on:change="onImageChange" accept="image/*">
                </div>
                 <div class="contiene-fase-2-moneda">
                 <div class="formulario-label-fiel"> 
                  <img :src="pais.url_img"  >
                 </div>
                 </div>
                 
                






                
              </div>


              <div class="get_width_20 flex-row-center flex-justifice-space-around">
                      <div v-on:click="editarPais(pais)" title="Editar esté país" class="boton-simple-chico">
                        <i class="fas fa-edit"></i>
                     </div>    
              </div>


            </div>
            
          </div>


          <div class="titulo-dentro-de-form" >
                     Crear nuevo <i class="fas fa-arrow-circle-down"></i>
          </div>

          <div class="formulario-label-fiel">                   
           <input type="text" class="formulario-field"  v-model="datos_a_enviar.name" placeholder="Nombre del país"  />
          </div> 
          <div class="formulario-label-fiel">                   
           <input type="text" class="formulario-field"  v-model="datos_a_enviar.code" placeholder="Código del país"  />
          </div>
          <div class="formulario-label-fiel">                   
           <input type="text" class="formulario-field"  v-model="datos_a_enviar.currencyCode" placeholder="Código del moneda"  />
          </div>
          <div class="formulario-label-fiel">                   
           <input type="file" name="image" v-on:change="onImageChange" accept="image/*">
          </div>
          
           
            <div class="contiene-fase-2-moneda">
            <div class="flex-row-center flex-justifice-space-around get_width_40">
              <div class="contiene-opcion-moneda">
                <input type="radio" value="si" v-model="datos_a_enviar.estado">
                <label class="moneda-label" >Activo</label>
              </div>
              
              <div class="contiene-opcion-moneda">
                <input type="radio" value="no" v-model="datos_a_enviar.estado">
                <label class="moneda-label">Inactivo</label>
              </div>
            </div>
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