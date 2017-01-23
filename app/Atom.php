<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atom extends Model
{
	protected $fillable = array('title', 'description', 'molecule', 'image', 'imageSourceType', 'hasImage');

     public $timestamps = true;
}
