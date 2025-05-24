<?php

namespace Modules\Contact\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'desc'          => $this->desc,
            'mobile'        => $this->mobile,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
