<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function get_admin_home()
  {
    return view('admin.home.home');
    //puse este comando debido a que no creamos una home para admin
   /* return redirect()->route('get_admin_home') ;*/
  }
}