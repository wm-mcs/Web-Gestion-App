
  

   var app = new Vue({
    el: '#app',    
    data:{

      nombre:'',
      email:'',
      mensaje:'',
      mensaje_enaviado:false,
      mensaje_luego_de_envio:'',
      modal_titulo:'',
      modal_mensaje:'',
      mensajes_enviados:['uno'],
      tipo_de_mensaje:'',
      para_quien_va_a_ser:''
    },
    methods:{
    enviar_contacto: function(){
      var url = '/post_contacto_form';

      var data = {  nombre:this.nombre,
                     email:this.email, 
                   mensaje:this.mensaje,
             email_nuestro:'contacto',
              titulo_email:'Solicitud de contacto'         
                 }; 

     axios.post(url,data).then(function (response){           


            var data = response.data;  

            console.log(data);

            if(data.Validacion == true)
            {
              app.mensaje_enaviado = true;
              app.mensaje_luego_de_envio = 'Mensaje enviado correctamente.';
            }
            else
            {
              app.mensaje_luego_de_envio = 'Algo no está bien, verifica los datos e intenta nuevamente';
            }
           
           }).catch(function (error){

                     
            
           });
    },
    abrir_modal_para_contacto:function(tipo_de_mensaje,para_quien_va_a_ser){

        
        this.modal_titulo = tipo_de_mensaje;
        //abro el modal
        $('#modal-contacto').modal('show');   

        
          this.tipo_de_mensaje     = tipo_de_mensaje;
          this.para_quien_va_a_ser = para_quien_va_a_ser;
        
        
    },
    enviar_contacto_variable:function(){

      var url  = '/post_contacto_form';

      var data = {  nombre:this.nombre,
                     email:this.email, 
                   mensaje:this.modal_mensaje,
             email_nuestro:this.para_quien_va_a_ser,
              titulo_email:this.tipo_de_mensaje        
                 }; 

      axios.post(url,data).then(function (response){           


            var data = response.data;  

           

            if(data.Validacion === true)
            {

              
              //aqui pongo la referencia de a quien le envie el email
              var mensaje_a = app.para_quien_va_a_ser.toString();
              
              

              if(app.tipo_de_mensaje.includes('estándar'))
              {
                app.mensajes_enviados.push('estándar');
              }
              else if(app.tipo_de_mensaje.includes('básico'))
              {
                app.mensajes_enviados.push('básico');
              }
              else if(app.tipo_de_mensaje.includes('full'))
              {
                app.mensajes_enviados.push('full');
              }
              else
              {
                app.mensajes_enviados.push(mensaje_a);
              }

              app.limpiar_datos_luego_de_email();

              

              //abro el modal
              $('#modal-contacto').modal('hide'); 

            }
            else
            {
              app.mensaje_luego_de_envio = 'Algo no está bien, verifica los datos e intenta nuevamente';
            }
           
           }).catch(function (error){

                     
            
           });           



    },
    ya_se_envio_el_mensaje:function(valor){

      this.mensajes_enviados.includes(valor);


      
    },
    limpiar_datos_luego_de_email:function(){

      this.tipo_de_mensaje     = '';
      this.para_quien_va_a_ser = '';
      this.modal_mensaje       = ''; 
      this.modal_titulo        = '';

    }

    },

   });