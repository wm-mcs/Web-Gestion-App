Vue.component('control-acceso' ,
{

data:function(){
    return {
     cargando:false,
     celular:'',
     socio:'',
     countDown:false,
     tiempoCountDown:5, /*Crear porpiedad en la empresa que configure esto*/

    }
},
mounted() {     
     this.focusInput();
},
ready() {
   
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
    countDownTimer() {
    
        if(this.countDown == false)
        {
          this.countDown = this.tiempoCountDown;
        }        
        if(this.countDown > 0) {


            setTimeout(() => {

                this.countDown -= 1;
                this.countDownTimer();
            }, 1000)
        }
        else
        {
            location.reload();
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
            vue.socio    =  data.Data;   
            vue.cargando = false;
            
            $.notify(response.data.Validacion_mensaje, "success");


            vue.countDownTimer();

            


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
    
   

    <input v-show="countDown === false" ref="celular" class="controll-access-input-celular my-4" v-model="celular" type="number"  placeholder="Escribe tu celular">
    <div v-if="countDown != false">
            <div class="">
               <div class="titulos-class text-color-black text-center mb-4">
                @{{socio.name}}
               </div>
               <div class="sub-titulos-class color-text-gris text-center mb-4">
                @{{countDown}}
               </div>
                
            </div>

    </div>
   </div> 
   

          

</div>




`}




);