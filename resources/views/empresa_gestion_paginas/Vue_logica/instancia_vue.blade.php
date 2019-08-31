
  

   

    var app = new Vue({
    el: '#app',    
    data:{

      socios:[],
      servicios:[],
      empresa: {!! json_encode($Empresa_gestion) !!},
      variable:'esta es la instancia',


      

    },
    mounted: function mounted () {        

     this.getServicios();


    },

    methods:{

     getServicios:function(){


       var url = '/get_tipo_servicios' + this.empresa.id;

       var vue = this;

       axios.get(url).then(function(response){  
          
          if(response.data.Validacion == true)
          {
            vue.servicios = response.data.servicios;
          }
          else
          {
            $.notify(response.data.Validacion_mensaje, "warn");
          }    
           
           
           }).catch(function (error){

                     
            
           });
     

     }
   }

     

   

   });









































