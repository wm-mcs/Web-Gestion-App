Vue.component('socios-crear-boton' ,
{
props: {   
    accion_name: String
    
}


,
data:function(){
    return {
      form_socio_name:'',
      form_socio_email:'',
      form_socio_celular:'',
      form_socio_cedula:'' ,
      empresa_id: {{$Empresa_gestion->id}},
    }
},

methods:{

 abrir_modal:function(){

   $('#modal-crear-socio').appendTo("body").modal('show');  

 },
 crear_socio_post:function(){

       var url = '/post_crear_socio_desde_modal';

      var data = {    name:this.form_socio_name,
                     email:this.form_socio_email, 
                   celular:this.form_socio_celular,
                    cedula:this.form_socio_cedula        
                 }; 

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              
            }
            else
            {
              
            }
           
           }).catch(function (error){

                     
            
           });

 }
 


},
computed:{
 boton_crear_validation:function(){
 if(this.form_socio_name != '' & this.form_socio_email != '' & this.form_socio_celular != '' && this.form_socio_cedula != ''  ){
  return true;
 }
 else{
 return false;
}

 }
  
},
template:'<span >
   <div id="socio-boton-crear" style="position:relative;" class="admin-user-boton-Crear" v-on:click="abrir_modal">
        @{{ accion_name }} socio <i class="fas fa-user-plus"></i>





       
  </div>

         <div class="modal fade" id="modal-crear-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">@{{accion_name}} nuevo socio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombres  </label>
                      <input type="text" class="form-control"  v-model="form_socio_name" placeholder="Nombre" required  />
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Cedula  <span class="formulario-label-aclaracion"> (sin puntos ni guiones)</span> </label>
                      <input type="text" class="form-control"  v-model="form_socio_cedula" placeholder="Cedula" required  />
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Email</label>
                      <input type="text" class="form-control"  v-model="form_socio_email" placeholder="Email" required  />
                  </div> 
                   <div class="form-group">
                      <label class="formulario-label" for="Nombre">Celular</label>
                      <input type="text" class="form-control"  v-model="form_socio_celular" placeholder="Celular" required  />
                  </div> 
               

                  <div v-if="boton_crear_validation" v-on:click="crear_socio_post" class="boton-simple">Crear</div>
                  <div v-else class="recuadro-validacion-pendiente">Debes completar todos los campos para crear</div>
                 
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