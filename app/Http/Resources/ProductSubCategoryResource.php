<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sub_category' => $this->sub_category,
            'category' => $this->getCategory,
            'vertical' => $this->getVertical,
            'form' => $this->getForm,
            'lead_id' => get_form_type($this->lead_id),
            'status' => $this->status,
            'added_by' => $this->getAddedBy,
            'approved_by' => $this->getApprovedBy,
           
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
