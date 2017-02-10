<?php

namespace App\Http\Controllers\Auth;

use Hash;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function validateUser(array $data){
        return Validator::make($data, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
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

    public function index($error = false)
    {
        $auth = view('components.auth', array('error' => $error));
        return view('template', array('title' => 'Sign In', 'content' => $auth));
    }

    public function register($error = false)
    {
        $register = view('components.register', array('error' => $error));
        return view('template', array('title' => 'Sign Up', 'content' => $register));
    }

    public function loginUser(Request $request)
    {
        $data = $request->input();
        $validator = $this->validateUser($data);
        if(!$validator->fails()){
            $user = User::where('email', $data['email'])->first();
            if(password_verify($data['password'], $user['original']['password'])){
                $request->session()->push('user_id', $user['original']['id']);
                if($user['original']['status'] == 1){
                    $request->session()->push('user_status', 'admin');
                    return redirect('/admin');
                }else{
                    return redirect('/');
                }
            }
        }else{
            $error = 'Invalid email or password';
            return $this->index($error);
        }
    }

    public function createUser(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if(!$validator->fails()){
            $user = $this->create($data);
            $request->session()->push('user_id', $user->first()['original']['id']);
            return redirect('/');
        }else{
            $errors = 'Registration error. Check yout password and email';
            return $this->register($errors);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->remove('user_status');
        return redirect('/');
    }
}
