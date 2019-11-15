
Vue.component('tipo-de-servicios-empresa',
{


data:function(){
    return { 
     modal: '#modal-crear-tipo-servicio-empresa';

      }
},
methods:{

 abrir_modal:function(){

   $(this.modal).appendTo("body").modal('show');  

 },
 crear_empresa_post:function(){
 alert('hola');
}
},
template:'

<span >
   <div  class="simula_link" v-on:click="abrir_modal">
         Planes       
   </div>

         <div class="modal fade" id="modal-crear-tipo-servicio-empresa" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
         <div class=""> 
          <h4 class="modal-title" id="myModalLabel">Crear nueva empresa</h4>
          <div class="modal-mensaje-aclarador">
                Aquí tu como vendedor, vas a crear una empresa y el usuario para que la persona pueda comenzar a operar. Por defecto ya quedarás asociado como vendeor, el usuario será asociado como dueño y se creará una Sucursal como principal. Se le enviará un email al usuario con los datos para ingresar.


           </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

        
               

                  <div  v-on:click="crear_empresa_post" class="boton-simple">Crear</div>
                  
                 
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

});