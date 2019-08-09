


$( document ).ready(function(){
//entraErni
function EntraErni()
{
 $('#tema_erni_img').addClass('agrego-z-index');
}

//sale Erni 
function SaleErni()
{
 $('#tema_erni_img').removeClass('agrego-z-index');
}


//entraErni
function EntraMauri()
{
 $('#tema_mauri_img').addClass('agrego-z-index'); 
}

//sale Erni 
function SaleMauri()
{
 $('#tema_mauri_img').removeClass('agrego-z-index');
}




//arriba de mauri
$('#tema_mauri').hover(EntraMauri,SaleMauri);



//arriba de erni
$('#tema_erni').hover(EntraErni,SaleErni);







});