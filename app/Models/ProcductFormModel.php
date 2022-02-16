<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProcductFormModel extends Model
{
    use HasFactory,SoftDeletes;
	protected $table='procduct_form';
	/**
     * Get User Details
     *
     * @return mixed
     */
    public function getAddedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'added_by');
    }
	public function getApprovedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'approved_by');
    }
}
