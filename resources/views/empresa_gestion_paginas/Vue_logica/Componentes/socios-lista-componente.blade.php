Vue.component('socios-lista' ,
{
props:['empresa'],
data:function(){
    return {
      socios: {!! json_encode($Socios) !!},

    }
},

template:'<span>

  
    <socio-entidad-listado  :socios="socios" :empresa="empresa"></socio-entidad-listado>
  

</span>'

}




);
