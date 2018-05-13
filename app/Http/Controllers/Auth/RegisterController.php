<?php

namespace App\Http\Controllers\Auth;

use App\Mail\UserRegistered;
use App\User;
use App\Http\Controllers\Controller;
use App\UserRegistrationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
	public function __construct ()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator (array $data)
	{
		return Validator::make($data,
			[
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6|confirmed',
			]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return \App\User
	 */
	protected function create (array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		]);
	}

	/**
	 * Confirm email
	 *
	 * @param Request $request
	 * @param string $token
	 *
	 * @return \Illuminate\Http\Response
	 * */
	public function confirmEmail (Request $request, $token)
	{
		User::whereToken($token)->firstOrFail()->confirmEmail();
		$request->session()->flash('message', 'Account confirmed!');
		return redirect('login');
	}

	/**
	 * Send message
	 * @param Request $request
	 *
	 * @return void
	 * */
	public function register (Request $request)
	{
		$this->validator($request->all())->validate();
		$user = $this->create($request->all());
		$this->registrationLog($request->all());

		Mail::to($user)->send(new UserRegistered($user));
		$request->session()->flash('message', 'A confirmation letter has been sent to your address.');

		return back();
	}

	/**
	 * Log registration
	 * @param array $data
	 *
	 * @return void
	 * */
	protected function registrationLog(array $data){
		UserRegistrationLog::create([
			'email' => $data['email']
		]);
	}

}
