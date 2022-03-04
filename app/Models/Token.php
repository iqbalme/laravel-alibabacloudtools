<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Token extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    // protected $fillable = [
        // 'name', 'email',
    // ];
	
	protected $table = 'token';
	protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    // protected $hidden = [
        // 'password',
    // ];
}
