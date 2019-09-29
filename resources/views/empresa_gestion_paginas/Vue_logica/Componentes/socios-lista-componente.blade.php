Vue.component('socios-lista' ,
{
props:['empresa'],
data:function(){
    return {
      


    }
},

template:'<span>

  
    <socio-entidad-listado   :empresa="empresa"></socio-entidad-listado>
  

</span>'

}




);
