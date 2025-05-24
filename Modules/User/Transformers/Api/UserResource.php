<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'name'          => $this->name,
           'email'         => $this->email,
           'mobile'        => $this->mobile,
           'image'         => url($this->image),
           'is_company'    => $this->company ? true : false,
           'company'       => $this->company ? new CompanyResource($this->company) : ''
       ];
    }
}
