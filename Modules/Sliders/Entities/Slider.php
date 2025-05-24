<?php

namespace Modules\Sliders\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;
use Modules\Course\Entities\Course;
use Modules\Projects\Entities\Project;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasTranslations;
    use CrudModel;
    protected $fillable = ['title', 'order', 'link', 'status'];
    public $translatable  = ['title'];
}
