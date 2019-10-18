Vue.component('sucursal-nav' ,
{
props:[ 'empresa','sucursal' ],
data:function(){
    return {
     
      modal_cambiar_sucursal:'modal-cambiar-sucursal'
    }
},
methods:{
  abrirModal:function(id){


    if(this.SucursalesMenosLaQueEsta.length)
    {
      var id_modal = '#'+id;
      app.abrirModal(id_modal);
    }
    else
    {
      $.notify('Es la única sucursal', "info");
    }
    

  },
  cambiar_a_esta_sucursal:function(sucursal){
      

      var url  = '/cambiar_de_sucursal';

      var data = {  
                  sucursal_id: sucursal.id,
                   empresa_id: this.empresa.id       
                 };  
      var vue  = this;

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {

               bus.$emit('sucursal-set', response.data.Sucursal); 
               app.Sucursal = data.Sucursal; 
               app.cerrarModal('#'+ vue.modal_cambiar_sucursal );
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
computed:{

SucursalesMenosLaQueEsta:function(){
  return this.empresa.sucursuales_empresa.filter(Sucursal => Sucursal.id != this.sucursal.id);

}
  
},
template:'
  <div class="contiene-sucursal" v-on:click="abrirModal(modal_cambiar_sucursal)">
    <span class="sucursal-estas">Estás en la sucursal</span> 
    <span class="sucursal-nombre">@{{sucursal.name}} <i v-if="SucursalesMenosLaQueEsta.length" class="fas fa-chevron-down"></i></span> 


   <div class="modal fade" id="modal-cambiar-sucursal" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Cambiar de sucursal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

            <div>
              <div class="empresa-lista-user-sucursal" v-for="SucursalDeEmpresa in SucursalesMenosLaQueEsta" v-on:click="cambiar_a_esta_sucursal(SucursalDeEmpresa)">
                <div class="empresa-lista-user-sucursal-entrar">Entrar a sucursal</div>
                <span  class="simula_link empresa-lista-user-sucursal-nombre disparar-este-form" >@{{SucursalDeEmpresa.name}}</span>    
              </div>


            </div>     
               

                  
                 
        </div>
        
      </div>
    </div>
  </div>


  </div>'

}




);