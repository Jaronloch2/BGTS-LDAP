<?php
namespace App\Modules\Bgtsldap\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class Bgtsldap extends Command{
	protected $module		= array('slug'=>'bgtsldap');
	protected $signature	= 'bgtsldap {--install=false : install the module!} {--refresh=false : backs up data and refreshes the migrations} {--publish=false : publishes vendor with force!}';
	protected $description	= '
	++================================================
	|| BGTS LDAP Authentication Module
	++================================================
	||
	|| php artisan bgtsldap 
	|| --install=boolean
	|| --refresh=boolean
	|| --publish=boolean
	|| boolean = true/false , default:false
	||
	|| install: Will Migrate and Seed the necesarry tables
	|| tables: bgtsldap_domains, bgtsldap_users
	|| Injects: public/Modules/bgtsldap files
	||
	|| refresh: Will backup the users and domain tables,
	|| then refresh the migrations.
	|| But you will need to reseed manually.
	||
	|| publish: Will run a vendor:publish command for the module
	|| ... forcefully.
	|| bgtsworks.blogspot.com
	||
	++================================================
	';
    public function __construct(){
        parent::__construct();
    }
    public function handle(){
		$status	= "";
		if($this->option('refresh')=='true'){
			if(Schema::hasTable('bgtsldap_users')){
				$tbls	= ['bgtsldap_users','bgtsldap_domains'];
				$status	.= "|| Backing up the tables";
				foreach($tbls as $tbl){
					$recs 	= DB::select("SELECT * from $tbl");
					$ctr	= 0;
					$bak	= "bak_" . time() . "_$tbl";
					if(!Schema::hasTable($bak)){
						DB::statement("CREATE TABLE $bak LIKE $tbl;");
						$status	.= "\n|| $tbl backup has been created";
					}
					foreach($recs as $recs){
						if(Schema::hasTable("$bak")){
							DB::table("$bak")->insert(get_object_vars($recs));
							$ctr++;
						}
					}
					$status	.= "\n|| --- $ctr records for $tbl has been backed up.";
				}
				$status	.= "\n|| --". Artisan::call('module:migrate:refresh',['slug'=>$this->module['slug'],'--seed'=>'true']);
				$status	.= "\n|| Module Refreshed!";
				$status	.= "\n|| --". Artisan::call("vendor:publish" , array('--tag'=>[$this->module['slug']], '--force'=>'true'));
				$status	.= "\n|| Module Published!";
				$status	.= "\n|| Module is Clean Slate!";
			}else{
				$status	.= "|| Module not yet installed, try: \n|| php artisan bgtsldap --install=true";
			}
		}else if($this->option('install')=='true'){
			if(!Schema::hasTable('bgtsldap_users')){
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
				$status .= "|| Module already installed... \n|| Perhaps you want to just --refresh=true the module?";
			}
		}else if($this->option('refresh')=='false' && $this->option('install')=='false' && $this->option('publish')=='true'){
			$status	.= "||\n|| --". Artisan::call("vendor:publish" , array('--tag'=>[$this->module['slug']], '--force'=>'true'));
			$status	.= "\n|| Module Published!";
		}else{
			$status	.= "\n|| try --help";
		}
		echo "
++=================================++
|| BGTS LDAP Authentication Module ||
++=================================||
||
$status
||
|| http://bgtsworks.blogspot.com
||
++================================++
	";
    }
}