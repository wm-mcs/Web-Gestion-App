Vue.component('socios-lista' ,
{
props:[ socios ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'<span>

  <div v-if="socios.length > 0">
    <socio-entidad-listado  socios="socios"></socio-entidad-listado>
  </div>

</span>'

}




);
