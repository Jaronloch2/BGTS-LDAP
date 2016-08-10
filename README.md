# BGTS LDAP Authentication Module
_A simple LDAP authentication module for Laravel using Caffeinated Module and Angular JS_
#### Checks if a username is registered in an LDAP collection.
#### Replaces the default Laravel Authentication.

## Requirements:
* [Laravel 5.2] (http://laravel.com/)
* [Caffeinated Modules 3.1](https://github.com/caffeinated/modules)
* [BGTS Scaffold](https://github.com/Jaronloch2/BGTS-Scaffold)

## Pre Installation
1. Open `Bgtsldap\Database\Seeder\BgtsldapDomainSeeder` and fill up the array:
> `array('name'=>'yourdomain.com','label'=>'YOUR-DOMAIN','server'=>'LDAP://192.168.1.2','port'=>'389');`

### Explanation:

##### name
> The domain of your server. `yourdomain.com`
##### label
> This is the DN, used in ldap_bind(connection, **DN** . username, password); `YOUR-DOMAIN`
##### server
> LDAP Server IP. `LDAP://192.168.1.123``
##### port
> LDAP Server Port number. `default: 389`
>
***
***

## Installation:
1. From your laravel instance, run this command via command prompt:

> php artisan make:module Bgtsldap

2. Copy the contents of the `Bgtsldap` module to `app/Modules/Bgtsldap` replacing the generated files.
3. Open `app/Console/Kernel.php` and add this to the `$commands` array

> \App\Modules\Bgtsldap\Console\Commands\Bgtsldap::class,

4. From the command prompt, run:

> `php artisan bgtsldap --help` to see if the module is properly placed

5. Finally, install the module:

> `php artisan bgtsldap --install=true` to migrate and seed the tables, and also publish the public files.

***
***

## Post Installation:
1. Replace the `model` of the `'user'` provider inside `config/auth.php`
> `'model' => App\Modules\Bgtsldap\Models\BgtsldapUser::class,`
2. Go to your main angular js file. `public/Modules/default/js/default-main.min.js`
3. Include 'bgtsldap' as a dependency of the app.
> `angular.module('bgts',['defaultnavigator','bgtsldap'])`
4. Go to the `bgtsldap_users` table and modify the value of the account **except the password**. The password value is just used to make sure the Auth service provider will work.
5. Inside any view, include any of the following tags:

#### Login Form
`<bgts-ldaplogin></bgts-ldaplogin>`

#### Logout Modal
`<bgts-ldaplogout></bgts-ldaplogout>`

#### Application's User Registration Form
`<bgts-ldapregister></bgts-ldapregister>`
> Only admins can view this.
`yourdatabase.bgtsldap_users.admin = 1`

##### To show modals as popup:
`<a ui-sref='bgtsldap-loginform'>Login</a>`

`<a ui-sref='bgtsldap-logoutform'>Logout</a>`

`<a ui-sref='bgtsldap-registerform'>Register</a>`

===

## GENERATED OBJECTS:
> The "bgtsldapUser" will be created after a successful login.
> You may refer to the object by using:

### Server:
> Use the default `Auth::user()` object from Laravel.

### Client:
1. `$rootScope.bgtsldapUser`
2. A Cookie named `bgtsldapUser` - This should always be identical with the Server's user, essential for SPA application.
3. AngularJS `$cookies` `$cookies.getObject('bgtsldapUser');`

====

# NOTE
> If you get any error, it is recommended that you run these via console:

1. `composer dump-autoload`

2. Re-serve the application. `php artisan serve`





