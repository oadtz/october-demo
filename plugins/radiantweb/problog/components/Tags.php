<?php namespace Radiantweb\Problog\Components;

use Cms\Classes\ComponentBase;
use Radiantweb\Problog\Models\Tag as BlogTag;
use Cms\Classes\CmsPropertyHelper;
use Cms\Classes\Page;
use Request;
use App;
use DB;

class Tags extends ComponentBase
{
    public $tags;
    public $TagPage;
    public $currentTagSlug;
    
    public function componentDetails()
    {
        return [
            'name'        => 'radiantweb.problog::lang.components.tags.details.name',
            'description' => 'radiantweb.problog::lang.components.tags.details.description'
        ];
    }

    public function defineProperties()
    {
        return [
	        'parent' => [
                'title' => 'radiantweb.problog::lang.components.tags.properties.parent.title',
                'description' => 'radiantweb.problog::lang.components.tags.properties.parent.description',
                'type'=>'dropdown',
                'default' => '',
                'group'=>'Filter'
            ],
            'TagPage' => [
                'title' => 'radiantweb.problog::lang.components.tags.properties.tagpage.title',
                'description' => 'radiantweb.problog::lang.components.tags.properties.tagpage.description',
                'type'=>'dropdown',
                'default' => '',
                'group'=>'Rendering'
            ],
        ];
    }

    public function getTagPageOptions()
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
        $this->tags = $this->page['blogTags'] = $this->loadTags();
        $this->TagPage = $this->page['blogTagPage'] = $this->property('TagPage');
    }

    protected function loadTags()
    {
        $tags = BlogTag::orderBy('name');
        
        if($this->property('parent') == ''){
            $tags->whereExists(function($query) {
                $query->select(DB::raw(1))
                ->from('radiantweb_blog_post_tags')
                ->join('radiantweb_blog_posts', 'radiantweb_blog_posts.id', '=', 'radiantweb_blog_post_tags.post_id')
                ->where('radiantweb_blog_posts.published', 1)
                ->whereRaw('radiantweb_blog_tags.id = radiantweb_blog_post_tags.tag_id');
            });
        }else{
            $tags->whereExists(function($query) {
            
                $parent = $this->property('parent');
                
                $query->select(DB::raw(1))
                ->from('radiantweb_blog_post_tags')
                ->join('radiantweb_blog_posts', 'radiantweb_blog_posts.id', '=', 'radiantweb_blog_post_tags.post_id')
                ->where('radiantweb_blog_posts.published', 1)
                ->where('radiantweb_blog_posts.parent',$parent)
                ->whereRaw('radiantweb_blog_tags.id = radiantweb_blog_post_tags.tag_id');
            });
            
        }

        return $tags->get();
    }
}