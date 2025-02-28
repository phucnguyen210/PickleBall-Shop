<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Category;

class CategoryComposer
{
    public function compose(View $view): void
    {
        $categories = Category::paginate(10);
        $view->with('categories', $categories);
    }
}