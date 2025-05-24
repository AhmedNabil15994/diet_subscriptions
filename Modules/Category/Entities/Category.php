<?php

namespace Modules\Category\Entities;

use Modules\Package\Entities\Subscription;
use Spatie\MediaLibrary\HasMedia;
use Modules\Package\Entities\Package;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements HasMedia
{
    use CrudModel, SoftDeletes, HasTranslations, InteractsWithMedia;

    protected $fillable = ['status', 'type', 'category_id', 'title'];
    public $translatable = ['title'];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id')->with('children');
    }

    public function packages()
    {
        return $this->morphedByMany(Package::class, 'categorized', 'categorized');
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    public function getSubscriptionsAttribute()
    {
        return Subscription::where('paid','paid')->whereHas('package', function ($query) {
                $query->whereHas('categories', function ($query) {
                    $query->where('categorized.category_id', $this->id);
                }
            );
        });
    }

    public function getToDaySubscriptionsAttribute()
    {
        return Subscription::where('paid','paid')->whereHas('package', function ($query) {
                $query->whereHas('categories', function ($query) {
                    $query->where('categorized.category_id', $this->id);
                }
            );
        })->ToDay();
    }



    public function scopeMainCategories($query)
    {
        return $query->where('category_id', '=', null);
    }
}
