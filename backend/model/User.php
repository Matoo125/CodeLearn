<?php 
namespace codelearn\model;

use m4\m4mvc\core\Model;
use m4\m4mvc\helper\Str;

class User extends Model 
{
	public function register($data)
	{
		$sql = "INSERT INTO users(username, slug, password, email, role) VALUES(:username, :slug, :password, :email, :role)";
		$args = [
			'username'  =>  $data['username'],
			'slug'	    =>  Str::Slugify($data['username']),
			'password'  =>	$data['password'],
			'email'		=>	$data['email'],
			'role'		=>	1
		];
		$this->save($sql, $args);
	}

	public function checkByEmail ($email)
	{
		$sql = "SELECT id from users WHERE email = :email";
		return $this->fetch($sql, ['email' => $email]);
	}

	public function getByEmail ($email)
	{
		$sql = 'SELECT * from users WHERE email = :email';
		return $this->fetch($sql, ['email' => $email]);
	}
}