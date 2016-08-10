<?php
namespace App\Modules\Bgtsldap\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class Bgtsldap extends Command{
	protected $module		= array('slug'=>'bgtsldap');
	protected $signature	= 'bgtsldap {--install=false : install the module!}';
	protected $description	= '
	++================================================
	|| BGTS LDAP Authentication Module
	++================================================
	||
	|| php artisan bgtsldap --install=true
	|| will Migrate and Seed the necesarry tables
	|| tables: bgtsldap_domains, bgtsldap_users
	|| Injects: public/Modules/bgtsldap files
	||
	|| bgtsworks.blogspot.com
	||
	++================================================
	';
    public function __construct(){
        parent::__construct();
    }
    public function handle(){
		$status	= "||";
		if($this->option('install')=='true'){
			$status	.= "\n|| -- " . Artisan::call("module:migrate",$this->module);
			$status	.= "\n|| Migration complete!";
			$status	.= "\n|| -- " . Artisan::call("module:seed",$this->module);
			$status	.= "\n|| Seeding complete!";
			$status	.= "\n|| -- " . Artisan::call("vendor:publish" , array('--tag'=>['bgtsldap'], '--force'=>'true'));
			$status	.= "\n|| Module is ready!";
			$status	.= "\n|| Go to ". env('APP_URL') . ":[port]/bgtsldap to test.";
			$status	.= "\n||";
			$status	.= "\n|| Open and modify the Admin row inside bgtsldap_users table NOW!";
			$status	.= "\n|| Use your LDAP account, replace everything necessary EXCEPT for the password.";
			$status	.= "\n|| Retain the password or else the module will not work.";
		}else{
			$status	.= "\n|| try --help";
		}
		echo "
++=================================++
|| BGTS LDAP Authentication Module ||
++=================================||
$status
||
|| http://bgtsworks.blogspot.com
||
++================================++
	";
    }
}