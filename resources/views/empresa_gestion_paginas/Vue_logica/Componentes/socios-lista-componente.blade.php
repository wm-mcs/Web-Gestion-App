Vue.component('socios-lista' ,
{
props:['empresa','socios'],
data:function(){
    return {
      

    }
},

template:'<span>

  
    <socio-entidad-listado  :socios="socios" :empresa="empresa"></socio-entidad-listado>
  

</span>'

}




);
