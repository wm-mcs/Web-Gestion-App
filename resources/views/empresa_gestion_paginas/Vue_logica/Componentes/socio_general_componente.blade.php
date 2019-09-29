Vue.component('socios-lista' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'<span>

  
    <socio-entidad-listado   :empresa="empresa"></socio-entidad-listado>
  

</span>'

}




);
