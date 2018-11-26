<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\RegisterUser;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $user->notify(new RegisterUser());
        return redirect('/login')->with('success','تم إنشاء حسابك، يرجى تفعيل حسابك');
    }
    public function confirm($id,$token){
        $user=User::where('id_personnel',$id)->where('confirmation_token',$token)->first();
        if($user){
            $user->update(['confirmation_token'=>null]);
            $this->guard()->login($user);
            return redirect($this->redirectPath())->with('success','مرحبا بك في حسابك');
        }else{
            return redirect('/login')->with('danger','هذا الرابط لا يعمل بعد الآن');
        }
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
            'name' => 'required|string|max:255',
            'tel_personnel' => 'required',
            'adresse' => 'required',
            'fonction' => 'required',
            'genre' => 'required',
            'email' => 'required|string|email|max:255|unique:personnels',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'adresse' => $data['adresse'],
            'fonction' => $data['fonction'],
            'genre' => $data['genre'],
            'visible' => 1,
            'tel_personnel' => $data['tel_personnel'],
            'password' => bcrypt($data['password']),
            'confirmation_token'=>str_replace('/','',bcrypt(str_random(16)))
        ]);
    }
}
