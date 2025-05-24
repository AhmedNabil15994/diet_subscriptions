<?php

namespace Modules\Category\Repositories\Api;

use Modules\Category\Entities\Category;

class CategoryRepository
{
    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAllCategories($request)
    {
        $categories = $this->category->where('type',1)->with([
                          'children' => function ($query) {
                              $query->active();
                          }, 'companies.categories'
                      ])->mainCategories()->active()->orderBy('id','DESC')->get();

        return $categories;
    }
}
