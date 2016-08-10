<?php

namespace App\Modules\bgtsldap\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class BgtsldapUser extends Model implements Authenticatable
{
	use \Illuminate\Auth\Authenticatable;
    protected $table        = 'bgtsldap_users';
    protected $fillable 	= ['username','lname','fname','employeeID','email','admin','active','ldap'];
    protected $hidden 		= ['password'];
}