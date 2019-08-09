<?php 
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Repositorios\EmpresaRepo;



class EmpresaViewComposer
{
    protected $EmpresaRepo;
    
    public function __construct(EmpresaRepo $EmpresaRepo)
    {
      $this->EmpresaRepo        = $EmpresaRepo;
    }

    public function compose(View $view)
    {
      $Empresa = $this->EmpresaRepo->getEmpresaDatos();
     

      $view->with(compact('Empresa'));

    }

}