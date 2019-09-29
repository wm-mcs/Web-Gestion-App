Vue.component('vincular-user-empresa',
{
props:['empresa'],

data:function(){
    return { 
      
      users:[],
      user_seleccionado: false,
      sucursal_seleccionada:false,
      usuarios_de_empresa: {!! json_encode($UsersEmpresa) !!},
      vendedores_de_empresa: {!! json_encode($VendedorEmpresa) !!},
      url_delete_vendedores: 'delete_vendedor_a_empresa',
      url_delete_usuarios: 'delete_user_a_empresa'

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
                 user_id:this.user_seleccionado.id,
                 sucursal_id:this.sucursal_seleccionada.id};
   var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
                         
              vue.usuarios_de_empresa = data.UsersEmpresa;
              app.cerrarModal('#modal-vincular-usuario');
              $.notify(data.Validacion_mensaje, "success");   

              
            }
            else
            {
              
              app.cerrarModal('#modal-vincular-usuario');
              $.notify(response.data.Validacion_mensaje, "warn");
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
              
              vue.vendedores_de_empresa = data.UsersEmpresa;
              app.cerrarModal('#modal-vincular-usuario');
              $.notify(data.Validacion_mensaje, "success");

              
            }
            else
            { app.cerrarModal('#modal-vincular-usuario');
              $.notify(response.data.Validacion_mensaje, "warn");
            }
           
           }).catch(function (error){

                     
            
           });       

},
desvincular_este_user:function(user,url_enviada){
  
    var validation = confirm("¿Quieres desvincular a esté usuario?");

       if(!validation)
       {
        return '';
       }

   var url  = "/" + url_enviada ;

   var data = {empresa_id:this.empresa.id,
                  user_id:user.id};
   var vue  = this;


    axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              if(url_enviada === 'delete_vendedor_a_empresa')
              {
                vue.vendedores_de_empresa = data.UsersEmpresa;
              }
              else
              {
                vue.usuarios_de_empresa = data.UsersEmpresa;
              }
              
              
              $.notify(data.Validacion_mensaje, "success");

              
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
<span class="get_width_100 flex-row-column">





   <div       class="admin-user-boton-Crear" 
         v-on:click="getUserSegunRole(2)">
        
        Vincular usuario a emrpesa <i class="fas fa-user-plus"></i>
   </div>

   <div v-if="usuarios_de_empresa.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Usuarios</div>
      <div v-for="usuario_empresa in usuarios_de_empresa" :key="usuario_empresa.id" class="component-user-list-contenedor">
        <div class="component-user-list-sub">
            <span class="component-user-list-dato-name">@{{usuario_empresa.user.name}}</span>
            <span class="component-user-list-dato-email">@{{usuario_empresa.user.email}}</span>  
            <span class="component-user-list-dato-role">Role: @{{usuario_empresa.user.gerarqui_con_nombre}}</span>
            <span class="component-user-list-dato-role">Role: @{{usuario_empresa.sucursal_nombre}}</span>

        </div>
           
        <span class="simula_link" title="Desvincular a esté usuario" v-on:click="desvincular_este_user(usuario_empresa,url_delete_usuarios)"> 
          <i class="fas fa-trash-alt"></i> 
        </span>
      </div>
   </div>
   <div v-else>
     No hay usuarios asociados     
   </div>


    <div v-if="vendedores_de_empresa.length" class="empresa-contendor-de-secciones">
    <div class="empresa-titulo-de-secciones">Vendedor</div>
      <div v-for="usuario_empresa in vendedores_de_empresa" :key="usuario_empresa.id" class="component-user-list-contenedor">
        <div class="component-user-list-sub">
            <span class="component-user-list-dato-name">@{{usuario_empresa.user.name}}</span>
            <span class="component-user-list-dato-email">@{{usuario_empresa.user.email}}</span>  
            <span class="component-user-list-dato-role">Role: @{{usuario_empresa.user.gerarqui_con_nombre}}</span>
        </div>
        <span class="simula_link" title="Desvincular a esté usuario" v-on:click="desvincular_este_user(usuario_empresa, url_delete_vendedores)"> 
          <i class="fas fa-trash-alt"></i> 
        </span>
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

                   <div class="form-group" v-if="empresa.sucursuales_empresa.length">
                      <label class="formulario-label" for="Nombre">Sucursal  </label>
                      <v-select label="name" :options="empresa.sucursuales_empresa" v-model="sucursal_seleccionada"></v-select>
                  </div> 
                 
               

                  <div v-if="user_seleccionado" v-on:click="vincular_user_con_empresa" class="boton-simple">Agregar como usuario</div>
                  <div v-if="user_seleccionado" v-on:click="vincular_vendedor_con_empresa" class="boton-simple">Agregar como vendedor</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>














</span>',

});