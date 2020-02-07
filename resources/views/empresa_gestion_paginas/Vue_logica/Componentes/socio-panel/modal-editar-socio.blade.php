 <div id="boton-editar-socio" style="position:relative;" class="admin-user-boton-Crear text-center" v-on:click="editSocioShow">
        <i class="fas fa-user-edit"></i> @{{socio.name}}
       
 </div>

    <div class="modal fade" id="modal-editar-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Editar a @{{socio.name}}</h4>
          <div class="modal-mensaje-aclarador">
                Creado el @{{socio.fecha_creado_formateada}}


          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombres  </label>
                      <input type="text" class="form-control"  v-model="socio.name" placeholder="Nombre" required  />
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Cédula  <span class="formulario-label-aclaracion"> (sin puntos ni guiones)</span> </label>
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
                      <label class="formulario-label" for="Nombre">Celular internacional</label>
                      <div class="modal-mensaje-aclarador">
                       Rellená este campo solo si el socio tiene un celular distinto al de tu país. Debes agregar el celular completo sin el simbolo de +. Es para que puedas comunicarte por Whatsapp con un solo click.
                      </div>
                      <input type="text" class="form-control"  v-model="socio.celular_internacional" placeholder="Celular" required  />
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
                      <label class="formulario-label" for="Nombre">Razón social  <span class="formulario-label-aclaracion"> (solo si aplica)</span></label>
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
                      <label class="formulario-label" for="Nombre">Estado <span class="formulario-label-aclaracion"> ¿está activo? IMPORTANTE: si cambias a "no" el socio desaparecerá del listado</span></label>
                     <select v-model="socio.estado" class="form-control">
                        
                        <option>si</option>
                        <option>no</option>
                        
                      </select>
                  </div> 



               
                  <div v-if="$root.cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  </div>
                  <div v-else v-on:click="editSocioPost" class="boton-simple">@{{$root.boton_aceptar_texto}}</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">@{{$root.boton_cancelar_texto}}</button>        
        </div>
      </div>
    </div>
  </div>