<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Atom extends Model
{
	protected $fillable = array('title', 'description', 'molecule', 'image', 'imageSourceType', 'hasImage');
//TODO: add a kind of addon system contained inside an atom (with its data inside the atom model), which will show some data in atom text as raw HTML
     public $timestamps = true;
}
