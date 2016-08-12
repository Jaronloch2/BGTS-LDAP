<div class="panel panel-default" ng-module="bgtsldap" ng-controller="UserController as userCtrl" ng-init="userCtrl.init({{$user}})" role="dialog" id="userModal">
	<div class="panel-heading">@{{modalTitle	= "BGTS LDAP User Profile"}}</div>
	<div class="panel-body">
		<form  ng-submit="(userForm.$valid) && userCtrl.save() " data-toggle="validator" method="POST" name="userForm" role="form" novalidate>
			<input type="hidden" value="{{csrf_token()}}" name="_token" id="csrf_token"/>
			<input ng-model="userCtrl.user._method" type="hidden" value="POST" name="_method"/>
			<div class="form-group col-md-12 text-center">
				<div class="col-md-12">
					<img ng-src="@{{userCtrl.picture}}" class="cursor-pointer" onclick="document.getElementById('UserPictureUploader').click()" title="@{{userCtrl.user.picutre}}" width="300px"/>
				</div>
				<div class="col-md-12">
					@{{userCtrl.user.picutre}}
					<input class="hidden" id="UserPictureUploader" type="file" file="userCtrl.uploadPicture"/>
				</div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-6">
					<input ng-model="userCtrl.user.fname" type="text" name="fname" class="form-control" id="fname" placeholder="Firstname" required/>
					<span class="text-danger" ng-show="userForm.fname.$invalid  && !userForm.fname.$pristine || userForm.fname.$invalid && userForm.$submitted">Firstname is Required</span>
				</div>
				<div class="col-md-6">
					<input ng-model="userCtrl.user.lname" type="text" name="lname" class="form-control" id="lname" placeholder="Lastname" required/>
					<span class="text-danger" ng-show="userForm.lname.$invalid  && !userForm.lname.$pristine || userForm.lname.$invalid && userForm.$submitted">Lastname is Required</span>
				</div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-6">
					<input ng-model="userCtrl.user.employeeID" type="text" name="employeeID" class="form-control" id="employeeID" placeholder="Employee ID" required/>
					<span class="text-danger" ng-show="userForm.employeeID.$invalid  && !userForm.employeeID.$pristine || userForm.employeeID.$invalid && userForm.$submitted">Employee ID is Required</span>
				</div>
				<div class="col-md-6">
					<input ng-model="userCtrl.user.username" type="text" name="username" class="form-control" id="username" placeholder="LDAP Username" required/>
					<span class="text-danger" ng-show="userForm.username.$invalid  && !userForm.username.$pristine || userForm.username.$invalid && userForm.$submitted">LDAP Username is Required</span>
				</div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-6">
					<input ng-model="userCtrl.user.email" class="form-control" type="email" name="email" id="email" placeholder="Email Address" required/>
					<span class="text-danger" ng-show="userForm.email.$invalid && !userForm.email.$pristine || userForm.email.$invalid && userForm.$submitted">Email is Required</span>
				</div>
				<div class="col-md-6">
					<input ng-model="userCtrl.user.contact" class="form-control" type="text" name="contact" id="contact" placeholder="Contact Number" />
				</div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-12">
					<input ng-model="userCtrl.user.site" class="form-control" type="text" name="site" id="site" placeholder="Site (ie. Parañaque, Dumaguete...)"/>
				</div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-12">
					<textarea ng-model="userCtrl.user.bio" class="form-control" name="bio" id="site" placeholder="Something about yourself..."></textarea>
				</div>
			</div>
			<div class="form-group col-md-12" ng-hide="true">
				<div class="col-md-12">
					<input ng-model="userCtrl.user.password" type="password" name="password" class="form-control" id="password" placeholder="Password" required/>
					<span class="text-danger" ng-show="userForm.password.$invalid  && !userForm.password.$pristine || userForm.password.$invalid && userForm.$submitted">Password is Required</span>
				</div>
			</div>
			<div class="form-group col-md-12">
				<br/>
				<input ng-disabled="userForm.$invalid" class="btn btn-success col-md-12" type="submit" value="SAVE"/>
			</div>
			<div class="">
				<a name="formresponse"></a>
				<div id="formresponse"></div>
			</div>
		</form>
	</div>
	<div class="panel-footer text-right text-muted small" title="{{Config::get('module_author')}}">@{{modalTitle}} v{{Config::get('module_version')}} &copy; {{Date('Y')}}</div>
</div>