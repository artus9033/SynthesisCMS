<?php

namespace App\Models\Content;

use App\Models\Content\Atom;
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
