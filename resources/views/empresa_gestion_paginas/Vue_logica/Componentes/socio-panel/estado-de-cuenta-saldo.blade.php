Vue.component('estado-de-cuenta-socio-saldo' ,
{


data:function(){
    return {
      
            

    }
},

props:['empresa','socio']
,


mounted: function mounted () {        
      
   

},
methods:{

es_mayor_que_sero:function(valor){
        if(valor >= 0)
        {
          return true;
        }
        else
        {
          return false;
        }
     }
   
     

},
computed:{
  
    saldoPesosIgualCero:function(){
    if( this.socio.saldo_de_estado_de_cuenta_pesos == 0)
    {
      return true;
    }
    else
    {
      return false;
    }
   },
   saldoDolaresIgualCero:function(){
      if( this.socio.saldo_de_estado_de_cuenta_dolares == 0)
      {
        return true;
      }
      else
      {
        return false;
      }
   },
   saldoPesosMayorCero:function(){
      if( this.socio.saldo_de_estado_de_cuenta_pesos > 0)
      {
        return true;
      }
      else
      {
        return false;
      }
   },
   saldoDoalresMayorCero:function(){
       if( this.socio.saldo_de_estado_de_cuenta_dolares > 0)
      {
        return true;
      }
      else
      {
        return false;
      }
   }

},
template:'<span>
  
 <div v-if="!saldoPesosIgualCero || !saldoDolaresIgualCero " class="flex-row-center">
            
         
              <div v-if="saldoPesosMayorCero" class="estado-de-cuenta-saldo estado-pago-indication">
                
                <span v-if="saldoPesosMayorCero">
                  A favor $ @{{ Math.abs(socio.saldo_de_estado_de_cuenta_pesos)}} <i class="fas fa-check-square"></i>
                </span>
                
              </div>
              <div v-else class="estado-de-cuenta-saldo estado-debe-indication">
                Debe $ @{{ Math.abs(socio.saldo_de_estado_de_cuenta_pesos)}}  <i class="far fa-frown-open"></i>
              </div>

              <div v-if="saldoDoalresMayorCero" class="estado-de-cuenta-saldo estado-pago-indication">
               
                <span v-if="saldoDoalresMayorCero">
                  A favor U$S @{{Math.abs(socio.saldo_de_estado_de_cuenta_dolares)}} <i class="fas fa-check-square"></i>
                </span>
                
              </div>
              <div v-else class="estado-de-cuenta-saldo estado-debe-indication">
                Debe U$S @{{Math.abs(socio.saldo_de_estado_de_cuenta_dolares)}}  <i class="far fa-frown-open"></i>
              </div>

           </div>   
           <div v-else class="estado-de-cuenta-saldo estado-pago-indication"">
                  Al día <i class="fas fa-check-square"></i>
           </div>




</span>
'
}




);