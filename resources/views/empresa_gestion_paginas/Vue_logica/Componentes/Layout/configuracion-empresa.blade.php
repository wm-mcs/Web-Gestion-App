Vue.component('configuracion-empresa' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     modal_nombre:'#modal-configurar-empresa'

    }
},
methods:{
abrir_modal:function(){
  app.abrirModal(this.modal_nombre);
  },
    

},
template:'  <span class="contiene-sucursal" v-on:click="abrir_modal"> <i class="fas fa-cog"></i> Empresa


     <div class="modal fade" id="modal-configurar-empresa" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Menu de  @{{empresa.name}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                
              </div>
              <div class="modal-body text-center"> 



             Datos acá
                     

                        
                       
              </div>
              
            </div>
          </div>
      </div>



    </span> '

}




);

