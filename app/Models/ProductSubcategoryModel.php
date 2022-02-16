<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductSubcategoryModel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='product_subcategory';
    
    public function getCategory()
    {
        return $this->belongsTo('App\Models\ProcductCategoryModel', 'category_id', 'id');
    }
    public function getVertical()
    {
        return $this->belongsTo('App\Models\ProductVerticalModel', 'vertical_id', 'id');
    }
    public function getForm()
    {
        return $this->belongsTo('App\Models\ProcductFormModel', 'form_id', 'id');
    }

    /**
     * Get User Details
     *
     * @return mixed
     */
    public function getAddedBy()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
    }
    public function getApprovedBy()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }
}
