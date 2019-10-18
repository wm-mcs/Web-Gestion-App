Vue.component('caja-saldo' ,
{

data:function(){
    return {
      sucursal:{!! json_encode(Session::get('sucursal')) !!}

    }
},
methods:{

    esMatoyIgualACero:function(valor){

    }

},
template:'<div>

   <span> 
     Saldo de caja en pesos de la sucursal <span >@{{sucursal.name}}</span>
   </span>
   
   <span> 
     Saldo de caja en dolares de la sucursal <span >@{{sucursal.name}}</span>
   </span>
   
  

</div>'

}




);