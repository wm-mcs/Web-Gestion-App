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
template:'

       <div class="empresa-lista-user-contenedor">
        <div class="empresa-lista-user-header">
          <div class="empresa-lista-user-contiene-img">
            <img src="{{$empresa->url_img}}" class="empresa-lista-user-img">
          </div>
           <span class="simula_link empresa-lista-user-sucursal-nombre disparar-este-form" >@{{empresa.name}}</span> 

          @if(Auth::user()->role > 3)

             {!! Form::open(['route' => ['get_panel_admin_de_empresa'],
                            'method'=> 'Post',
                            'files' =>  true,
                            'name'  => 'form1'
                          ])               !!}   
                 <input type="hidden" name="empresa_id" :value="empresa.id">
                 
                 <span class="simula_link empresa-lista-user-sucursal-nombre disparar-este-form" >Entrar a admin</span>    

                 {!! Form::close() !!}  


          @endif



           
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
      </div> 

'

}




);