<div class="panel panel-default" ng-module="bgtsldap" ng-controller="UserController as userCtrl" role="dialog" id="userModal">
	<div class="panel-heading">{{$modalTitle	= count($users)>1 ? "BGTS LDAP Users":"BGTS LDAP User Profile"}}</div>
	<div class="panel-body">
		@foreach($users as $user)
			<div class="col-md-6">
				<div class="col-md-4 text-center">
					<img src="{{URL::to('/')}}/Modules/bgtsldap/images/users/pictures/{{$user->picture}}" class="col-md-12"/>
				</div>
				<div class="col-md-8">
					<div class="col-md-12 bold">
						{{$user->fname}} {{$user->lname}}
						@if($user->id==Auth::user()->id || Auth::user()->admin==1)
							<a ui-sref="bgtsldap-user-edit({id:{{$user->id}}})"><span class="glyphicon glyphicon-edit"></span></a>
						@endif
					</div>
					<div class="col-md-12"> {{$user->username}} - {{$user->employeeID}} - {{$user->site}}</div>
					<div class="col-md-12"> <a href="mailto:{{$user->email}}">{{$user->email}}</a></div>
					<div class="col-md-12"> {{$user->contact}}</div>
					<div class="col-md-12"> 
						<button class="btn btn-default btn-small" ng-click="userCtrl.popup('{{$user->fname}} {{$user->lname}}`s Bio','{{$user->bio}}')">Bio</button>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	<div class="panel-footer text-right text-muted small" title="{{Config::get('module_author')}}">{{$modalTitle}} v{{Config::get('module_version')}} &copy; {{Date('Y')}}</div>
</div>