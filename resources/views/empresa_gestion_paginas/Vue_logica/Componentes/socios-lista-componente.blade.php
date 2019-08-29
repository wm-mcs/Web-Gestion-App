Vue.component('socios-lista' ,
{

data:function(){
    return {
      socios: {!! json_encode($Socios) !!},
      empresa_id: {{$Empresa_gestion->id}}

    }
},

template:'<span>

  
    <socio-entidad-listado  :socios="socios"></socio-entidad-listado>
  

</span>'

}




);
