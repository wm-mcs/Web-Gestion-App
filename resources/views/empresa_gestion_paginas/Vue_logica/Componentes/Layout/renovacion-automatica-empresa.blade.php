Vue.component('renovacion-automatica-empresa' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     modal_nombre:'#modal-renovacion-evento'

    }
},
methods:{
abrir_modal:function(){
  app.abrirModal(this.modal_nombre);
  },


    

},
computed:{
  se_ve:function(){
  if(empresa.actualizar_servicios_socios_automaticamente == 'si')
  {
    return true;
  }
  else
  {
    return false;
  }
  }
},
template:'  <span v-if="se_ve" class="contiene-sucursal" v-on:click="abrir_modal"> <i class="fas fa-cog"></i> Empresa


    @if(isset($Empresa))
    @if(Cache::has('ActualizarEmpresaSocios'.$Empresa->id))





      

         <div class="modal fade" id="modal-renovacion-evento" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Acciones automáticas </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 
            @if(Cache::get('ActualizarEmpresaSocios'.$Empresa->id) != 'no renueva')

           
               @foreach(Cache::get('ActualizarEmpresaSocios'.$Empresa->id) as $Valor)


               <div class="flex-row-center get_width_100">
                  <div class="get_width_30" > {{$Valor->Socio}} </div> 

                  <div class="get_width_10 text-center text-bold @if($Valor->Acutualizo == 'si') color-text-success @endif " > {{$Valor->Acutualizo}}  </div> 

                  <div class="get_width_40 text-bold" >
                   @if($Valor->Acutualizo == 'no') <span class="color-text-danger">{{$Valor->Razon}}</span>  @endif </div> 

                  <div class="get_width_20 color-text-gris text-center">
                    {{$Valor->Fecha}} 
                  </div>
               </div>

               @endforeach

            @else

            @endif
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>








    @endif
    @endif



    </span> '

}




);