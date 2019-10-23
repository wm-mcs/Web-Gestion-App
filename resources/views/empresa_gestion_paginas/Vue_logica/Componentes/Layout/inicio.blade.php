Vue.component('nav-inicio' ,
{

data:function(){
    return {
     modal_nombre:'#modal-inicio-user',
     contraseña:false

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



                <div class="contraseña-titulo" v-on:click="abrir_cambiar_pass" >
                   Cambiar contraseña 
                  <span v-if="contraseña != true"><i class="fas fa-chevron-down"></i></span>
                  <span v-else> <i class="fas fa-chevron-up"></i></span>
                </div>
                <div v-show="contraseña" class="contenedor-cambiar-contraseña-nav">
                  <div>
                    <input type="text" class="form-control get_width_80" name="" placeholder="Esribe la nueva contraseña">
                    <div>
                      Cambiar
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