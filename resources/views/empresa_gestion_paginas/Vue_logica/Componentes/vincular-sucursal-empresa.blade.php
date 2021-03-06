Vue.component('vincular-sucursal-empresa',
{
props:['empresa'],

data:function(){
    return { 

       sucursal_id:'',
       sucursal_name:'',
       sucursal_direccion:'',
       sucursal_telefono:'',
       sucursal_borrado:'',

       url_crear:'crear_sucursal',
       url_editar:'editar_sucursal',
       id_modal: 'modal-sucursal',
       palabra_crear:'crear',
       si_no:['si','no']

      }
},
mounted: function mounted () {        

    
     


},
computed: {
sucursal_id_condition:function(){
  if(this.sucursal_id === '')
  {
  return false;
  }
  else{
  return true;
  }
}
},
methods:{

perparar_modal:function(sucursal){
  if(sucursal == 'crear'){
        this.sucursal_id = '';
        this.sucursal_name = '';
        this.sucursal_direccion = '';
        this.sucursal_telefono = '';
        this.sucursal_borrado  = ''

  }
  else
  {
        this.sucursal_id = sucursal.id;
        this.sucursal_name = sucursal.name;
        this.sucursal_direccion = sucursal.direccion;
        this.sucursal_telefono = sucursal.telefono;
        this.sucursal_borrado  = sucursal.borrado
  }
},
abrirModalon:function(id,sucursal){

  this.perparar_modal(sucursal);

  $('#'+id).appendTo('body').modal('show'); 
}, 
crear_editar_sucursal:function(url_enviada){
  
       var validation = confirm("¿Seguro quieres hacer estó?");

       if(!validation)
       {
        return '';
       }

   var url  = "/" + url_enviada ;

   var data = {   empresa_id:this.empresa.id,
                          id:this.sucursal_id,
                        name:this.sucursal_name,
                   direccion:this.sucursal_direccion,
                   telefono:this.sucursal_telefono,
                    borrado:this.sucursal_telefono};
   var vue  = this;


    axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
             
              
              app.empresa = data.empresa;
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





   <div      v-on:click="abrirModalon(id_modal,palabra_crear)" class="admin-user-boton-Crear">
        
        Crear sucursal a emrpesa <i class="fas fa-building"></i>
   </div>

   <div v-if="empresa.sucursuales_empresa.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Sucursales</div>
      <div v-for="sucursale in empresa.sucursuales_empresa" :key="sucursale.id" class="component-user-list-contenedor">
        <span>@{{sucursale.name}}</span> 
        <span class="simula_link" title="Editar a está sucursal" v-on:click="abrirModalon(id_modal,sucursale)" > 
          <i class="fas fa-edit"></i>
        </span>
      </div>
   </div>
   <div v-else>
     No tiene ninguna sucursal     
   </div>


  

         <div class="modal fade" id="modal-sucursal" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Crear sucursal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 


                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombre</label>
                      <input type="text" class="form-control"  v-model="sucursal_name" placeholder="Nombre" required  />
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Dirección</label>
                      <input type="text" class="form-control"  v-model="sucursal_direccion" placeholder="Dirección" required  />
                  </div> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Teléfono</label>
                      <input type="text" class="form-control"  v-model="sucursal_telefono" placeholder="Teléfono" required  />
                  </div>

                  <div v-if="sucursal_id_condition" class="form-group">
                      <label class="formulario-label" for="Nombre">¿Está borrado?  </label>
                      <v-select label="name_para_select" :options="si_no" v-model="sucursal_borrado"></v-select>
                  </div> 
                 
               

                  <div v-if="!sucursal_id_condition" v-on:click="crear_editar_sucursal(url_crear)" class="boton-simple">Crear</div>
                  <div v-else v-on:click="crear_editar_sucursal(url_editar)" class="boton-simple">@{{$root.boton_aceptar_texto}}</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">@{{$root.boton_cancelar_texto}}</button>        
        </div>
      </div>
    </div>
  </div>














</span>',

});