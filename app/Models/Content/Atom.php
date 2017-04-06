<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Atom extends Model
{
    public $timestamps = true;
	protected $fillable = array('title', 'description', 'molecule', 'image', 'hasImage');
}
