Vue.component('control-acceso' ,
{

data:function(){
    return {
     cargando:false,
     celular:'',
     socio:'',
     countDown:false,
     tiempoCountDown:{{$Empresa->tiempo_luego_consulta_control_access}}, /*Crear porpiedad en la empresa que configure esto*/

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

              if(this.countDown == 0)
              {
                  this.cargando = true;
                  location.reload();
              }
              else
              {
                  this.countDownTimer();
              }

             

            }, 1000)
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
            vue.countDownTimer();
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
computed:{
  
  estaAlDia:function(){
      if(this.socio.saldo_de_estado_de_cuenta_dolares < 0 || this.socio.saldo_de_estado_de_cuenta_pesos < 0)
      {
        return false;
      }

      return true;

  },
  tieneAlgoContratado:function(){
     if(this.socio.servicios_contratados_disponibles_tipo_mensual.length || this.socio.servicios_contratados_disponibles_tipo_mensual.length)
     {
      return true;
     }
  },
  validacion:function(){

    let Validation;
    let Mensaje;

    if(this.estaAlDia && this.tieneAlgoContratado)
    {
      Validation = true;
      Mensaje    = '';
    }

    if(this.estaAlDia && !this.tieneAlgoContratado)
    {
      Validation = false;
      Mensaje    = 'No tienes ningun plan o cuponera vigente';
    }

    if(!this.estaAlDia && this.tieneAlgoContratado)
    {
      Validation = false;
      Mensaje    = 'Tienes una deuda de ' + this.socio.saldo_de_estado_de_cuenta_pesos;
    }


     return {
               validacion:Validation,
                  mensaje:Mensaje
            };



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
            <div v-if="socio != ''" class="d-flex flex-column align-items-center">
               <div class="titulos-class text-color-black text-center mb-4">
                @{{socio.name}}
               </div>

               <div v-if="validacion.validacion" class="iconoDeControll mb-5 color-text-success">
                 <i class="fas fa-check-circle"></i>
               </div>

                <div v-if="!validacion.validacion" class="iconoDeControll mb-5 color-text-gris">
                  <i class="fas fa-exclamation-triangle"></i>
                </div>

                <div v-if="!validacion.validacion" class="color-text-gris mb-4 color-text-gris">
                  @{{validacion.mensaje}}
                </div>

                


               <div class="sub-titulos-class color-text-gris text-center mb-4">
                @{{countDown}}
               </div>
                
            </div>
            <div v-else class="d-flex flex-column align-items-center">
               <div class="sub-titulos-class color-text-gris text-center mb-4">
                 No tenemos ese celular <i class="fas fa-hand-point-right"></i> <b>@{{celular}}</b> en la base de datos  ¿Está bien el número? 
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