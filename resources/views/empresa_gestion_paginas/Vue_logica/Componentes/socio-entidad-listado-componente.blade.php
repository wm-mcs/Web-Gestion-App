Vue.component('socio-entidad-listado' ,
{

props:{
   socios: {
      
    }
}
,  



methods:{

         

},
template:'<span>

  <div v-if="socios.length > 0" class="listado-socios-contenedor-lista">
    <div v-for="socio in socios" :key="socio.id" class="listado-socios-contenedor-individual">
     

      <div class="listado-socios-sub-contenedor-name-estado">
        <div class="listado-socios-name">  <a :href="socio.route">@{{socio.name}}</a> </div>
        <div>@{{socio.estado}}</div>
      </div>

      <div class="listado-socios-sub-contenedor-datos">
        <span class="listado-socios-datos"><i class="fas fa-envelope"></i> @{{socio.email}}</span>
        <span class="listado-socios-datos"><i class="far fa-id-badge"></i> @{{socio.cedula}}</span>
        <span class="listado-socios-datos"><i class="fas fa-mobile-alt"></i> @{{socio.celular}}</span>
        
      </div>
      <div>
        
      </div>
          
    </div>
  </div> 

</span>'

}




);