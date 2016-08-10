<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgtsldapDomainsTable extends Migration
{
	public $table	= "bgtsldap_domains";
	public $columns	= array(
			'name'		 	=> array('index' => null,'type'	=> 'string','params'=> null),
			'label' 		=> array('index' => null,'type'	=> 'string','params'=> null),
			'server' 		=> array('index' => 'unique','type'	=> 'string','params'=> null),
			'port'		 	=> array('index' => null,'type'	=> 'integer','params'=> null)
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
