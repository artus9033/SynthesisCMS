<?php

namespace App;

use App\Atom;
use Illuminate\Database\Eloquent\Model;

class Molecule extends Model
{
	protected $fillable = array('title', 'description');

     public $timestamps = true;

	public function getAmount(){
		$atoms = Atom::where('molecule', $this->id);
		return $atoms->count();
	}
}
