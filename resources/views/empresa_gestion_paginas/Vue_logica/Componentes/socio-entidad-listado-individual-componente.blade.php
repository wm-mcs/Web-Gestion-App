Vue.component('socio-list' ,
{

props:['socio','empresa']
,  



methods:{
enviar_form:function(id){
  var id = '#'+ id.toString();

   $( id ).parent().submit();
}
         

},
computed:{
  
  clasesDisponibles:function(){
    if(socio.servicios_contratados_disponibles_tipo_clase.length > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  },
  mensualDisponibles:function(){
    if(socio.servicios_contratados_disponibles_tipo_mensual.length > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }


}
template:'  
<div class="listado-socios-contenedor-individual">
     

      <div class="listado-socios-sub-contenedor-name-estado">
        <div class="listado-socios-name"> 

         
       {!! Form::open(['route' => ['get_socio_panel'],
                            'method'=> 'Post',
                            'files' =>  true,
                          ])               !!}   

       <input type="hidden" name="empresa_id" :value="empresa.id">
       <input type="hidden" name="socio_id" :value="socio.id">
       <span :id="socio.id"></span>

       <span class="simula_link"  v-on:click="enviar_form(socio.id)">@{{socio.name}}</span> 
        

       {!! Form::close() !!}  

        </div>
        <div>@{{socio.estado}}</div>
      </div>

      <div class="listado-socios-sub-contenedor-datos">
        <span class="listado-socios-datos"><i class="fas fa-envelope"></i> @{{socio.email}}</span>
        <span class="listado-socios-datos"><i class="far fa-id-badge"></i> @{{socio.cedula}}</span>
        <span class="listado-socios-datos"><i class="fas fa-mobile-alt"></i> @{{socio.celular}}</span>
        
      </div>
      <div>
        <div v-if="clasesDisponibles">Hay clases disponibles</div>
        <div v-if="mensualDisponibles">Hay mensual disponibles</div>
        
      </div>
          
</div>'

}




);