<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasSlugTranslation;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;

class Page extends Model
{
    use CrudModel, SoftDeletes, HasTranslations, HasSlugTranslation,ScopesTrait;

    protected $fillable = ['status', 'type', 'page_id', 'description', 'title', 'slug', 'seo_description', 'seo_keywords'];
    public $sluggable    = 'title';

    public $translatable = ['description', 'title', 'slug', 'seo_description', 'seo_keywords'];

}
