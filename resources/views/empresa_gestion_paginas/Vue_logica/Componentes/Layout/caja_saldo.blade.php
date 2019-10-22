var bus = new Vue();

Vue.component('caja-saldo' ,
{

data:function(){
    return {
      sucursal:{!! json_encode(Session::get('sucursal')) !!},
      modal:'#modal-caja'

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
    abrir_modal:function(){

    }

},
created() {
    
    bus.$on('sucursal-set', (sucursal) => {
      this.sucursal = sucursal
    })
},
template:'<div>

  <div v-if="esDistintoACero(sucursal.saldo_de_caja_pesos)" class="contiene-saldo" >
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

 <div v-if="esDistintoACero(sucursal.saldo_de_caja_dolares)" class="contiene-saldo">
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


  <div class="modal fade" id="modal-caja" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Movimientos de caja</h4>
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