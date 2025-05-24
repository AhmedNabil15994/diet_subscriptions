<?php

namespace Modules\Package\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Package\Entities\Package as Model;

class PackageRepository extends CrudRepository
{
    /**
     * Status attribute in model
     * @var array
     */

    public function __construct()
    {
        parent::__construct(Model::class);
        $this->statusAttribute = [
            "status",
            "is_free",
        ];
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $record = $this->getModel()->with(['prices'])->active()->orderBy($order, $sort)->get();
        return $record;
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        $data['price'] = 0;
        $data['subscribe_number'] = $request->has('subscribe_number_status') && $request->subscribe_number_status ? $request->subscribe_number : null;
        return $data;
    }
    public function modelCreateOrUpdate($model, $request, $is_created = true): void
    {
        $model->categories()->sync($request->categories);
    }

    /**
     * Model created call back function
     *
     * @param mixed $model
     * @param \Illuminate\Http\Request $request is Request
     * @return void
     */
    public function modelCreated($model, $request, $is_created = true): void
    {
        if($request->package_prices && count($request->package_prices)){
            foreach($request->package_prices as $priceItem){
                $priceItem['same_pricerenew_times'] = $priceItem['same_pricerenew_times'] ?? 0;
                $priceItem['max_puse_days'] = $priceItem['max_puse_days'] ?? 0;
                unset($priceItem['id']);
                unset($priceItem['action']);
                $model->prices()->create($priceItem);
            }
        }
    }

    /**
     * Model created call back function
     *
     * @param mixed $model
     * @param \Illuminate\Http\Request $request is Request
     * @return void
     */
    public function modelUpdated($model, $request): void
    {
        if($request->package_prices && count($request->package_prices)){
            $ids = [];
            foreach($request->package_prices as $priceItem){

                $priceItem['same_pricerenew_times'] = $priceItem['same_pricerenew_times'] ?? 0;
                $priceItem['max_puse_days'] = $priceItem['max_puse_days'] ?? 0;
                $id = $priceItem['id'];
                $action = $priceItem['action'];
                unset($priceItem['id']);
                unset($priceItem['action']);

                if($action == 'create'){

                    $item = $model->prices()->create($priceItem);
                    array_push($ids,$item->id);
                }else{

                    array_push($ids,$id);
                    $model->prices()->updateOrCreate(['id' => $id],$priceItem);
                }
            }

            $model->prices()->whereNotIn('id',$ids)->delete();
        }else{

            $model->prices()->delete();
        }
    }

    public function mostPopuler()
    {
        $dates = request()->has('from') && request()->has('to') ?
            [request()->get('from'),request()->get('to')] :
            [date('Y-m-d',strtotime('-5years',strtotime('now'))),date('Y-m-d')];

        return $this->getModel()->withCount(['subscriptions'=>function ($whereQuery) use ($dates){
                $whereQuery->where(function($whereQuery){
                    $whereQuery->where('is_free',1)->orWhere([
                        ['is_free',0],
                        ['paid','paid']
                    ]);
                })->where([
                    ['created_at','>=',$dates[0] . ' 00:00:00'],
                    ['created_at','<=',$dates[1] . ' 23:59:59'],
                ]);
            }])->orderBy('subscriptions_count', 'desc')->take(5)->get();
    }
}
