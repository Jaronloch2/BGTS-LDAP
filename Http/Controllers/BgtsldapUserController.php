<?php

namespace App\Modules\Bgtsldap\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use App\Modules\Bgtsldap\Models\BgtsldapUser;

class BgtsldapUserController extends Controller
{ 
	public function __construct(){
		$moduleData	= __DIR__ . '../../../module.json';
		if(File::exists($moduleData)){
			$moduleData	= json_decode(File::get($moduleData));
			foreach($moduleData as $key=>$val){
				Config::set("module_$key",$val);
			}
		}
	}
	public function index(Request $request){
		$user	= BgtsldapUser::all();
		return view('bgtsldap::profile-badge',['users'=>$user]);
	}
    public function store(Request $request){
		if(Auth::user()->admin==1){
			$bgtsldapUser	= new BgtsldapUser();
			$ignore			= ['_method','csrf_token'];
			foreach($request->input() as $key=>$val){
				if(!in_array($key,$ignore)){
					$val	= $key=='password' ? bcrypt($val):$val;
					$bgtsldapUser->$key	= $val;
				}
			}
			$bgtsldapUser->active	= 1;
			$bgtsldapUser->ldap		= 1;
			$bgtsldapUser->admin	= 0;
			try{
				$bgtsldapUser->save();
				echo json_encode(array(
					'id'	=> "S102",
					'from'	=> "BGTS LDAP User Controller",
					'type'	=> "success",
					'return'=> true,
					'summary'=> "User registered!",
					'data'	=> "User registered!"
				));
			}catch(QueryException $e){
				echo json_encode(array(
					'id'	=> "E102",
					'from'	=> "BGTS LDAP User Controller",
					'type'	=> "error",
					'return'=> false,
					'summary'=> $e->errorInfo[2],
					'data'	=> $e->errorInfo
				));
			}
		}
	}
    public function update($id, Request $request){
		$user	= BgtsldapUser::find($id);
		foreach($request->input() as $key=>$val){
			if(!in_array($key,['id','_method','created_at','updated_at','data','config','status','statusText','password'])){
				// $val		= $key=='password' ? bcrypt($val):$val;
				$user[$key] = $val;
			}
		}
		if($user->save()){
			echo json_encode(array(
				'id'	=> "S102",
				'from'	=> "BGTS LDAP User Controller",
				'type'	=> "success",
				'return'=> true,
				'summary'=> "User data has been UPDATED!",
				'data'	=> $user
			));
		}
	}
    public function show($id){
		$user	= BgtsldapUser::find($id);
		return view('bgtsldap::profile-badge',['users'=>[$user]]);
	}
    public function destroy($id){}
    public function create(){
		if(Auth::user()!==null){
			if(Auth::user()->admin==1){
				$user	= new BgtsldapUser;
				return view('bgtsldap::profile',['user'=>$user]);
			}
		}
	}
    public function edit($id){
		$id		= $id==Auth::user()->id || Auth::user()->admin==1 ? $id:Auth::user()->id;
		$user 	= BgtsldapUser::find($id);
		return view('bgtsldap::profile',['user'=>$user]);
	}
}
