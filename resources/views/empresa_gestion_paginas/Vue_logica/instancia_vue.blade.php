
  

   

    var app = new Vue({
    el: '#app',    
    data:{

      socios:[],
      servicios:[],
      empresa_id: {{$Empresa_gestion->id}},
      variable:'esta es la instancia',


      

    },
    mounted: function mounted () {        

     this.getServicios();


    },

    methods:{

     getServicios:function(){


       var url = '/get_tipo_servicios' + this.empresa_id;

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









































