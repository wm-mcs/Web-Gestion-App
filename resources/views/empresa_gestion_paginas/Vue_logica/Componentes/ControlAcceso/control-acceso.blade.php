Vue.component('control-acceso' ,
{

data:function(){
    return {
     cargando:false,
     celular:'',

    }
},
methods:{

   

},
template:`


<div v-if="cargando" class="Procesando-text">
    
    <div class="cssload-container">
          <div class="cssload-tube-tunnel"></div>
    </div>
   
</div>
<div v-else class="w-100 d-flex flex-column align-items-center">
          
    @if(file_exists($Empresa->path_url_img)) 
    <img class="my-3 controll-access-empresa-cliente-logo" src="{{$Empresa->url_img}}">
    @endif
    
    <h1 class="sub-titulos-class text-center">Control de acceso</h1>

    <input class="controll-access-input-celular" v-model="celular" type="number"  placeholder="Escribe tu celular">

          

</div>




`}




);