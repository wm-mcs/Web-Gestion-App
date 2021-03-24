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
   },
   saldoPesosMenorCero:function(){
      if( this.socio.saldo_de_estado_de_cuenta_pesos < 0)
      {
        return true;
      }
      else
      {
        return false;
      }
   },
   saldoDoalresMenorCero:function(){
       if( this.socio.saldo_de_estado_de_cuenta_dolares < 0)
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

 <div v-if="!saldoPesosIgualCero || !saldoDolaresIgualCero " class="w-100">


              <div v-if="saldoPesosMayorCero" class="color-text-success text-right datos-socio-lista">

                <span v-if="saldoPesosMayorCero">
                <i class="fas fa-check-circle"></i>  A favor $ @{{ Math.abs(socio.saldo_de_estado_de_cuenta_pesos)}}
                </span>

              </div>
              <div v-if="saldoPesosMenorCero" class="color-text-error text-right datos-socio-lista">
              <i class="fas fa-times-circle"></i> Debe $ @{{ Math.abs(socio.saldo_de_estado_de_cuenta_pesos)}}
              </div>

              <div v-if="saldoDoalresMayorCero" class="color-text-success text-right datos-socio-lista">

                <span v-if="saldoDoalresMayorCero">
                <i class="fas fa-check-circle"></i>   A favor U$S @{{Math.abs(socio.saldo_de_estado_de_cuenta_dolares)}}
                </span>

              </div>
              <div v-if="saldoDoalresMenorCero" class="color-text-error text-right datos-socio-lista">
              <i class="fas fa-times-circle"></i>  Debe U$S @{{Math.abs(socio.saldo_de_estado_de_cuenta_dolares)}}
              </div>

           </div>
           <div v-else class="color-text-success text-right datos-socio-lista">
           <i class="fas fa-check-circle"></i>     Al día
           </div>





`
}




);
