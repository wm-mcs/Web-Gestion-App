Vue.component('control-acceso' ,
{

data:function(){
    return {
     cargando:false,
     celular:'',

    }
},
mounted() {
    this.focusInput();
},
methods:{

    focusInput:function() {
        this.$refs.celular.focus();
    },
    consultarSocio:_.debounce(function(busqueda){


        alert(busqueda);
        this.cargando = true;

    }, 800)   
    

},
watch:{ 
    celular: {
      immediate: true,
      deep: true,
      handler(newValue, oldValue) {
      	this.consultarSocio(newValue);
      }
    }
},
template:`


<div v-if="cargando" class="Procesando-text">
    
    <div class="cssload-container">
          <div class="cssload-tube-tunnel"></div>
    </div>
   
</div>
<div v-else class="w-100 d-flex flex-column align-items-center">
          

   <div class="col-8 col-lg-5 d-flex flex-column align-items-center">
    @if(file_exists($Empresa->path_url_img)) 
    <img class="my-3 controll-access-empresa-cliente-logo" src="{{$Empresa->url_img}}">
    @endif
    
   

    <input ref="celular" class="controll-access-input-celular my-4" v-model="celular" type="number"  placeholder="Escribe tu celular">

   </div> 
   

          

</div>




`}




);