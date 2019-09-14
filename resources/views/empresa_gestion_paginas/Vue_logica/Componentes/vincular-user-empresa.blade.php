
Vue.component('vincular-user-empresa',
{
props:['empresa'],

data:function(){
    return { 
      
      users:[]

      }
},
mounted: function mounted () {        

    
     


},
computed: {

},
methods:{

    
getUserSegunRole:function(role){
  
}
     


         

},
template:'
<span>
<div>hola</div>

<v-select label="name_para_select" :options="users"></v-select>
</span>',

});