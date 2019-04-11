<?php namespace App\Extensions\Kryptonite\Models;

use Illuminate\Database\Eloquent\Model;

class KryptoniteExtension extends Model
{
    public $timestamps = false;
    protected $fillable = array('id', 'redirect_url', 'url_relative_to_server');
}
