<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgtsldapUsersTable extends Migration
{
	public $table	= "bgtsldap_users";
	public $columns	= array(
			'lname'		 	=> array('index' => null,'type'	=> 'string','params'=> null),
			'fname' 		=> array('index' => null,'type'	=> 'string','params'=> null),
			'password' 		=> array('index' => null,'type'	=> 'string','params'=> null),
			'employeeID' 	=> array('index' => 'unique','type'	=> 'string','params'=> null),
			'username'	 	=> array('index' => 'unique','type'	=> 'string','params'=> null),
			'email'	 		=> array('index' => 'unique','type'	=> 'string','params'=> null),
			'admin' 		=> array('index' => null,'type'	=> 'boolean','params'=> null),
			'active' 		=> array('index' => null,'type'	=> 'boolean','params'=> null),
			'ldap' 			=> array('index' => null,'type'	=> 'boolean','params'=> null)
		);
    public function up(){
		Schema::create($this->table, function (Blueprint $table) {
			$table->increments('id');
			
			foreach($this->columns as $col=>$data){
				if($data['params']!=null){
					if(count($data['params'])==2){
						$table->$data['type']($col,$data['params'][0],$data['params'][1]);
					}else if(count($data['params'])==1){
						$table->$data['type']($col,$data['params'][0]);
					}else{
						$table->$data['type']($col);
					}
				}else{
					$table->$data['type']($col);
				}
				if($data['index']!=null){
					$table->$data['index']($col);
				}
			}
			$table->string('picture')->default('default.jpg')->comment('Profile picture of the LDAP user.');
			$table->string('bio')->nullable()->comment('Something about the user.');
			$table->string('site')->nullable()->comment('Site Location of the user');
			$table->string('contact')->nullable()->comment('Contact number of the user');
			$table->rememberToken();
			$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
		});
    }
    public function down(){
		if(Schema::hasTAble($this->table)){
			Schema::drop($this->table);
		}
    }
}
