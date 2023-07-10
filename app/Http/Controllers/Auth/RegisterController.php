<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RegisteredUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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

        $user->notify(new RegisteredUser());

        session()->flash('success','Votre compte vient d\'etre créé sur Apip-Analytics, Veuillez le confirmer à travers le mail envoyé sur votre compte');

        return redirect('/login');
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
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'tel' => ['required', 'string', 'max:255'],
            'pays' => ['required', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'prenom' => $data['prenom'],
            'tel' => $data['tel'],
            'email' => $data['email'],
            'userType' => $data['userType'],
            'sexe' => $data['sexe'],
            'adresse' => $data['adresse'],
            'pays' => $data['pays'],
            'ville' => $data['ville'],
            'entreprise' => $data['entreprise'],
            'id_pack' => $data['id_pack'],
            'password' => Hash::make($data['password']),
            'confirmation_token' => Hash::make(Str::random(16)),
        ]);
    }
}
