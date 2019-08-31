Vue.component('socios-lista' ,
{
props:[ socios,empresa ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'<span>

  <div v-if="socios.length > 0">
    <socio-entidad-listado  :socios="socios" :empresa="empresa"></socio-entidad-listado>
  </div>

</span>'

}




);
