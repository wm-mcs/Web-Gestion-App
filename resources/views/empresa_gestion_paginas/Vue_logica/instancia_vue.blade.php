
  

   

    var app = new Vue({
    el: '#app',    
    data:{     
      servicios:[],
      empresa: {!! json_encode($Empresa) !!},
      variable:'esta es la instancia',


      

    },
    mounted: function mounted () {        

     


    },

    methods:{



    cerrarModal:function(id_modal){

     $(id_modal).modal('hide');
     $('.modal-backdrop').remove();
    },   
    
    }

     

   

   });









































