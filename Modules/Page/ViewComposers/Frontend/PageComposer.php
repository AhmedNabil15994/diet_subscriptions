<?php

namespace Modules\Page\ViewComposers\Frontend;

use Illuminate\View\View;
use Modules\Page\Entities\Page;


class PageComposer
{
    public $data = [];

    public function __construct()
    {
        $this->data['aboutUs'] = Page::find(setting('other', 'about_us'));
        $this->data['privacyPolicy'] = Page::find(setting('other', 'privacy_policy'));
        $this->data['terms'] = Page::find(setting('other', 'terms'));
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with($this->data);
    }
}
