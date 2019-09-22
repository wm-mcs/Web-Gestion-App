Vue.component('vincular-user-empresa',
{
props:['empresa'],

data:function(){
    return { 
      
      users:[],
      user_seleccionado: '',
      usuarios_de_empresa: {!! json_encode($UsersEmpresa) !!},
      vendedores_de_empresa: {!! json_encode($VendedorEmpresa) !!}

      }
},
mounted: function mounted () {        

    
     


},
computed: {

},
methods:{

abrirModalon:function(id){

  $(id).appendTo('body').modal('show'); 
},
cerrarModal:function(){

  $('#modal-vincular-usuario').modal('hide');
              
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
              
              
              
              this.usuarios_de_empresa = data.UsersEmpresa;
              this.cerrarModal();

              
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
              this.cerrarModal();
            }
           
           }).catch(function (error){

                     
            
           });       
},
vincular_vendedor_con_empresa:function(){

   var url  = "/set_vendedor_a_empresa";

   var data = {empresa_id:this.empresa.id,
                 user_id:this.user_seleccionado.id};
   var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              $.notify(data.Validacion_mensaje, "success");
              this.vendedores_de_empresa = data.UsersEmpresa;
              this.cerrarModal();

              
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
              this.cerrarModal();
            }
           
           }).catch(function (error){

                     
            
           });       

},
desvincular_user:function(url){
  
}
     


         

},
template:'
<span>





   <div       class="admin-user-boton-Crear" 
         v-on:click="getUserSegunRole(2)">
        
        Vincular usuario a emrpesa <i class="fas fa-user-plus"></i>
   </div>

   <div v-if="usuarios_de_empresa.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Usuarios</div>
      <div v-for="usuario_empresa in usuarios_de_empresa" :key="usuario_empresa.id" class="component-user-list-contenedor">
        @{{usuario_empresa.user.name}}
      </div>
   </div>
   <div v-else>
     No hay usuarios asociados     
   </div>
    <div v-if="vendedores_de_empresa.length" class="empresa-contendor-de-secciones">
    <div class="empresa-titulo-de-secciones">Vendedor</div>
      <div v-for="usuario_empresa in vendedores_de_empresa" :key="usuario_empresa.id" class="component-user-list-contenedor">
        <span>@{{usuario_empresa.user.name}}</span> 
        <span class="simula_link" title="Desvincular a esté usuario" v-on:click="desvincular_user()"> <i class="fas fa-trash-alt"></i> </span>
      </div>
   </div>
   <div v-else>
     No hay vendedores asociados     
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
                 
               

                  <div  v-on:click="vincular_user_con_empresa" class="boton-simple">Agregar como usuario</div>
                  <div  v-on:click="vincular_vendedor_con_empresa" class="boton-simple">Agregar como vendedor</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>














</span>',

});