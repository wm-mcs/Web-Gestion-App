Vue.component('control-acceso' ,
{

data:function(){
    return {
     cargando:false,
     celular:'',
     socio:'',

    }
},
mounted() {
    this.focusInput();
},
methods:{

    focusInput:function() {
        this.$refs.celular.focus();
    },
    verificar_celular:function(celular){
        
        console.log(celular);
        if(celular.toString().length == 9)
        {
           this.consultarSocio(celular);
        }
    },
    consultarSocio:function(busqueda){

        
        
        this.cargando = true;

        var url  = '/control_acceso_socio';

        var data = {  
                      celular:busqueda,
                      empresa_id:{{$Empresa->id}}
                   };  

        var vue  = this;
                
  
       axios.post(url,data).then(function (response){  
        var data = response.data;  
        

        if(data.Validacion == true)
        {
        vue.cargando = false;
            
        $.notify(response.data.Validacion_mensaje, "success");
        }
        else
        {
        vue.cargando = false;
        $.notify(response.data.Validacion_mensaje, "error");
        }
        

        }).catch(function (error){
        vue.cargando = false;
        $.notify(error, "error");      
        
        });

    }
    

},
watch:{ 
    celular: {
      immediate: true,
      deep: true,
      handler(newValue, oldValue) {
      	this.verificar_celular(newValue);
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