<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Molecule extends Model
{
	protected $fillable = array('title', 'description');

     public $timestamps = true;

	public function getAmount(){
		//TODO: implement atoms
		$atoms = null;//Atom::where('molecule', $this->id)->cursor();
		return 0;//$atoms->count();
	}
}
