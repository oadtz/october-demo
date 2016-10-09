<?php namespace Radiantweb\Problog\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Cms\Classes\CmsPropertyHelper;
use Radiantweb\Problog\Models\Post as BlogPost;
use Radiantweb\Problog\Models\Category  as CategoryModel;
use Radiantweb\Problog\Models\Tag  as TagModel;
use Radiantweb\Problog\Models\Settings as ProblogSettingsModel;
use DB;
use Input;
use Redirect;
use URL;
use App;
use View;
use Request;
use BackendAuth as BackendUserModel;

class Bloglist extends ComponentBase
{
    public $posts;
    public $categoryPage;
    public $postPage;
    public $parentPage;
    public $currentPage;
    public $noPostsMessage;
    /**
     * Parameter to use for the page number
     * @var string
     */
    public $pageParam;

    public function componentDetails()
    {
        return [
            'name'        => 'radiantweb.problog::lang.components.bloglist.details.name',
            'description' => 'radiantweb.problog::lang.components.bloglist.details.description'
        ];
    }

    public function defineProperties()
    {

        return [
            'postsPerPage' => [
                'title' => 'radiantweb.problog::lang.components.bloglist.properties.postsperpage.title',
                'default' => '10',
                'type'=>'string',
                'validationPattern'=>'^[0-9]+$',
                'validationMessage'=>'radiantweb.problog::lang.components.bloglist.properties.postsperpage.validationmessage',
                'group' => 'Pagination'
            ],
            'pagination' => [
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.pagination.description',
                'title'       => 'radiantweb.problog::lang.components.bloglist.properties.pagination.title',
                'type'        => 'checkbox',
                'group' => 'Pagination'
            ],
            'filter_type' => [
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.filter_type.description',
                'title'       => 'radiantweb.problog::lang.components.bloglist.properties.filter_type.title',
                'default'     => 'none',
                'type'        => 'dropdown',
                'options'     => ['none'=>'none','category'=>'Category','tag'=>'Tag','author'=>'Author'],
                'group'=>'Filters'
            ],
            'filter_value' => [
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.filter_value.description',
                'title'       => 'radiantweb.problog::lang.components.bloglist.properties.filter_value.title',
                'type'=>'string',
                'default'     => '',
                'group'=>'Filters'
            ],
            'parent' => [
                'title' => 'radiantweb.problog::lang.components.bloglist.properties.parent.title',
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.parent.description',
                'type'=>'dropdown',
                'default' => '',
                'group'=>'Filters'
            ],
            'searchpage' => [
                'title' => 'radiantweb.problog::lang.components.categories.properties.categorypage.title',
                'description' => 'radiantweb.problog::lang.components.categories.properties.categorypage.description',
                'type'=>'dropdown',
                'default' => 'blog',
                'group'=>'Rendering'
            ],
            'render' => [
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.render.description',
                'title'       => 'radiantweb.problog::lang.components.bloglist.properties.render.title',
                'default'     => 'none',
                'type'        => 'dropdown',
                'options'     => ['parent'=>'The Posts Parent','settings'=>'Default Setting','specific'=>'Specific Page'],
                'group'=>'Rendering'
            ],
            'specific' => [
                'title' => 'radiantweb.problog::lang.components.bloglist.properties.specific.title',
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.specific.description',
                'type'=>'dropdown',
                'default' => '',
                'depends' => ['render'],
                'placeholder' => 'Select a Page',
                'group'=>'Rendering'
            ],
            'enable_rss' => [
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.enable_rss.description',
                'title'       => 'radiantweb.problog::lang.components.bloglist.properties.enable_rss.title',
                'type'        => 'checkbox',
                'group' => 'Rss'
            ],
            'rss_title' => [
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.rss_title.description',
                'title'       => 'radiantweb.problog::lang.components.bloglist.properties.rss_title.title',
                'type'=>'string',
                'default'     => '',
                'group' => 'Rss'
            ],
            'rss_description' => [
                'description' => 'radiantweb.problog::lang.components.bloglist.properties.rss_description.description',
                'title'       => 'radiantweb.problog::lang.components.bloglist.properties.rss_description.title',
                'type'=>'string',
                'default'     => '',
                'group' => 'Rss'
            ],
        ];
    }


    public function getSearchpageOptions()
    {
        $ParentOptions = array(''=>'-- chose one --');
        $pages = Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');

        $ParentOptions = array_merge($ParentOptions, $pages);

        //\Log::info($ParentOptions);
        return $ParentOptions;
    }

    public function getParentOptions()
    {
        $ParentOptions = array(''=>'-- chose one --');
        $pages = Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');

        $ParentOptions = array_merge($ParentOptions, $pages);

        //\Log::info($ParentOptions);
        return $ParentOptions;
    }


    public function getSpecificOptions()
    {
        $renderType = Request::input('render'); // Load the country property value from POST

        $pages = Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');

        $Options = [
            'none' => [],
            'settings' => [],
            'parent' => [],
            'specific' => $pages,
        ];

        return $Options[$renderType];
    }

    public function getCategories(){
        return CategoryModel::get();
    }

    public function getTags(){
        return TagModel::get();
    }

