Vue.component('socios-lista' ,
{
props:[empresa],
data:function(){
    return {
      socios: {!! json_encode($Socios) !!},
      empresa_id: {{$Empresa_gestion->id}}

    }
},

template:'<span>

  
    <socio-entidad-listado  :socios="socios" :empresa="empresa"></socio-entidad-listado>
  

</span>'

}




);
