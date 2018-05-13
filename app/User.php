<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Create temp token for confirm email
	 *
	 * @return string
	 * */
	public static function boot ()
	{
		parent::boot();

		static::creating(function ($user) {
			$user->token = str_random(30);
		});
	}

	/**
	 * Save confirm email
	 *
	 * @return void
	 * */
	public function confirmEmail ()
	{
		$this->active = true;
		$this->token = null;

		$this->save();
	}
}
