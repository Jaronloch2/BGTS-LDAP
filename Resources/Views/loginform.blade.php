<div class="panel panel-default" ng-module="bgtsldap" ng-controller="LoginController as loginCtrl" role="dialog" id="LoginModal">
	<div class="panel-heading">@{{modalTitle	= "BGTS LDAP Authentication Form"}}</div>
	<div class="panel-body">
		<form  ng-submit="(loginForm.$valid && (loginCtrl.user.domain!='Choose a Domain')) && loginCtrl.logIn() " data-toggle="validator" method="POST" name="loginForm" role="form" novalidate>
			<input type="hidden" value="{{csrf_token()}}" name="_token" id="csrf_token"/>
			<div class="form-group col-md-12">
				<select ng-model="loginCtrl.user.domain" ng-options="domain.id as domain.label for domain in bgtsldapdomains.data.data" name="domain" class="form-control" id="domain" required autofocus>
					<option value="" disabled selected hidden>Please Choose a Domain...</option>
				</select>
				<span class="text-danger" ng-show="loginForm.domain.$modelValue=='Choose a Domain'  && !loginForm.domain.$pristine || loginForm.domain.$modelValue=='Choose a Domain' && loginForm.$submitted">Domain is Required</span>
			</div>
			<div class="form-group col-md-12">
				<input ng-model="loginCtrl.user.username" class="form-control" type="text" name="username" id="username" placeholder="Please enter your LDAP username" required/>
				<span class="text-danger" ng-show="loginForm.username.$invalid && !loginForm.username.$pristine || loginForm.username.$invalid && loginForm.$submitted">LDAP Username is Required</span>
			</div>
			<div class="form-group col-md-12">
				<input ng-model="loginCtrl.user.ldappassword" class="form-control" type="password" name="ldappassword" id="ldappassword" placeholder="Please enter your LDAP password" required/>
				<span class="text-danger" ng-show="loginForm.ldappassword.$invalid && !loginForm.ldappassword.$pristine || loginForm.ldappassword.$invalid && loginForm.$submitted">LDAP Password is Required</span>
			</div>
			<div class="form-group col-md-12">
				<br/>
				<input class="btn btn-success col-sm-12" type="submit" value="LOGIN"/>
			</div>
			<div class="">
				<a name="formresponse"></a>
				<div id="formresponse"></div>
			</div>
		</form>
	</div>
	<div class="panel-footer text-right text-muted small" title="{{Config::get('module_author')}}">@{{modalTitle}} v{{Config::get('module_version')}} &copy; {{Date('Y')}}</div>
</div>