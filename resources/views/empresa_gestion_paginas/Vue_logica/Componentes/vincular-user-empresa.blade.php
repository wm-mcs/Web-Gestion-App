Vue.component('vincular-user-empresa',
{
props:['empresa'],

data:function(){
    return { 
      
      users:[],
      user_seleccionado: '',
      usuarios_de_empresa: {!! json_encode($UsersEmpresa) !!}

      }
},
mounted: function mounted () {        

    
     


},
computed: {

},
methods:{

abrirModalon:function(id){
  $(id).appendTo("body").modal('show'); 
},
    
getUserSegunRole:function(role){


  


  this.abrirModalon('#modal-vincular-usuario');



  var url  = "/get_user_rol_panel_gestion";

  var data = {empresa_id:this.empresa.id,
                    role:role};
   var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              $.notify(data.Validacion_mensaje, "success");
              
              
              
              vue.users = data.Usuarios;

              
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
            }
           
           }).catch(function (error){

                     
            
           });                  
},
vincular_user_con_empresa:function(){
  

  var url  = "/set_user_a_empresa";

  var data = {empresa_id:this.empresa.id,
                 user_id:this.user_seleccionado.id};
   var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              $.notify(data.Validacion_mensaje, "success");
              
              
              
              app.empresa = data.empresa;

              
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
            }
           
           }).catch(function (error){

                     
            
           });       
}
     


         

},
template:'
<span>





   <div       class="admin-user-boton-Crear" 
         v-on:click="getUserSegunRole(2)">
        
        Vincular usuario a emrpesa <i class="fas fa-user-plus"></i>
   </div>

   <div v-if="empresa.usuarios_de_empresa.length">
      <div v-for="usuario_empresa in usuarios_de_empresa" :key="usuario_empresa.id" >
        @{{usuario_empresa.id}}
      </div>
   </div>
   <div v-else>
     No hay usuarios asociados     
   </div>

         <div class="modal fade" id="modal-vincular-usuario" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Vincular usuario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Usuario  </label>
                      <v-select label="name_para_select" :options="users" v-model="user_seleccionado"></v-select>
                  </div> 
                 
               

                  <div  v-on:click="vincular_user_con_empresa" class="boton-simple">Agregar</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>














</span>',

});