<?php

namespace Modules\Package\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PackagePricesResource extends JsonResource
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
            "id"    => $this->id,
            "key" => "update_{$this->id}",
            "action" => 'update',
            "price" => $this->price,
            "offer_percentage" => $this->offer_percentage,
            "start_offer_date" => $this->start_offer_date,
            "end_offer_date" => $this->end_offer_date,
            "same_pricerenew_times" => $this->same_pricerenew_times,
            "max_puse_days" => $this->max_puse_days,
            "days_count" => $this->days_count,
            "subscribe_number" => $this->subscribe_number,
            "subscribe_number_status" => $this->subscribe_number ? true : false,
            "subscribe_start_date" => $this->subscribe_start_date ,
            "subscribe_duration_desc" => [
                'en' => $this->getTranslation('subscribe_duration_desc','en'),
                'ar' => $this->getTranslation('subscribe_duration_desc','ar'),
            ],
        ];
    }
}
