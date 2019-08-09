           

  

             {!! Form::open( ['route'   => 'post_contacto_form',
                             'method'   => 'Post',
                             'files'    => true,
                             'class'    => 'text-center flex-row-column get_width_100',
                             'v-show'   => "mensaje_enaviado != true"
                           
                            ])               !!}

                            <h2 class="section-heading">¿En qué te puedo ayudar?</h2>
                            <hr class="my-4">
                           
             <div class="formulario-contacto-wraper">
              
                
                   <div class="form-group get_width_100">
                        <label class="control-label" for="Nombre">Nombres</label>
                        <input v-model="nombre" type="text" class="form-control" id="Nombre" name="nombre" placeholder="Introduzca su nombre" required  />
                    </div>               
                    <div class="form-group get_width_100">
                        <label class="control-label" for="Correo">Dirección de Correo Electrónico</label>
                        <input v-model="email" type="email" class="form-control" id="Correo" name="email" placeholder="Introduzca su correo electrónico" required />
                    </div>
                    <div class="form-group get_width_100">
                        <label class="control-label" for="Mensaje">Mensaje</label>
                        <textarea v-model="mensaje" rows="5" cols="30" class="form-control" id="Mensaje" name="mensaje" placeholder="Introduzca su mensaje" required ></textarea>
                    </div>

                    <div v-show="mensaje_luego_de_envio != '' && mensaje_enaviado != true" class="alert alert-warning alert-dismissible fade show" role="alert">
                       Algo no está bien. Verifica los datos e intenta de nuevo.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="form-group get_width_100" v-if="nombre !='' && email !='' && mensaje !='' ">                
                        <div v-on:click="enviar_contacto" class="btn btn-primary" value="Enviar"> Enviar </div>
                        {{-- <input type="submit" class="btn btn-primary" value="Enviar Submit">  --}}
                    </div> <div class="form-group get_width_100" v-else="nombre !='' && email !='' && mensaje !='' ">                
                        <button class="btn btn-primary bg-primary" disabled>Enviar</button>
                        
                    </div> 
                    <div id="respuesta" style="display: none;"></div>

            </div>

            {!! Form::close() !!}


      <div v-show="mensaje_enaviado == true" class="p-5 get_width_100" role="alert">
        <h2 class="text-center text-color-primary"><span class="fa fa-check-circle"></span> </h2> 
        <br>
        <h2 class="text-center text-color-primary">@{{mensaje_luego_de_envio}}</h2>        
      </div>