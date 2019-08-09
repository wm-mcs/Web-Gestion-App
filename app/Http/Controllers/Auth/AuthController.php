<?php

namespace App\Http\Controllers\Auth;

use App\Entidades\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Repositorios\UserRepo;
use App\Managers\Users\user_registro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositorios\Emails\EmailsRepo;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    protected $UserRepo;
    protected $EmailsRepo;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserRepo  $UserRepo,
                               EmailsRepo $EmailsRepo )
    {
        $this->UserRepo   = $UserRepo;
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->EmailsRepo = $EmailsRepo;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }



    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {

        $user    = $this->UserRepo->getEntidad();
        $manager = new user_registro($user,$request->all());

        //verifica si paso la validación o no
        if ($manager->isValid())
        {
         //me traigo la funcion del repositorio UserRepo y ya Hago el Login de ese Usuario   
         Auth::login($this->UserRepo->setUserRegistro($user,$request)); 

         return redirect()->route('get_home')
                          ->with('alert' , $user->name . ' Ve a tu Email: ' . $user->email .' y verifica tu cuenta');      
        }  

        
        return redirect()->back()->withErrors($manager->getErrors())->withInput($manager->getData());
    }

    public function getLogin()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        $Route = 'auth_login_post';

        return view('auth.login', compact('Route'));
    }

    




    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return route('auth_login_get');
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
       return route('get_admin_home'); 
    }

     /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'Usuario o contraseña no valida';
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        
        if (Auth::attempt($credentials, true)) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }


    

    

}
