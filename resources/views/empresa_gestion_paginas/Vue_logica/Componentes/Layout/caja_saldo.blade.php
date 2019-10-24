var bus = new Vue();

Vue.component('caja-saldo' ,
{

data:function(){
    return {
      sucursal:{!! json_encode(Session::get('sucursal')) !!},
      modal_pesos:'#modal-caja-pesos',
      modal_dolares:'#modal-caja-pesos',
      valor_actual_pesos:'0'

    }
},
methods:{

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
      app.abrirModal(this.modal_pesos);
    },
    abrir_modal_dolares:function(){
      app.abrirModal(this.modal_dolares);
    },
    devuelve_valor_saldo:function(valor_que_viene,index){
      
        console.log(index);
        this.valor_actual_pesos = (parseFloat(this.valor_actual_pesos) + parseFloat(valor_que_viene));

        return parseFloat(this.valor_actual_pesos) + parseFloat(valor_que_viene);
      
      

    }

},
created() {
    
    bus.$on('sucursal-set', (sucursal) => {
      this.sucursal = sucursal
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
          <h4 class="modal-title" id="myModalLabel">Movimientos de caja pesos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 
          <div v-for="(caja,index) in sucursal.movimientos_de_caja_pesos" :key="caja.id">
            <span>@{{caja.detalle}}</span>
            <span>@{{caja.moneda}}</span>            
            <span>@{{caja.valor}}</span>
            <span>Saldo @{{ devuelve_valor_saldo(caja.valor,index) }}</span>
          </div>

                  
                 
        </div>
       
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-caja-dolares" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Movimientos de caja dolares</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 


                  
                 
        </div>
       
      </div>
    </div>
  </div>


  
   
  

</div>'

}




);