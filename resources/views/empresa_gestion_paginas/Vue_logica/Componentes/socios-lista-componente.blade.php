Vue.component('socios-lista' ,
{

data:function(){
    return {
      socios:'hola',
      empresa_id: {{$Empresa_gestion->id}}

    }
},
mounted: function mounted () {        

       this.getSociosActivos();


},
methods:{

     getSociosActivos:function()
     {
       var url = '/get_socios_activos'+ this.empresa_id;

       var vue = this;

       

       axios.get(url).then(function(response){  
          
           

           vue.socios = response.data.socios;

            

           
           
           }).catch(function (error){ 

                     
            
           });
     }

},
template:'<span>

  
    <socio-entidad-listado  :socios="socios"></socio-entidad-listado>
  

</span>'

}




);
