<?php
namespace App\Modules\Bgtsldap\Database\Seeds;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BgtsldapDomainSeeder extends Seeder
{
    /**
     * Bgtsldap - Domain table Seeder
	 * Inserts data to the domains table, modify this according to your project's requirement.
     * @return void
     */
	public $table	= "bgtsldap_domains";
	public $data	= array(
		array(
			'name'=>'bgts-global.com',
			'label'=>'BGTS-GLOBAL',
			'server'=>'LDAP://192.20.145.23',
			'port'=>'389'
		)
	);
    public function run(){
		$default = DB::table($this->table)->select('server')->where('server', $this->data[0]['server'])->count();
		if($default==0){
			DB::table($this->table)->insert($this->data);
		}
    }
}
