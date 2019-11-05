Vue.component('agregar-al-socio-un-servicio' ,
{


data:function(){
    return {
      
      
      servicio_data:{
                        name:'',
                        tipo:'',
                        moneda:'',
                        valor:'',
                        fecha_vencimiento:'',
                        cantidad_de_servicios:'',
                        empresa_id:this.empresa.id,
                        socio_id:this.socio.id,
                        socio_empresa_id:'',
                        paga:'si',
                        tipo_servicio_id:''

                    },
      tipo_servicio:'',              

    }
},

props:['socio','empresa']
,


mounted: function mounted () {        
      
    this.setFecha();

},
methods:{

 setFecha:function()
 {
       var fecha =  new Date();
       fecha.setMonth(fecha.getMonth() + 1);

       this.servicio_data.fecha_vencimiento = fecha.toISOString().slice(0,10);
 },

 abrir_modal:function(){

   $('#modal-agregar-servicio-socio').appendTo("body").modal('show');  
   

 },
 crear_servicio_a_socio:function(){  

     var url  = '/agregar_servicio_a_socio';

      var data = this.servicio_data;

      var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              vue.$emit('actualizar_servicios_de_socios',response.data.servicios);   
              vue.$emit('actualizar_socio',response.data.Socio);   
              app.cerrarModal('#modal-agregar-servicio-socio');
              bus.$emit('sucursal-set', response.data.sucursal); 
              $.notify(data.Validacion_mensaje, "success");      
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
            }
           
      }).catch(function (error){}); 





 },
 cambioTipoDeServicio:function(){

  
  var servicio = this.seleccionarUnObjetoSegunAtributo( this.empresa.tipo_servicios,'name',this.tipo_servicio);
                  

  this.servicio_data.name             = servicio.name;
  this.servicio_data.tipo             = servicio.tipo;
  this.servicio_data.moneda           = servicio.moneda;
  this.servicio_data.valor            = servicio.valor;
  this.tipo_servicio_id               = servicio.id;

  this.servicio_data.socio_id         = this.socio.id;
  this.servicio_data.socio_empresa_id = this.socio.empresa_id;

  if(servicio.tipo != 'mensual')
  {
    this.servicio_data.cantidad_de_servicios = 1;
  } 
  else
  {
    this.servicio_data.cantidad_de_servicios = 0;
  }
}, 
seleccionarUnObjetoSegunAtributo:function(lista,atributo,valor){
        return lista.find(function(element) {
        return element.name == valor;
      });
},

     

},
template:'<span>
 <div id="boton-editar-socio" style="position:relative;" class="admin-user-boton-Crear panel-socio-agrega-margin-left-boton" v-on:click="abrir_modal">
        <i class="fas fa-cash-register"></i> Vender servicio
       
 </div>

    <div class="modal fade" id="modal-agregar-servicio-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Agregar un servicio a @{{socio.name}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                

              

                 <div class="formulario-label-fiel">
                      <label class="formulario-label" >Tipo de servicio <span class="formulario-label-aclaracion"> ¿por clase o mensual?</span></label>
                     <select v-on:change="cambioTipoDeServicio" class="form-control" v-model="tipo_servicio">
                        <option></option>
                        <option v-for="servicio in empresa.tipo_servicios">@{{servicio.name}}</option>
                       
                        
                      </select>
                  </div> 

                  <div  class="formulario-label-fiel" v-if="servicio_data.name">
                      <label class="formulario-label" >Nombre <span class="formulario-label-aclaracion"> Puedes cambiar este nombre si quieres</span></label>
                      <input type="text" class="formulario-field"  v-model="servicio_data.name" placeholder="Nombre"   />
                  </div> 

                  

                    <div  class="formulario-label-fiel" v-if="servicio_data.moneda">
                      <label class="formulario-label" >Moneda</label>
                      <select v-model="servicio_data.moneda" class="form-control">
                        <option>$</option>
                        <option>U$S</option>
                        
                       
                        
                      </select>
                    </div> 

                     <div  class="formulario-label-fiel" v-if="servicio_data.cantidad_de_servicios >= 1">
                      <label class="formulario-label" >Cantidad de clases</label>
                      <input type="number" class="formulario-field"  v-model="servicio_data.cantidad_de_servicios"   />
                     </div>

                     <div  class="formulario-label-fiel" v-if="servicio_data.valor">
                      <label class="formulario-label" >Valor <span v-if="servicio_data.cantidad_de_servicios"> de todas las clases</span> </label>
                      <input type="text" class="formulario-field"  v-model="servicio_data.valor"   />
                     </div> 


                     <div  class="formulario-label-fiel" v-if="servicio_data.name">
                      <label class="formulario-label" >Fecha de vencimiento <span class="formulario-label-aclaracion"> por defecto es a un més</span></label>
                      <input type="date" class="formulario-field"  v-model="servicio_data.fecha_vencimiento"    />
                     </div> 

                      <div  class="formulario-label-fiel" v-if="servicio_data.name">
                      <label class="formulario-label" >¿Lo paga ahora? <span class="formulario-label-aclaracion"> puede que quede debiendo</span></label>
                      <div class="form-control">
                        <input type="radio" id="si" value="si" v-model="servicio_data.paga">
                        <label for="si">si</label>

                         <input type="radio" id="no" value="no" v-model="servicio_data.paga">
                         <label for="no">no</label>
                      </div>
                      
                     </div> 



                     



               

                  <div v-on:click="crear_servicio_a_socio" class="boton-simple">Agregar</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>
  
   
  

</span>'
}




);