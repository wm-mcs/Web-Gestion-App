Vue.component('empresa-lista' ,
{

props:['empresa']
,  

data:function(){
    return {
       

    }
}, 


methods:{

},
computed:{
    ServiciosDisponibles:function(){
    if(this.empresa.servicios_contratados_a_empresas_activos.length > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  },
  whatsappNumero:function(){
    var url = 'https://api.whatsapp.com/send?phone='+this.empresa.celular+'&text=Hola';
    
    return url;
  }
  
},

template:'

       







<div  class="contiene-socio-tipo-lista">
  <div class="flex-row-center">
    
      
      

             <div class="flex-row-center">
                <span class="contiene-socio-lista" >@{{empresa.name}} </span> 
                @if(Auth::user()->role > 3)

                 {!! Form::open(['route' => ['get_panel_admin_de_empresa'],
                                'method'=> 'Post',
                                'files' =>  true,
                                'name'  => 'form1',                                
                                'class' => 'contiene-socio-lista_nombre-y-celular'
                              ])               !!}   
                     <input type="hidden" name="empresa_id" :value="empresa.id">                     
                     <span class="simula_link contiene-socio-lista" >@{{empresa.name}} </span> 
                     <a :href="whatsappNumero"  target="_blank">
                        <div class="contiene-socio-celular">  
                          <i class="fab fa-whatsapp"></i> @{{empresa.celular}}   
                        </div>
                      </a>   

                     {!! Form::close() !!}  

                 @endif
                
             </div>
                
            
      
      <div class="contiene-planes-socio-lista">
        
     
       <div v-for="sucursal in empresa.sucursuales_empresa" v-if="sucursal.puede_ver_el_user" class="empresa-lista-user-sucursal">
            <div class="empresa-lista-user-sucursal-entrar">Entrar a sucursal</div>
             {!! Form::open(['route' => ['get_empresa_panel_de_gestion'],
                        'method'=> 'Post',
                        'files' =>  true,
                        'name'  => 'form1'
                      ])               !!}   
             <input type="hidden" name="empresa_id" :value="empresa.id">
             <input type="hidden" name="sucursal_id" :value="sucursal.id">
             <span class="simula_link empresa-lista-user-sucursal-nombre disparar-este-form" >@{{sucursal.name}}</span>    

             {!! Form::close() !!} 
      </div>   
      </div>               



    @if(Auth::user()->role > 3)
    <div class="contiene-planes-socio-lista">
      
       

                 
              <div  v-if="ServiciosDisponibles" class="planes-mensuales-cotiene" v-for="servicio in empresa.servicios_contratados_a_empresas_activos" 
                   class="planes-mensuales-cotiene" :key="servicio.id">              
                <span>@{{servicio.name}}</span>  
                <span class="plan-mensual-fecha-vencimiento">Vence: @{{servicio.fecha_vencimiento_formateada}}</span>      
               
              </div>         
               <div v-else class="listado-socio-no-tiene" >  Nada disponible <i class="far fa-meh"></i>
               </div> 


        

    </div>
    @endif
    

  </div>
  <div class="socio-lista-contiene-estado-de-cuenta">
      @if(Auth::user()->role > 8)
       <a :href="empresa.route_admin" class="margin-right-4px"> <i class="fas fa-users-cog"></i></a>
      @endif
   
      <estado-de-cuenta-empresa-saldo :empresa="empresa" > </estado-de-cuenta-empresa-saldo>

  
  </div>



</div>





























'

}




);