<?php
namespace App\Modules\Bgtsldap\Database\Seeds;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BgtsldapUserSeeder extends Seeder
{
    /**
     * Bgtsldap - Initial Admin table Seeder, Password should always be just this. Change this to your LDAP account or you wont be able to use the application. 
	 * Inserts data to the domains table 
     * @return void
     */
	public $table	= "bgtsldap_users";
	public $data	= array(
		array(
			'lname'=>'Admin',
			'fname'=>'Admin',
			'password'=>'$2y$10$DnZ4z0QGdUg.k6H1kwbgSeVch31AkoUR/FXcQyAmd40iS/DMLCyze',
			'employeeID'=>'AB12',
			'username'=>'Ldap Username',
			'email'=>'Email',
			'admin'=>'1',
			'active'=>'1',
			'ldap'=>'1'
		)
	);
    public function run(){
		$default = DB::table($this->table)->select('employeeID')->where('employeeID', $this->data[0]['employeeID'])->count();
		if($default==0){
			DB::table($this->table)->insert($this->data);
		}
    }
}
