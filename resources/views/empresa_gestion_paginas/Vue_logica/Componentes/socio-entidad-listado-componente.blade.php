Vue.component('socio-entidad-listado' ,
{

props:['empresa','palabra_busqueda']
,  

data:function(){
    return {
         socios:'',
         cargando:false,
         cargando_inactivos:false,
         socios_inactivos:[],
         filtro_busqueda:'sin_filtro',
         filtros_busqueda:[{nombre:'Sin filtro',value:'sin_filtro'},{nombre:'Deudores',value:'deudores'},{nombre:'Sin nada contratado',value:'sin_nada'}],
         opcion_ordenar:'nuevos',
         opciones_ordenar:[{
                            nombre:'Alfabético creciente', 
                             value:'asc'
                           },
                           {
                            nombre:'Alfabético decreciente', 
                             value:'desc'
                           },
                           {
                            nombre:'Primeros creados', 
                             value:'viejos'
                           },
                           {
                            nombre:'Recién creados', 
                             value:'nuevos'
                           },
                           {
                            nombre:'Por vencer servicio',
                             value:'se_vence'
                           }


                          ]

    }
}, 

mounted: function mounted () {
  this.get_socios();
},

watch:{ 

    palabra_busqueda: {
      immediate: true,
      deep: true,
      handler(newValue, oldValue) {
      	this.checkSearchStr(newValue);
      }
    }


   
},
computed:{
  socios_filtrados:function(){
    var socios = this.socios;
    switch(this.filtro_busqueda){
    case "deudores":
         socios = socios.filter(function (el) {
          return el.saldo_de_estado_de_cuenta_pesos < 0 ||
                 el.saldo_de_estado_de_cuenta_dolares < 0 

        });
    
    break;

    case "sin_nada":
         socios = socios.filter(function (el) {
          return el.servicios_contratados_disponibles_tipo_clase.length == 0 &&
                 el.servicios_contratados_disponibles_tipo_mensual.length == 0 

        });
    
    break;
    case "sin_filtro":
    socios = socios;

    break;
    

    default:
        socios = socios;
    }



 
   

    switch(this.opcion_ordenar){
    case "asc":
         socios = socios.sort(this.comparar_valor('name','asc'));
    
    break;

    case "desc":
         socios = socios.sort(this.comparar_valor('name','desc'));
    
    break;
    case "nuevos":
         socios = socios.sort(this.comparar_valor('created_at','desc'));
    
    break;
    case "viejos":
         socios = socios.sort(this.comparar_valor('created_at','asc'));
    
    break;
    case "se_vence":
       socios = socios.sort(this.compara_valor_de_vencimiento);

    break;

    default:
        socios = socios;
    }
    


    return socios;


  }
},
methods:{

comparar_valor:function(key, order = 'asc') {
  return function innerSort(a, b) {
    if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
      
      return 0;
    }

    const varA = (typeof a[key] === 'string')
      ? a[key].toUpperCase() : a[key];
    const varB = (typeof b[key] === 'string')
      ? b[key].toUpperCase() : b[key];

    let comparison = 0;
    if (varA > varB) {
      comparison = 1;
    } else if (varA < varB) {
      comparison = -1;
    }
    return (
      (order === 'desc') ? (comparison * -1) : comparison
    );
  };
},
compara_valor_de_vencimiento:function(a,b){

  let comparison = 0;
  if(a.servicios_contratados_del_socio.length == 0 && b.servicios_contratados_del_socio.length != 0 )
  {
    return -1;
  }
  else if(a.servicios_contratados_del_socio.length != 0 && b.servicios_contratados_del_socio.length == 0){
    return 1;
  }

  

    const varA =  new Date(a.servicios_contratados_del_socio[0].fecha_vencimiento);
    const varB =  new Date(b.servicios_contratados_del_socio[0].fecha_vencimiento);

      

    
    if (varA > varB) {
      comparison = 1;
    } else if (varA < varB) {
      comparison = -1;
    }
    console.log(varA,varB,comparison);

    return comparison;
  
  
},
actualizar_socios:function(socios){
	this.socios = socios;
},
get_socios:function(){

  var url = '/get_socios_activos';

      var data = {  
                    empresa_id: this.empresa.id       
                 };  
      var vue = this;  
      this.cargando = true;         

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.cargando = false; 
               vue.socios = response.data.Socios;              
               
            }
            else
            {
              vue.cargando = false; 
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
  
},
get_socios_inactivos:function(){

  var url = '/get_socios_inactivos';

      var data = {  
                    empresa_id: this.empresa.id       
                 };  
      var vue = this;  
      this.cargando_inactivos = true;         

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.cargando_inactivos = false; 
               vue.socios_inactivos = response.data.Socios;    
               $.notify(response.data.Validacion_mensaje, "success");            
               
            }
            else
            {
              vue.cargando_inactivos = false; 
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
  
},
checkSearchStr: _.debounce(function(string){

	if(string != '')
	{
      
      var url = '/buscar_socios_activos';

      var data = {  busqueda: string,
                    empresa_id: this.empresa.id       
                 };  
      var vue = this;           

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.socios = response.data.Socios;  

               
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });



	}
    }, 800)
},
created() {
    
    bus.$on('socios-set', (socios) => {
      this.socios = socios
    })
},
template:'
<div v-if="socios.length" class="empresa-contendor-de-secciones">
  <div class="titulo-socios-cuando-hay"><i class="fas fa-users"></i> Socios  <i class="far fa-hand-point-down"></i></div>



  <div class="contiene-filtros">
    <div class="form-group">
                      <label class="formulario-label" for="Nombre">Ordenar</label>
                      
                     <select v-model="opcion_ordenar" class="form-control" >
                        
                        <option v-for="option in opciones_ordenar" :value="option.value">@{{option.nombre}}</option>
                        
                        
                      </select>
    </div> 
    <div class="form-group">
                      <label class="formulario-label" for="Nombre">Filtrar</label>
                      
                     <select v-model="filtro_busqueda" class="form-control" >
                        
                        <option v-for="option in filtros_busqueda" :value="option.value">@{{option.nombre}}</option>
                        
                        
                      </select>
    </div> 
  </div>



  <div v-if="socios.length > 0 && !cargando" class="listado-socios-contenedor-lista">

    <socio-list 

    v-for="socio in socios_filtrados" 
                 :key="socio.id" 
               :socio="socio" 
             :empresa="empresa"
              v-on:ActualizarSocios="actualizar_socios" ></socio-list>

  
  </div> 
  <div v-else class="Procesando-text get_width_100">
     
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  
    
  </div>
  <br>
  <br>

  <div v-if="socios_inactivos.length" class="titulo-socios-cuando-hay"><i class="fas fa-users"></i> Socios inactivos <i class="far fa-hand-point-down"></i></div>
  <div v-else class="simula_link get_width_100 text-center" v-on:click="get_socios_inactivos">
    Ver si hay socios inactivos
  </div>
   <div v-if=" !cargando_inactivos" class="listado-socios-contenedor-lista">

    <socio-list 

    v-for="socio in socios_inactivos" 
                 :key="socio.id" 
               :socio="socio" 
             :empresa="empresa"
              v-on:ActualizarSocios="actualizar_socios" ></socio-list>

  
  </div> 
  <div v-else class="Procesando-text get_width_100">
     
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  
    
  </div>


</div>  
<div v-else class="cuando-no-hay-socios">
<div v-if="cargando" class="Procesando-text get_width_100">
     
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  
    
  </div>
 <span v-else>No hay socios <i class="far fa-frown"></i></span> 
</div>

'

}




);