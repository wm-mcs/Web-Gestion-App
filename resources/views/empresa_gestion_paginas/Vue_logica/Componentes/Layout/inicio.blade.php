Vue.component('nav-inicio' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'

  
    <span class=""> <i class="fas fa-user"></i> {{Auth::user()->first_name}}</span>
  

'

}




);