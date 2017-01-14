<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Molecule extends Model
{
	protected $fillable = array('title', 'content', 'image');

     public $timestamps = true;
}
