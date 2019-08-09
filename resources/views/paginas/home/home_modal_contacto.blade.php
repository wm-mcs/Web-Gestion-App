<div class="modal fade" id="modal-contacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">@{{modal_titulo}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body text-center">

                <div class="form-group">
                    <label class="control-label" for="Nombre">Nombres</label>
                    <input v-model="nombre" type="text" class="form-control" id="Nombre" name="nombre" placeholder="Introduzca su nombre" required  />
                </div>               
                <div class="form-group">
                    <label class="control-label" for="Correo">Dirección de Correo Electrónico</label>
                    <input v-model="email" type="email" class="form-control" id="Correo" name="email" placeholder="Introduzca su correo electrónico" required />
                </div>
                 <div class="form-group">
                    <label class="control-label" for="Mensaje">Mensaje</label>
                    <textarea v-model="modal_mensaje" rows="5" cols="30" class="form-control" id="Mensaje" name="mensaje" placeholder="Introduzca su mensaje" required ></textarea>
                </div>

                <div v-show="mensaje_luego_de_envio != '' && mensaje_enaviado != true" class="alert alert-warning alert-dismissible fade show" role="alert">
                   Algo no está bien. Verifica los datos e intenta de nuevo.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="form-group" v-if="nombre !='' && email !='' && modal_mensaje !='' ">                
                    <div v-on:click="enviar_contacto_variable()" class="btn btn-primary" value="Enviar"> Enviar </div>
                    {{-- <input type="submit" class="btn btn-primary" value="Enviar Submit">  --}}
                </div> <div class="form-group" v-else="nombre !='' && email !='' && modal_mensaje !='' ">                
                    <button  v-on:click.prevent="enviar_contacto_variable()" class="btn btn-primary bg-primary" disabled>Enviar</button>
                    
                </div> 
               

             

               
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
      </div>
    </div>
  </div>
</div>
