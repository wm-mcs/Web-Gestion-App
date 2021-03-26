 <div id="boton-editar-socio" style="position:relative;" class="admin-user-boton-Crear  " v-on:click="editSocioShow">
        <i class="fas fa-user-edit"></i> @{{socio.name}}

 </div>

    <div class="modal fade" id="modal-editar-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">

        <div class="">
          <h4 class="modal-title" id="myModalLabel"> Editar a @{{socio.name}}</h4>
          <div class="modal-mensaje-aclarador">
                Socio desde el @{{socio.fecha_creado_formateada}}


          </div>
        </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>

        </div>
        <div class="modal-body ">



        <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="name"
                        type="text"
                        class="input-text-class-primary"
                        v-model="socio.name"
                        required

                      />
                      <label for="name">Nombres y apellidos</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="cedula"
                        type="text"
                        class="input-text-class-primary"
                        v-model="socio.cedula"
                        required

                      />
                      <label for="cedula">Cédula o DNI</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="email"
                        type="text"
                        class="input-text-class-primary"
                        v-model="socio.email"
                        required

                      />
                      <label for="email">Email</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="celular"
                        type="number"
                        class="input-text-class-primary"
                        v-model="socio.celular"
                        required

                      />
                      <label for="celular">Celular</label>
                    </fieldset>
                  </div>


                  <div class="formulario-label-fiel">
                  <div class="modal-mensaje-aclarador">Rellenar este campo únicamente si el socio tiene un celular distinto al de tu país. Agregar el celular completo sin el símbolo de +. Esto es para que puedas comunicarte por Whatsapp con un solo click.</div>
                    <fieldset class="float-label">
                      <input
                        name="celular_internacional"
                        type="number"
                        class="input-text-class-primary"
                        v-model="socio.celular_internacional"
                        required

                      />
                      <label for="celular_internacional">Celular</label>
                    </fieldset>
                  </div>


                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="direccion"
                        type="text"
                        class="input-text-class-primary"
                        v-model="socio.direccion"
                        required

                      />
                      <label for="direccion">Dirección</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="mutualista"
                        type="text"
                        class="input-text-class-primary"
                        v-model="socio.mutualista"
                        required

                      />
                      <label for="mutualista">Mutualista</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel">

                  <div class="modal-mensaje-aclarador">
                    Usá las notas para poner algún comentario que creas relevante. Ejemplo:'Llamó para avisar que dejó una campera.'
                   </div>

                    <fieldset class="float-label">

                    <textarea name="nota" id="" cols="30"  class="input-text-class-primary"
                        v-model="socio.nota" required rows="10"></textarea>

                      <label for="mutualista">Notas</label>
                    </fieldset>
                  </div>





                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">

                      <input type="file"
                      name="imagen"

                      v-on:change="onImageChange"
                      accept="image/*"
                      class="input-text-class-primary">
                      <label for="imagen">Foto de perfil</label>
                    </fieldset>
                  </div>



                  <div class="formulario-label-fiel">

                  <div class="modal-mensaje-aclarador">
                       Si cambias a "No" no podrás realizar acciones con el socio (cobrar, vender, etc) y el mismo no se mostrará en los listados.
                      </div>
                    <fieldset class="float-label">

                    <select required name="estado" v-model="socio.estado" class="input-text-class-primary">

                        <option>si</option>
                        <option>no</option>

                      </select>

                      <label for="estado">Estado</label>
                    </fieldset>
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
