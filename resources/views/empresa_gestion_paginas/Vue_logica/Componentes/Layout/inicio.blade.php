Vue.component('nav-inicio' ,
{

data:function(){
    return {
     modal_nombre:'#modal-inicio-user',
     contraseña:false,
     pass:''

    }
},
methods:{
  
  abrir_modal:function(){
  app.abrirModal(this.modal_nombre);
  },

  probar:function(){
   alert('hola');
  },
  abrir_cambiar_pass:function(){

   

    if(this.contraseña === false){
      this.contraseña = true;
    }
    else
    {
      this.contraseña = false;
    }
  },
  cambiar_pass:function(){
      var url = '/cambiarContraseñaUser';

      var data = {    pass:this.pass,     
                 };  
      var vue = this;           

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               
               
               app.cerrarModal(vue.modal_nombre);
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

  
    <span class="helper_cursor_pointer" v-on:click="abrir_modal"> <i class="fas fa-user"></i> {{Auth::user()->first_name}}


     <div class="modal fade" id="modal-inicio-user" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Menu de  {{Auth::user()->first_name}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                
              </div>
              <div class="modal-body text-center"> 



                <div class="contraseña-titulo simula_link" v-on:click="abrir_cambiar_pass" >
                   Cambiar contraseña 
                  <span v-if="contraseña != true"><i class="fas fa-chevron-down"></i></span>
                  <span v-else> <i class="fas fa-chevron-up"></i></span>
                </div>
                <div v-show="contraseña" class="contenedor-cambiar-contraseña-nav">
                  <div class="flex-row-center get_width_100" >
                    <input type="text" class="form-control get_width_80" name="" placeholder="Esribe la nueva contraseña">
                    <div class="flex-row-center get_width_20 flex-justifice-space-around">
                      <span v-if="pass.length" class="boton-acciones-editar" v-on:click="cambiar_pass">Cambiar</span> 
                    </div>
                  </div>
                  
                  
                 


                </div>


                 <a href="{{route('logout')}}">Salir</a>

                     

                        
                       
              </div>
              
            </div>
          </div>
      </div>



    </span> 
  

'

}




);