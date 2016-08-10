<?php
namespace App\Modules\bgtsldap\Libraries;
class Ldap{
    public static function connect($adServer,$port){
		$connection = ldap_connect($adServer,$port)or die("Could not connect to LDAP server.");
		return $connection;
    }
	public function login($connection,$username,$password){
		error_reporting(E_ERROR);
		ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
		$ldaprdn 	= $username;
		$bind 		= ldap_bind($connection, $ldaprdn, $password);
		$msg		= ldap_errno($connection);
		return json_encode(array(
			'id'	=> "X100",
			'from'	=> "BGTS LDAP Library",
			'type'	=> "Message",
			'return'=> true,
			'summary'=> "Message from the LDAP Library",
			'data'	=> array(
				'errno'		=> $msg,
				'message'	=> ldap_err2str($msg)
			)
		));
		@ldap_close();
	}
}