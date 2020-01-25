var bus = new Vue();

Vue.component('caja-saldo' ,
{

data:function(){
    return {
      sucursal:{!! json_encode(Session::get('sucursal'.$Empresa->id)) !!},
      modal_pesos:'#modal-caja-pesos',
      modal_dolares:'#modal-caja-dolares',
      valor_actual_pesos:'0',
      movimientos_de_caja_pesos:0,
      movimientos_de_caja_dolares:0

    }
},
methods:{

    getMovimientosDeCaja:function(){

      var url = '/get_movimientos_de_caja_de_sucursal';

      var data = {    
                       empresa_id:  this.sucursal.empresa_id, 
                      sucursal_id:  this.sucursal.id   
                 };  
      var vue = this; 

      app.cargando = true;          

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               
               app.cargando = false;
               if(data.movimientos_de_caja_pesos.length)
               {
                vue.movimientos_de_caja_pesos = data.movimientos_de_caja_pesos;
               }
               if(data.movimientos_de_caja_dolares.length)
               {
                vue.movimientos_de_caja_dolares = data.movimientos_de_caja_dolares;
               }
               
               $.notify(response.data.Validacion_mensaje, "success");
            }
            else
            { app.cargando = false;
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });

    },
   

    esMatoyIgualACero:function(valor){
        if(valor < 0 )
        {
          return false;
        }
        else
        {
          return true;
        }
    },
    esDistintoACero:function(valor){
      if(valor == 0)
      {
        return false;
      }
      else
      {
        return true;
      }
    },
    abrir_modal_pesos:function(){
      this.getMovimientosDeCaja();
      app.abrirModal(this.modal_pesos);
    },
    abrir_modal_dolares:function(){
      this.getMovimientosDeCaja();
      app.abrirModal(this.modal_dolares);
    }
    

},
created() {
    
    bus.$on('sucursal-set', (sucursal) => {
      this.sucursal = sucursal
    });

    bus.$on('actualizar-movimientos-de-caja', () => {
      this.getMovimientosDeCaja();
    })
},
template:'<div>

  <div v-if="esDistintoACero(sucursal.saldo_de_caja_pesos)" class="contiene-saldo" v-on:click="abrir_modal_pesos" title="Clcik para ver detalle de caja">
     <span class="saldo-aclaracion"> 
       Saldo caja pesos sucursal <span class="text-bold" >@{{sucursal.name}}</span> <i class="fas fa-hand-point-right"></i>
     </span>
     <div v-if="esMatoyIgualACero(sucursal.saldo_de_caja_pesos)" class="saldo-valor">
       $ @{{sucursal.saldo_de_caja_pesos}}
     </div>
     <div v-else class="color-text-danger saldo-valor ">
       $ @{{sucursal.saldo_de_caja_pesos}}
     </div>
  </div> 

 <div v-if="esDistintoACero(sucursal.saldo_de_caja_dolares)" class="contiene-saldo" v-on:click="abrir_modal_dolares" title="Clcik para ver detalle de caja">
     <span class="saldo-aclaracion"> 
       Saldo caja dolares sucursal <span class="text-bold" >@{{sucursal.name}}</span> <i class="fas fa-hand-point-right"></i>
     </span>
     <div v-if="esMatoyIgualACero(sucursal.saldo_de_caja_dolares)" class="saldo-valor">
       U$S @{{sucursal.saldo_de_caja_dolares}}
     </div>
     <div v-else class="color-text-danger saldo-valor">
       U$S @{{sucursal.saldo_de_caja_dolares}}
     </div>
 </div> 


 <div class="modal fade" id="modal-caja-pesos" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title get_width_80" id="myModalLabel">
            Movimientos de caja pesos:  
            <div class="saldo-modal">              
              Saldo  
              <span class="saldo-modal-valor">$ @{{sucursal.saldo_de_caja_pesos}} </span>
            </div>
            

          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div v-if="$root.cargando" class="Procesando-text">Procesado...</div>
        <div v-if="esDistintoACero(movimientos_de_caja_pesos)"  class="modal-body text-center"> 
          <caja-lista v-for="(caja,index) in movimientos_de_caja_pesos" 
                       :key="caja.id"
                       :caja="caja"
                       :sucursal="sucursal">
            
           
            
          </caja-lista>

                  
                 
        </div>
       
      </div>
    </div>
  </div>

  <div  class="modal fade" id="modal-caja-dolares" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Movimientos de caja dolares
           
            <div class="saldo-modal">              
              Saldo  
              <span class="saldo-modal-valor">U$S @{{sucursal.saldo_de_caja_dolares}} </span>
            </div>
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div v-if="$root.cargando" class="Procesando-text">Procesado...</div>
        <div v-if="esDistintoACero(movimientos_de_caja_dolares)" class="modal-body text-center"> 
          <caja-lista v-for="(caja,index) in movimientos_de_caja_dolares" 
                       :key="caja.id"
                       :caja="caja"
                       :sucursal="sucursal">
            
           
            
          </caja-lista>

                  
                 
        </div>
       
      </div>
    </div>
  </div>


  
   
  

</div>'

}




);