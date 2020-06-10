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
    var url = 'https://api.whatsapp.com/send?phone='+this.empresa.celular.substr(1)+'&text=Hola';
    
    return url;
  }
  
},

template:'

       







<div  class="empresa-lista-user-contenedor">
  
    
      
      

            
               
                
                  
               
                 {!! Form::open(['route' => ['get_panel_admin_de_empresa'],
                                'method'=> 'Post',
                                'files' =>  true,
                                'name'  => 'form1', 
                              ])               !!}   
                     <input type="hidden" name="empresa_id" :value="empresa.id">                     
                     <span class="contiene-socio-lista  @if(Auth::user()->role > 4) simula_link disparar-este-form @endif" >@{{empresa.name}} </span> 
                     

                 {!! Form::close() !!}  

                 <br>


                 <div v-for="sucursal in empresa.sucursuales_empresa" v-if="sucursal.puede_ver_el_user" class="empresa-lista-user-sucursal">
                        
                         {!! Form::open(['route' => ['get_empresa_panel_de_gestion'],
                                    'method'=> 'Post',
                                    'files' =>  true,
                                    'name'  => 'form1',
                                    'class' => 'empresa-lista-entrar-y-sucursal'
                                  ])               !!}   
                         
                         <input type="hidden" name="empresa_id" :value="empresa.id">
                         <input type="hidden" name="sucursal_id" :value="sucursal.id">
                         <span class="simula_link empresa-lista-user-sucursal-nombre disparar-este-form" >

                           <i class="fas fa-sign-in-alt"></i> Ingresar a sucursal @{{sucursal.name}}

                         </span>    

                         {!! Form::close() !!}     

                  </div>   
                  <br>




                 @if(Auth::user()->role > 3)
                  <a :href="whatsappNumero" class="empresa-lista-datos" target="_blank">
                       <i class="fab fa-whatsapp"></i> @{{empresa.celular}}
                   </a>
                 @endif

                 
                @if(Auth::user()->role > 8)
                 <a :href="empresa.route_admin" class="empresa-lista-datos"> Admin</a>
                @endif

               
                 

                  
        
     
                   
                   


                 

                
                
            
                
            
      
     
    
   
      
       

                 
              <div  v-if="ServiciosDisponibles" class="empresa-lista-datos color-letra-servicio-disponible" v-for="servicio in empresa.servicios_contratados_a_empresas_activos" 
                    :key="servicio.id">   

              Servicio @{{servicio.name}} disponible hasta el @{{servicio.fecha_vencimiento_formateada}}    
               
              </div>         
              


              <br>


              <estado-de-cuenta-empresa-saldo :empresa="empresa" > </estado-de-cuenta-empresa-saldo>


        

    
    
    

  
  
  
  



</div>





























'

}




);