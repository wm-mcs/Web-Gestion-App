Vue.component('renovacion-automatica-empresa' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     modal_nombre:'#modal-renovacion-evento',
     cargando:false,
     Data:[],
     showModal:false

    }
},
mounted() {     
     this.setRenovaciones();
},


methods:{
abrir_modal:function(){
  app.abrirModal(this.modal_nombre);
},
setRenovaciones:function(){

  this.cargando = true;

        var url  = '/actuliarServiciosDeManeraAutomatica';

        var data = {  
                       
                   };  

        var vue  = this;                
  
        axios.post(url,data).then(function (response){  

        var data = response.data;         

        if(data.Validacion == true)
        {
            vue.Data    =  data.Data;   
            vue.cargando = false;   
        }
        else
        {
            vue.cargando = false;            
        }
        

        }).catch(function (error){
            vue.cargando = false;
            $.notify(error, "error");              
        });

    }
  



    

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
template:` 

 @if(Auth::user()->role >= 3)
 <span v-if='cargando'>
      <div class="cssload-container">
          <div class="cssload-tube-tunnel"></div>
    </div>
 </span>
 <span v-else>
   

 <span v-if="se_ve" class="contiene-sucursal">


 <span @click="showModal = !showModal"><i class="fas fa-robot"></i> Automático</span> 

  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <h3>
              Acciones automáticas 
            </h3>
            <p>
              A continuación se presentan las actividades automáticas que realiza el sistema con respecto a la actualización de los servicios de caracter mensual de los socios. Se realizan una vez al día
            </p>
          </div>

          <div class="modal-body">
            <p class="mb-1 col-12" v-for="valor in Data" :class="{ 'color-text-success': valor.Acutualizo == 'si' }">
              @{{valor.Socio}} <i class="fas fa-hand-point-right"></i>  @{{valor.Acutualizo}}. 
              <span v-if="valor.Acutualizo != 'si'">No se actualizo por que: @{{valor.Razon}} </span>

              | Fecha:  @{{valor.Fecha}}  
            </p>
         


          </div>

          <div class="modal-footer">
           
              <button class="modal-default-button" @click="showModal = !showModal" >
                Cerrar
              </button>
           
          </div>
        </div>
      </div>
    </div>
  </transition>




 </span>
    </span>

@endif`

}




);