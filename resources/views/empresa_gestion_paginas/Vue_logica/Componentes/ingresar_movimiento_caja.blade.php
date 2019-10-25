Vue.component('ingresar-movimiento-caja' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'<span >
   <div  class="admin-user-boton-Crear" v-on:click="abrir_modal">
       <i class="fas fa-cash-register"></i>





       
  </div>

         <div class="modal fade" id="modal-crear-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Ingresar</h4>
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













</span>'

}




);