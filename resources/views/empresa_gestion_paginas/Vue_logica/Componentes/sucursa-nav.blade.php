Vue.component('sucursal-nav' ,
{
props:[ 'empresa','sucursal' ],
data:function(){
    return {
     

    }
},
methods:{
  abrirModal:function(id){

    var id_modal = '#'+id;
    app.abrirModal(id_modal);

  }
    

},
template:'
  <div class="contiene-sucursal" v-on:click="abrirModal('modal-cambiar-sucursal')">
    <span class="sucursal-estas">Estás en la sucursal</span> 
    <span class="sucursal-nombre">@{{sucursal.name}} <i class="fas fa-chevron-down"></i></span> 


   <div class="modal fade" id="modal-cambiar-sucursal" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Cambiar de sucursal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                 
               

                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>


  </div>'

}




);