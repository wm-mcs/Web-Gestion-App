var bus = new Vue();

Vue.component('caja-saldo' ,
{

data:function(){
    return {
      sucursal:{!! json_encode(Session::get('sucursal')) !!}

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
    }

},
created() {
    
    bus.$on('sucursal-set', (sucursal) => {
      this.sucursal = sucursal
    })
},
template:'<div>

  <div v-if="esDistintoACero(sucursal.saldo_de_caja_pesos)" class="contiene-saldo">
     <span class="saldo-aclaracion"> 
       Saldo de caja en pesos de la sucursal <span >@{{sucursal.name}}</span>
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
       Saldo de caja en dolares de la sucursal <span >@{{sucursal.name}}</span>
     </span>
     <div v-if="esMatoyIgualACero(sucursal.saldo_de_caja_dolares)" class="saldo-valor">
       U$S @{{sucursal.saldo_de_caja_dolares}}
     </div>
     <div v-else class="color-text-danger saldo-valor">
       U$S @{{sucursal.saldo_de_caja_dolares}}
     </div>
 </div>
   
  

</div>'

}




);