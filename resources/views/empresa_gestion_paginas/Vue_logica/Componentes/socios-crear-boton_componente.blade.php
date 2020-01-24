Vue.component('socios-crear-boton' ,
{
props: {   
    accion_name: String,
    empresa:Object
    
}


,
data:function(){
    return {
      form_socio_name:'',
      form_socio_email:'',
      form_socio_celular:'',
      form_socio_cedula:'' ,
      modal:'#modal-crear-socio'
      
    }
},

methods:{

 abrir_modal:function(){

   $(this.modal).appendTo("body").modal('show');  

 },
 crear_socio_post:function(){

       var url = '/post_crear_socio_desde_modal';

      var data = {    name:this.form_socio_name,
                     email:this.form_socio_email, 
                   celular:this.form_socio_celular,
                    cedula:this.form_socio_cedula,
                    empresa_id: this.empresa.id       
                 };  
      var vue = this;
      app.cargando = true;           

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               app.cargando = false;
               bus.$emit('socios-set', response.data.Socios); 
               app.cerrarModal(vue.modal);
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
 


},
computed:{
 boton_crear_validation:function(){
 if(this.form_socio_name != ''  & this.form_socio_celular != ''  ){
  return true;
 }
 else{
 return false;
}

 }
  
},
template:'<span >
   <div id="socio-boton-crear" style="position:relative;" class="admin-user-boton-Crear" v-on:click="abrir_modal">
         <i class="fas fa-user-plus" title="Crear nuevo socio"></i>





       
  </div>

         <div class="modal fade" id="modal-crear-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">@{{accion_name}} nuevo socio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                  <div class="formulario-label-fiel">
                      <label class="formulario-label" for="Nombre">Nombres  </label>
                      <input type="text" class="formulario-field"  v-model="form_socio_name" placeholder="Nombre" required  />
                  </div>                  
                  <div class="formulario-label-fiel">
                      <label class="formulario-label" for="Nombre">Celular</label>
                      <input type="text" class="formulario-field"  v-model="form_socio_celular" placeholder="Celular" required  />
                  </div> 
               
                  <div v-if="$root.cargando" class="Procesando-text">Procesado...</div>
                  <div v-else v-on:click="crear_socio_post" class="boton-simple">Crear socio</div>
                 
                 
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