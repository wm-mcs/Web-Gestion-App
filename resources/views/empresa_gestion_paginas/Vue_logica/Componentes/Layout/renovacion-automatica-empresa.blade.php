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
  if(this.empresa.actualizar_servicios_socios_automaticamente == 'si')
  {
    return true;
  }
  else
  {
    return false;
  }
  }
},
template:' @if(Auth::user()->role >= 3) <span v-if="se_ve" class="contiene-sucursal" v-on:click="abrir_modal"> <i class="fas fa-robot"></i> Automático


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


               <div class="flex-row-center get_width_100 text-pequeno margin-top-2px">
                  <div class="get_width_30 text-left text-bold helper-aumenta-texto" > {{$Valor->Socio}} </div> 

                  <div class="get_width_10 helper-aumenta-texto text-center text-bold @if($Valor->Acutualizo == 'si') color-text-success @endif " > {{$Valor->Acutualizo}}  </div> 

                  <div class="get_width_40 text-bold" >
                  <span class="  @if($Valor->Acutualizo == 'no') color-text-danger @else color-text-success @endif  text-left"> {{$Valor->Razon}}</span>  </div> 

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



    </span>@endif '

}




);