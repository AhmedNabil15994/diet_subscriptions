<?php

namespace Modules\Package\Http\Controllers\Dashboard;


use Illuminate\Routing\Controller;
use IlluminateAgnostic\Str\Support\Carbon;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Category\Repositories\Dashboard\CategoryRepository;
use Modules\Package\Entities\PackagePrice;
use Modules\Package\Transformers\Dashboard\PackagePricesResource;
use Modules\Core\Traits\CoreHelpers;

class PackageController extends Controller
{
    use CrudDashboardController,CoreHelpers;

    use CrudDashboardController {
        CrudDashboardController::__construct as private __tConstruct;
    }

    public function __construct(public CategoryRepository $categoryRepository)
    {
        $this->__tConstruct();
    }

    public function extraData($model)
    {

        return [
            'categories' => $this->categoryRepository->mainCategories()->pluck('title', 'id'),
            'package_prices' => PackagePricesResource::collection($model->prices)->jsonSerialize(),
        ];
    }

    public function getPrices($packageId)
    {
        $model = $this->repository->findById($packageId);
        $prices = $model->prices;
        return response()->json(['html' => view('package::dashboard.subscriptions.components.prices-selector',compact('prices'))->render()]);
    }

    public function getEndAt($priceId, $startAt)
    {
        $packagePrice = PackagePrice::findOrFail($priceId);
        return response()->json(['end_at' => $this->calculateEndAt(Carbon::parse($startAt), $packagePrice->days_count)->toDateString()]);
    }
}
