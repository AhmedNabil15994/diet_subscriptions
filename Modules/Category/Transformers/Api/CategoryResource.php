<?php

namespace Modules\Category\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\Api\CompanyResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'image'         => url($this->image),
           'title'         => $this->translate(locale())->title,
           'companies'     => CompanyResource::collection($this->whenLoaded('companies')),
           // 'subcategories' => DefaultResource::collection($this->whenLoaded('children')),
       ];
    }
}
