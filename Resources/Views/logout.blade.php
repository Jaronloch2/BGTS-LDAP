<div class="panel panel-default" ng-module="jAuth" ng-controller="LogoutController as logoutCtrl" role="dialog" id="LogoutModal">
	<div class="panel-heading">Logout?</div>
	<div class="panel-body text-center">
		All unsaved works will be discarded. Are you sure you want to logout?
		<u>press_[esc]_to_cancel</u>
		<br/>
		<button class="btn btn-sm btn-danger" ng-click="logoutCtrl.logOut()">Yes, I want to Logout</button>
	</div>
	<div class="panel-footer text-right text-muted small" title="{{Config::get('module_author')}}">@{{modalTitle}} v{{Config::get('module_version')}} &copy; {{Date('Y')}}</div>
</div>
