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
  
   

},
template:'<span>
  
 <div v-if="!socio.saldo_de_estado_de_cuenta_pesos == 0 || !socio.saldo_de_estado_de_cuenta_dolares == 0" class="flex-row-center">
            
         
              <div v-if="es_mayor_que_sero(socio.saldo_de_estado_de_cuenta_pesos)" class="estado-de-cuenta-saldo estado-pago-indication">
                <span v-if="socio.saldo_de_estado_de_cuenta_pesos == 0">
                  Esta al día <i class="far fa-grin"></i> (en pesos)
                </span>
                <span v-else>
                  Tiene a favor $ @{{ Math.abs(socio.saldo_de_estado_de_cuenta_pesos)}} <i class="far fa-grin"></i>
                </span>
                
              </div>
              <div v-else class="estado-de-cuenta-saldo estado-debe-indication">
                Debe pesos: $ @{{ Math.abs(socio.saldo_de_estado_de_cuenta_pesos)}}  <i class="far fa-frown-open"></i>
              </div>

              <div v-if="es_mayor_que_sero(socio.saldo_de_estado_de_cuenta_dolares)" class="estado-de-cuenta-saldo estado-pago-indication">
                <span v-if="socio.saldo_de_estado_de_cuenta_dolares == 0">
                  Esta al día <i class="far fa-grin"></i> (en dolares)
                </span>
                <span v-else>
                  Tiene a favor U$S @{{Math.abs(socio.saldo_de_estado_de_cuenta_dolares)}} <i class="far fa-grin"></i>
                </span>
                
              </div>
              <div v-else class="estado-de-cuenta-saldo estado-debe-indication">
                Debe pesos: U$S @{{Math.abs(socio.saldo_de_estado_de_cuenta_dolares)}}  <i class="far fa-frown-open"></i>
              </div>

           </div>   
           <div v-else class="estado-de-cuenta-saldo estado-pago-indication"">
                  Está al día <i class="far fa-grin"></i> 
           </div>




</span>
'
}




);