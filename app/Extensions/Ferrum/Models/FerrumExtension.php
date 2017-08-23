<?php namespace App\Extensions\Ferrum\Models;

use Illuminate\Database\Eloquent\Model;

class FerrumExtension extends Model
{
	public $timestamps = true;
	protected $fillable = array('id', 'formInJson', 'showHeader',
		'submitButtonText', 'applicationConfirmationText',
		'applicationsInJson', 'applicationsCloseDateTime',
		'applicationsClosedText');
}
