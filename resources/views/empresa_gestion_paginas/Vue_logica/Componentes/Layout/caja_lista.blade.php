Vue.component('caja-lista' ,
{
props:[ 'caja','sucursal' ],
data:function(){
    return {
     mostrar:true;

    }
},
computed:{
  getClassLista:function(){
    return {
      'sub-contiene-lista-caja': this.mostrar ,
      'sub-contiene-lista-caja-deudor': this.caja.tipo_saldo === 'deudor',
      'sub-contiene-lista-caja-acredor': this.caja.tipo_saldo === 'acredor',
    }
  }
    

},
template:'  <div class="contiene-lista-caja"> 

              <div :class="getClassLista">
                <span>@{{caja.detalle}}</span>
                <span>@{{caja.moneda}}</span>            
                <span>@{{caja.valor}}</span>
              </div>             
              
            </div>'

}




);