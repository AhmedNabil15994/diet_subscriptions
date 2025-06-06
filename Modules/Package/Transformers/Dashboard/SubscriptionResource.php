<?php

namespace Modules\Package\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            "id"            => $this->id,
            "package_id"    => optional($this->package)->title,
            "user_id"       => $this->user?->name,
            "paid"          => $this->paid,
            "from_admin"    => $this->from_admin,
            "is_default"    => $this->is_default,
            "price"         => $this->price,
            "is_free"       => $this->is_free,
            "start_at"      => $this->start_at,
            "end_at"        => $this->end_at ? $this->end_at :__('package::dashboard.subscriptions.datatable.pause_permanent') ,
            "note"        => $this->note,
            "permanent_pause_days"  => $this->permanent_pause_days,
            "mobile"        => '<span dir="ltr">'.($this->address?->mobile ?? $this->user?->mobile).'</span>',
            "address"        => $this->address ? view('package::dashboard.subscriptions.components.address',['address' => $this->address])->render() : '',
            "coupon"        => optional($this->coupon)->code ?? __('package::dashboard.subscriptions.datatable.no_coupon') ,
            "is_pause"      =>  __('package::dashboard.subscriptions.datatable.'.($this->is_pause ? ($this->end_at ? 'pause_active' : 'pause_permanent') : 'pause_stoped')),
            "created_at"    => $this->created_at->format("d-m-Y H:i a"),

        ];
    }
}
