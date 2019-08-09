 <div id="boton-editar-socio" style="position:relative;" class="admin-user-boton-Crear" v-on:click="editSocioShow">
        <i class="fas fa-user-edit"></i>
       
 </div>

    <div class="modal fade" id="modal-editar-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Editar a @{{socio.name}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombres  </label>
                      <input type="text" class="form-control"  v-model="socio.name" placeholder="Nombre" required  />
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Cedula  <span class="formulario-label-aclaracion"> (sin puntos ni guiones)</span> </label>
                      <input type="text" class="form-control"  v-model="socio.cedula" placeholder="Cedula" required  />
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Email</label>
                      <input type="text" class="form-control"  v-model="socio.email" placeholder="Email" required  />
                  </div> 
                   <div class="form-group">
                      <label class="formulario-label" for="Nombre">Celular</label>
                      <input type="text" class="form-control"  v-model="socio.celular" placeholder="Celular" required  />
                  </div> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Dirección</label>
                      <input type="text" class="form-control"  v-model="socio.direccion" placeholder="Dirección" required  />
                  </div> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Rut  <span class="formulario-label-aclaracion"> (solo si aplica)</span></label>
                      <input type="text" class="form-control"  v-model="socio.rut" placeholder="Rut" required  />
                  </div> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Razon social  <span class="formulario-label-aclaracion"> (solo si aplica)</span></label>
                      <input type="text" class="form-control"  v-model="socio.razon_social" placeholder="Razon social" required  />
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Mutualista  <span class="formulario-label-aclaracion"> (solo si aplica)</span></label>
                      <input type="text" class="form-control"  v-model="socio.mutualista" placeholder="Mutualista" required  />
                  </div> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Notas <span class="formulario-label-aclaracion"> </span></label>
                      <input type="text" class="form-control"  v-model="socio.nota" placeholder="Escribe algo para tener en cuenta con este socio" required  />
                  </div> 

                 <div class="form-group">
                      <label class="formulario-label" for="Nombre">Estado <span class="formulario-label-aclaracion"> ¿está activo?</span></label>
                     <select v-model="socio.estado" class="form-control">
                        
                        <option>si</option>
                        <option>no</option>
                        
                      </select>
                  </div> 



               

                  <div v-on:click="editSocioPost" class="boton-simple">Editar</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>