
  

   

    var app = new Vue({
    el: '#app',    
    data:{     
      


      

    },
    mounted: function mounted () {        

     


    },

    methods:{



    cerrarModal:function(id_modal){

     $(id_modal).modal('hide');
     $('.modal-backdrop').remove();
    },   
    abrirModal:function(id_modal){
    $(id_modal).appendTo("body").modal('show');
    }
    
    }

     

   

   });