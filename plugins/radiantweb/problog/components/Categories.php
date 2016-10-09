<?php namespace Radiantweb\Problog\Components;

use Cms\Classes\ComponentBase;
use Radiantweb\Problog\Models\Category as BlogCategory;
use Cms\Classes\CmsPropertyHelper;
use Cms\Classes\Page;
use Request;
use App;
use DB;

class Categories extends ComponentBase
{
    public $categories;
    public $categoryPage;
    public $currentCategorySlug;
    
    public function componentDetails()
    {
        return [
            'name'        => 'radiantweb.problog::lang.components.categories.details.name',
            'description' => 'radiantweb.problog::lang.components.categories.details.description'
        ];
    }

    public function defineProperties()
    {
        return [
	        'parent' => [
                'title' => 'radiantweb.problog::lang.components.categories.properties.parent.title',
                'description' => 'radiantweb.problog::lang.components.categories.properties.parent.description',
                'type'=>'dropdown',
                'default' => '',
                'group'=>'Filter'
            ],
            'categoryPage' => [
                'title' => 'radiantweb.problog::lang.components.categories.properties.categorypage.title',
                'description' => 'radiantweb.problog::lang.components.categories.properties.categorypage.description',
                'type'=>'dropdown',
                'default' => '',
                'group'=>'Rendering'
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    
    public function getParentOptions()
    {
        $ParentOptions = array(''=>'-- chose one --');
        $pages = Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
        
        $ParentOptions = array_merge($ParentOptions, $pages);
        
        //\Log::info($ParentOptions);
        return $ParentOptions;
    }

    public function onRun()
    {

        $this->categories = $this->page['blogCategories'] = $this->loadCategories();
        $this->categoryPage = $this->page['blogCategoryPage'] = $this->property('categoryPage');

    }

    protected function loadCategories()
    {
        $categories = BlogCategory::orderBy('name');
        
        if($this->property('parent') == ''){
            $categories->whereExists(function($query) {
                $query->select(DB::raw(1))
                ->from('radiantweb_blog_posts')
                ->whereNotNull('radiantweb_blog_posts.published')
                ->where('published', 1)
                ->whereRaw('radiantweb_blog_categories.id = radiantweb_blog_posts.categories_id');
            });
        }else{
            $categories->whereExists(function($query) {

                $parent = $this->property('parent');
                
                $query->select(DB::raw(1))
                ->from('radiantweb_blog_posts')
                ->whereNotNull('radiantweb_blog_posts.published')
                ->where('parent',$parent)
                ->where('published', 1)
                ->whereRaw('radiantweb_blog_categories.id = radiantweb_blog_posts.categories_id');
            });
        }

        return $categories->get();
    }
}