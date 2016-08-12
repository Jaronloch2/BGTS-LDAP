<?php

namespace App\Modules\Bgtsldap\Http\Controllers;

use App\Modules\Bgtsldap\Http\Requests\BgtsldapRequest;
use App\Modules\Bgtsldap\Models\Bgtsldap;
use App\Modules\Bgtsldap\Models\BgtsldapDomain;
use App\Modules\Bgtsldap\Models\BgtsldapUser;
use App\Modules\Bgtsldap\Models\BgtsldapApp;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use \Illuminate\Database\QueryException;
use \App\Modules\Bgtsldap\Libraries\Ldap;

class BgtsldapController extends Controller{
	public function __construct(){
		$moduleData	= __DIR__ . '../../../module.json';
		if(File::exists($moduleData)){
			$moduleData	= json_decode(File::get($moduleData));
			foreach($moduleData as $key=>$val){
				Config::set("module_$key",$val);
			}
		}
	}
	public function jc(){
		return view('bgtsldap::jc');
	}
	public function uploadPicture(Request $request){
		$types	= ['image/jpeg','image/jpg','image/png'];
		$pic	= Input::file('pic');
		$picdir	= public_path('Modules/bgtsldap/images/users/pictures/');
		if($pic==null){
			$del	= $request->input('del');
			if($del!='default.jpg'){
				File::delete($picdir . $del);
			}
		}else{
			$size		= $pic->getSize();
			$fileName	= $pic->getClientOriginalName();
			if(in_array($pic->getMimeType(),$types)){
				if(strtolower($fileName)=='default.jpg'){
					$fileName	= 'ppic_' . time() . '.' . $pic->getClientOriginalExtension();
				}
				if($pic->move($picdir, $fileName) && $size<1024000){
					return response(json_encode(array(
						'id'	=> "S107",
						'from'	=> "BGTS LDAP Controller",
						'type'	=> "success",
						'return'=> true,
						'summary'=> "User Picture Uploaded!",
						'data'	=> $fileName
					)));
				}else{
					return response(json_encode(array(
						'id'	=> "E107",
						'from'	=> "BGTS LDAP Controller",
						'type'	=> "error",
						'return'=> false,
						'summary'=> "Unable to upload User Picture! Needs to be less than 10KB",
					)));
				}
			}else{
				return response(json_encode(array(
					'id'	=> "E108",
					'from'	=> "BGTS LDAP Controller",
					'type'	=> "error",
					'return'=> false,
					'summary'=> "Invalid filetype!",
				)));
			}
		}
	}
    public function loginform(){
		if(!Auth::user()){
			return view('bgtsldap::loginform');
		}else{
			return "Hello <a ui-sref='bgtsldap-user({id:". Auth::user()->id ."})'>" . Auth::user()->fname . " " . Auth::user()->lname ."</a>";
		}
	}
    public function logoutform(){
		if(Auth::user()){
			return view('bgtsldap::logout');
		}
	}
	
	
	public function register(){}
    public function login(Request $request){
		if(Auth::user()==null){
			$appGrantCreds	= $request->only('username', 'password');
			if(Auth::attempt($appGrantCreds)){
				$ldap	= new Ldap;
				$domains= BgtsldapDomain::find($request['domain']);
				$server	= $domains->server;
				$port	= $domains->port;
				$label	= $domains->label;
				$username		= $request['username'];
				$usernameDN		= "$label\\$username";
				$ldappassword	= $request['ldappassword'];
				$connection	= $ldap->connect($server,$port);
				$ldapAuth	= $ldap->login($connection,$usernameDN,$ldappassword);
				$ldapAuth	= json_decode($ldapAuth);
				if($ldapAuth->data->errno==8 || $ldapAuth->data->errno==0){
					$user	= BgtsldapUser::where("username","=",$username)->first();
					echo json_encode(array(
						'id'	=> "S103",
						'from'	=> "BGTS LDAP Controller",
						'type'	=> "success",
						'return'=> true,
						'summary'=> "Welcome " . $user->fname . " " . $user->lname . "!",
						'data'	=> Auth::user()
					));
				}else{
					echo json_encode(array(
						'id'	=> "E103",
						'from'	=> "BGTS LDAP Controller",
						'type'	=> "error",
						'return'=> false,
						'summary'=> "Invalid LDAP Account",
						'data'	=> "Invalid LDAP Account - " . $ldapAuth
					));
					Auth::logout();
				}
			}else{
				echo json_encode(array(
					'id'	=> "E104",
					'from'	=> "BGTS LDAP Controller",
					'type'	=> "error",
					'return'=> false,
					'summary'=> "Username is not allowed access to this app. Please contact Admin.",
					'data'	=> "Username is not allowed access to this app. Please contact Admin."
				));
				Auth::logout();
			}
		}
	}
	public function secretkey(Request $request){
		if(isset($request['public_key'])){
			$pkey	= $request['public_key'];
			$app	= BgtsldapApp::where('public_key',$pkey);
			$result	= $app->get();
			$count	= $app->count();
			if($count){
				echo $result[0]->secret_key;
			}else{
				echo json_encode(array(
					'id'	=> "E106",
					'from'	=> "BGTS LDAP Controller",
					'type'	=> "error",
					'return'=> false,
					'summary'=> "No app registered for that key.",
					'data'	=> "No app registered for that key."
				));
			}
		}else{
			echo json_encode(array(
				'id'	=> "E105",
				'from'	=> "BGTS LDAP Controller",
				'type'	=> "error",
				'return'=> false,
				'summary'=> "BGTS LDAP App Extension: Public key is required.",
				'data'	=> "BGTS LDAP App Extension: Public key is required."
			));
		}
	}
    public function logout(){
		Auth::logout();
		echo json_encode(array(
			'id'	=> "S105",
			'from'	=> "BGTS LDAP Controller",
			'type'	=> "success",
			'return'=> true,
			'summary'=> "Session Destoyed!",
			'data'	=> "Session Destroyed!"
		));
	}
	public function syncsession($sessvar){
		if(session($sessvar)){
			echo json_encode(session($sessvar));	
		}else if($sessvar=='bgtsldapUser'){
			if(Auth::user()){
				echo json_encode(Auth::user());	
			}else{
				echo false;
			}
		}else{
			echo false;
		}
	}
	public function forgetkey(Request $request){		
		if($request->input('key')=='bgtsldapUser'){
			Auth::logout();
		}else{
			$request->session()->forget($request->input('key'));
		}
	}
	public function domains(){
		$domains	= BgtsldapDomain::all();
		echo json_encode(array(
				'id'	=> "S101",
				'from'	=> "BGTS LDAP Controller",
				'type'	=> "success",
				'return'=> true,
				'summary'=> "LDAP Domain List",
				'data'	=> $domains
			));
	}
}
