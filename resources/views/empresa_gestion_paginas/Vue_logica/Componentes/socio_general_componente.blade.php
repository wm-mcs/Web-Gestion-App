Vue.component('socios-lista' ,
{

data:function(){
    return {
      socios:'hola'

    }
},
mounted: function mounted () {        

       this.getSociosActivos();


},
methods:{

     getSociosActivos:function()
     {
       var url = '/get_socios_activos';

       var vue = this;

       console.log(vue);

       axios.get(url).then(function(response){  
          
            

           vue.socios = response.data.socios;

            

           
           
           }).catch(function (error){

                     
            
           });
     }

},
template:'<span>

  <div v-if="socios.length > 0">
    <socio-entidad-listado  socios="socios"></socio-entidad-listado>
  </div>

</span>'

}




);
