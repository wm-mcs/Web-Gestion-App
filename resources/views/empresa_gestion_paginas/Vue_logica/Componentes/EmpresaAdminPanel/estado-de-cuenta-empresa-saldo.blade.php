Vue.component('estado-de-cuenta-empresa-saldo' ,
{


data:function(){
    return {
      
            

    }
},

props:['empresa']
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
  
 <div v-if="!empresa.estado_de_cuenta_saldo_pesos == 0 || !empresa.estado_de_cuenta_saldo_dolares == 0" class="flex-row-center">
            
         
              <div v-if="es_mayor_que_sero(empresa.estado_de_cuenta_saldo_pesos)" class="estado-de-cuenta-saldo estado-pago-indication">
                <span v-if="empresa.estado_de_cuenta_saldo_pesos == 0">
                  Está al día <i class="far fa-grin"></i> (en pesos)
                </span>
                <span v-else>
                  Tiene a favor $ @{{ Math.abs(socio.estado_de_cuenta_saldo_pesos)}} <i class="far fa-grin"></i>
                </span>
                
              </div>
              <div v-else class="estado-de-cuenta-saldo estado-debe-indication">
                Debe pesos: $ @{{ Math.abs(empresa.estado_de_cuenta_saldo_pesos)}}  <i class="far fa-frown-open"></i>
              </div>

              <div v-if="es_mayor_que_sero(empresa.estado_de_cuenta_saldo_dolares)" class="estado-de-cuenta-saldo estado-pago-indication">
                <span v-if="empresa.estado_de_cuenta_saldo_dolares == 0">
                  Está al día <i class="far fa-grin"></i> (en dolares)
                </span>
                <span v-else>
                  Tiene a favor U$S @{{Math.abs(empresa.estado_de_cuenta_saldo_dolares)}} <i class="far fa-grin"></i>
                </span>
                
              </div>
              <div v-else class="estado-de-cuenta-saldo estado-debe-indication">
                Debe pesos: U$S @{{Math.abs(empresa.estado_de_cuenta_saldo_dolares)}}  <i class="far fa-frown-open"></i>
              </div>

           </div>   
           <div v-else class="flex-row-center" >
                 <div class="estado-de-cuenta-saldo estado-pago-indication">Está al día <i class="far fa-grin"></i> </div> 
           </div>




</span>
'
}




);