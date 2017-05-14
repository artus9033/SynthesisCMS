<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Molecule extends Model
{
     public $timestamps = true;
	protected $fillable = array('title', 'description');

	public function getAmount(){
		return Atom::where('molecule', $this->id)->count();
	}
}
