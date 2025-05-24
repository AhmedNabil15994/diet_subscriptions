<?php

namespace Modules\User\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
           'mobile'        => $this->mobile,
           'active_subscriptions_count'    => $this->active_subscriptions_count ?? 0,
           'subscriped'    => $this->subscriptions()->count() ? trans('user::dashboard.users.datatable.yes') : trans('user::dashboard.users.datatable.no'),
           'image'         => url($this->image),
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