    public function onRun()
    {
        $this->parentPage = $this->page['parent'] = $this->property('parent')?$this->property('parent'):null;
        $this->page['rss_feed'] = Request::url().'?feed=rss';
        $this->page['enable_rss'] = $this->property('enable_rss');

        $settings = ProblogSettingsModel::instance();
        $this->blogParent = $this->page['blogParent'] = $settings->get('blogPost');
        $this->searchpage = $this->page['searchpage'] = $this->property('searchpage');
        $this->blogPosts = $this->page['blogPosts'] = $this->loadPosts();
        $this->page['pagination'] = $this->property('pagination');
        $this->pageParam = $this->page['pageParam'];

        $request = new Input;
        if($request->get('feed'))
            return response()->view('radiantweb.problog::rss.feed', [
                    'rss_title'=>$this->property('rss_title'),
                    'rss_description'=>$this->property('rss_title'),
                    'rss_page'=>  Request::url(),
                    'posts' =>$this->page['blogPosts'],
                    'page'=>$this->page['blogPost']
                ])->header('Content-Type', 'text/xml');


        $this->addCss('/plugins/radiantweb/problog/assets/css/blog_list.css');
    }

    public function postRender($parent)
    {
        if( $this->property('render') == 'specific' ){
            return $this->property('specific');
        }elseif( $this->property('render') == 'settings' ){
            $settings = ProblogSettingsModel::instance();
            return $settings->get('blogPost');
        }else{
            return $parent;
        }
    }

    protected function loadPosts()
    {
        //\Log::info($this->parentPage);
        if($this->parentPage != ''){
            $parent = $this->parentPage;
            $BlogPosts = BlogPost::where('parent',$parent);
        }else{
            $BlogPosts = new BlogPost;
        }

        $BlogPosts = $BlogPosts->isPublished();

        /*
         * Preset Fitlers
         * First we cycle through all possible preset filtering
         * @type - category,tag,author,date-time
         */
        if ($this->property('filter_type') == 'category'){
            $category_name = $this->property('filter_value');
            $category = CategoryModel::whereRaw("LOWER(name) = '$category_name'")->first();
            if($category){
                $catID = $category->id;
            }else{
                $catID = '#';
            }
            $BlogPosts->filterByCategory($catID);
        }

        if ($this->property('filter_type') == 'tag'){
            $tag = TagModel::where('name', '=', $this->property('filter_value'))->first();
            return $tag->posts()->paginate($this->property('postsPerPage'));
        }

        if ($this->property('filter_type') == 'author'){
            $author = BackendUserModel::findUserByLogin($this->property('filter_value'));
            if($author){
                $author_id = $author->id;
            }else{
                $author_id = '#';
            }
            $BlogPosts->filterByAuthor($author_id);
        }

        /*
         * Filter Request
         * Next we cycle through all possible request filters
         * @type - category,tag,author,canonical
         * (canonical requires additional different page vars /:year?/:month?/)
         */

        if($this->param('filter')){

            if($this->param('filter')!=='category' && !$this->param('slug')){
                $slug = $this->param('filter');
                $type = 'category';
            }else{
                $type = $this->param('filter');
                $slug = $this->param('slug');
            }

            $slug = $slug;
            $slug = strtolower($slug);
            $slug = str_replace('-',' ',$slug);
            $slug = str_replace('%20',' ',$slug);

            if($type == 'category'){
                $this->page['blogCurrentCategorySlug'] = $slug;
                $category = CategoryModel::whereRaw("LOWER(name) = '$slug'")->first();
                if($category){
                    $catID = $category->id;
                }else{
                    $catID = '#';
                }
                $BlogPosts->filterByCategory($catID);
            }elseif($type == 'tag'){
                $this->page['blogCurrentTagSlug'] = $slug;
                $tag = TagModel::where('name', '=', $slug)->first();
                if($tag){
                    return $tag->posts()->paginate($this->property('postsPerPage'));
                }
                return false;
            }elseif($type == 'author'){
                $author = BackendUserModel::findUserByLogin($slug);
                if($author){
                    $author_id = $author->id;
                }else{
                    $author_id = '#';
                }
                $BlogPosts->filterByAuthor($author_id);
            }elseif($type == 'search'){
                $this->page['search_slug'] = $slug;
                $BlogPosts->filterBySearch($slug);
            }elseif($type == 'cannonical'){
                $y = $this->param('year');
                $m = $this->param('month');
                $BlogPosts->filterByDate($y,$m);
            }else{
                $component = $this->addComponent('Radiantweb\Problog\Components\Post', 'proBlogPost', array(
                    'slug'=> $slug,
                ));
                $component->onRun();

                $this->render_post = $this->page['render_post'] = $slug;
                return $this->render_post;
            }


        }

        /*
         * no filters, we go get all
         */
        $posts = $BlogPosts->orderBy('published_at', 'desc')->paginate($this->property('postsPerPage'), $this->currentPage);

        //$queries = DB::getQueryLog();
        //$last_query = end($queries);
        //\Log::info($last_query);

        return $posts;
    }

    public function getNextPosts()
    {
        $this->currentPage += 1;
        $this->blogPosts = $this->page['blogPosts'] = $this->loadPosts();
        return true;
    }
}
