Vue.component('caja-lista' ,
{
props:[ 'caja','sucursal' ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:' <div >              
              <span>@{{caja.detalle}}</span>
              <span>@{{caja.moneda}}</span>            
              <span>@{{caja.valor}}</span>
            </div>'

}




);