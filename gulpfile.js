var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {    

        
  mix.sass('admin.scss','public/css'); 
     
     

     
    

    mix.scripts([
        
        'Plugins/Plug-jquery.js',
        'Plugins/Plug-bootstrap.js',
        'Customs/helper_generales.js',
        'Plugins/Plug-Notify.js',
        'Customs/admin_eventos.js'
       

       ],'public/js/admin.js');

    


    elixir(function(mix) {
            mix.version(['css/admin.css','js/admin.js']); 
    });

    
});
