<?php

namespace Modules\Category\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Category\Transformers\Api\DefaultResource;
use Modules\Category\Repositories\Api\CategoryRepository as Category;
use Modules\Apps\Http\Controllers\Api\ApiController;

class CategoryController extends ApiController
{

    function __construct(Category $categories)
    {
        $this->categories = $categories;
    }

    public function categories(Request $request)
    {
        $categories =  $this->categories->getAllCategories($request);

        return DefaultResource::collection($categories);
    }
}
