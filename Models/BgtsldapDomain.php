<?php

namespace App\Modules\bgtsldap\Models;

use Illuminate\Database\Eloquent\Model;

class BgtsldapDomain extends Model
{
    protected $table    = 'bgtsldap_domains';
    protected $fillable = ['id','name','label','server','port'];
}