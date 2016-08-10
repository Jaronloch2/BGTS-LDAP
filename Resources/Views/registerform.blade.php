<div class="panel panel-default" ng-module="bgtsldap" ng-controller="RegisterController as registerCtrl" role="dialog" id="RegisterModal">
	<div class="panel-heading">@{{modalTitle	= "BGTS Grant User Access Form"}}</div>
	<div class="panel-body">
		<form  ng-submit="(registerForm.$valid) && registerCtrl.register() " data-toggle="validator" method="POST" name="registerForm" role="form" novalidate>
			<input type="hidden" value="{{csrf_token()}}" name="_token" id="csrf_token"/>
			<div class="form-group col-md-12">
				<div class="col-md-6">
					<input ng-model="registerCtrl.user.fname" type="text" name="fname" class="form-control" id="fname" placeholder="Firstname" required/>
					<span class="text-danger" ng-show="registerForm.fname.$invalid  && !registerForm.fname.$pristine || registerForm.fname.$invalid && registerForm.$submitted">Firstname is Required</span>
				</div>
				<div class="col-md-6">
					<input ng-model="registerCtrl.user.lname" type="text" name="lname" class="form-control" id="lname" placeholder="Lastname" required/>
					<span class="text-danger" ng-show="registerForm.lname.$invalid  && !registerForm.lname.$pristine || registerForm.lname.$invalid && registerForm.$submitted">Lastname is Required</span>
				</div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-6">
					<input ng-model="registerCtrl.user.employeeID" type="text" name="employeeID" class="form-control" id="employeeID" placeholder="Employee ID" required/>
					<span class="text-danger" ng-show="registerForm.employeeID.$invalid  && !registerForm.employeeID.$pristine || registerForm.employeeID.$invalid && registerForm.$submitted">Employee ID is Required</span>
				</div>
				<div class="col-md-6">
					<input ng-model="registerCtrl.user.username" type="text" name="username" class="form-control" id="username" placeholder="LDAP Username" required/>
					<span class="text-danger" ng-show="registerForm.username.$invalid  && !registerForm.username.$pristine || registerForm.username.$invalid && registerForm.$submitted">LDAP Username is Required</span>
				</div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-12">
					<input ng-model="registerCtrl.user.email" class="form-control" type="email" name="email" id="email" placeholder="Email Address" required/>
					<span class="text-danger" ng-show="registerForm.email.$invalid && !registerForm.email.$pristine || registerForm.email.$invalid && registerForm.$submitted">Email is Required</span>
				</div>
			</div>
			<div class="form-group col-md-12" ng-hide="true">
				<div class="col-md-12">
					<input ng-model="registerCtrl.user.password" type="password" name="password" class="form-control" id="password" placeholder="Password" required/>
					<span class="text-danger" ng-show="registerForm.password.$invalid  && !registerForm.password.$pristine || registerForm.password.$invalid && registerForm.$submitted">Password is Required</span>
				</div>
			</div>
			<div class="form-group col-md-12">
				<br/>
				<input class="btn btn-success col-md-12" type="submit" value="GRANT ACCESS"/>
			</div>
			<div class="">
				<a name="formresponse"></a>
				<div id="formresponse"></div>
			</div>
		</form>
	</div>
	<div class="panel-footer text-right text-muted small" title="{{Config::get('module_author')}}">@{{modalTitle}} v{{Config::get('module_version')}} &copy; {{Date('Y')}}</div>
</div>