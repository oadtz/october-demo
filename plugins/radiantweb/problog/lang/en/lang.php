<?php

return [
    'plugin' => [
        'name' => 'ProBlog',
        'description' => 'A powerful blogging platform.',
    ],
    'sidemenu' => [
        'posts' => 'Posts',
        'categories' => 'Categories',
        'tags' => 'Tags'
    ],
    'settings' => [
        'description' => 'Manage ProBlog Settings.',
        'tabs' => [
            'render' => 'Render Page',
            'editor' => 'Editor',
            'social' => 'Social',
            'api' => 'API Settings',
            'authentication' => 'Authorize'
        ],
        'labels' => [
            'render' => 'Choose a default page that will render your ProBlog Posts',
            'editor' => 'Enable Markdown Editor / Preview',
            'parent' => 'Choose a default Blog Parent Page.',
            'sharethis' => 'ShareThis API Key',
            'facebook' => 'Enable Facebook Sharing?',
            'twitter' => 'Enable Twitter Sharing?',
            'google' => 'Enable Google Sharing?',
            'embedly' => 'Embed.ly API Key',
            'alchemy' => 'Alchemy API Key',
            'twitterauth' => 'Twitter Authentication'
        ]
    ],
    'backend'=>[
        'form' => [
            'cancel'=>'Cancel',
            'saveclose'=>'Save and Close',
            'or'=>'or',
            'create'=>'Create',
            'createclose'=>'Create and Close',
            'save'=>'Save',
            'update'=>'Update',
            'updateclose'=>'Update and Close'
        ],
        'toolbar' => [
            'duplicate'=>'Duplicate',
            'delete'=>'Delete'
        ],
        'post'=>[
            'form'=>[
                'title'=>'Posts',
                'confirmdelete'=>'Do you really want to delete this Post?',
                'back'=>'Return to Post List'
            ],
            'toolbar'=>[
                'create'=>'Create Post',
                'edit'=>'Edit Post',
                'toolbarnew'=>'New Post',
            ],
            'columns' => [
                'title' => 'Title',
                'author' => 'Author',
                'parent' => 'Parent',
                'category' => 'Category',
                'publishedat' => 'Publish Date',
                'published' => 'Published'
            ],
            'fields' => [
                'tab' => [
                    'general' => 'General',
                    'content' => 'Content',
                    'metas' => 'Metas',
                    'optimizer' => 'SEO Optimizer',
                    'social' => 'Social',
                    'publish' => 'Publish',
                    'category' => 'Category',
                    'tags' => 'Tags'
                ],
                'title'=>'Title',
                'slug'=>'slug',
                'excerpt'=>'Excerpt',
                'featured'=>'Featured Images',
                'metatitle'=>'Meta Title',
                'metadescription'=>'Meta Description',
                'metakeyword'=>'Meta Keywords',
                'optimize'=>'Optimize',
                'twitter'=>'Post To Twitter',
                'parent'=>'Parent Blog Page',
                'user' => 'Post Author',
                'publishedon'=>'Published on',
                'published'=>'Published',
                'category_note'=>'Select a Category this blog post belongs to',
                'tag_note'=>'Add tags to relate your entry to other posts',
            ],
        ],
        'category' => [
            'form'=>[
                'title'=>'Categories',
                'back'=>'Return to Category List',
                'confirmdelete'=>'Are you sure you want to delete this Category?'
            ],
            'toolbar'=>[
                'create'=>'Create Category',
                'edit'=>'Edit Category',
                'toolbarnew'=>'New Category'
            ],
            'columns' => [
                'name' => 'Name',
                'slug' => 'Slug'
            ],
            'fields' => [
                'name' => 'Name',
                'slug' => 'Slug',
                'generate' => 'Auto Generate Category Page Under Default Blog Parent?'
            ],
        ],
        'tag' => [
            'form'=>[
                'title'=>'Tags',
                'back'=>'Return to Tag List',
                'confirmdelete'=>'Are you sure you want to delete this Tag?'
            ],
            'toolbar'=>[
                'create'=>'Create Tag',
                'edit'=>'Edit Tag',
                'toolbarnew'=>'New Tag'
            ],
            'columns' => [
                'name' => 'Name',
                'slug' => 'Slug'
            ],
            'fields' => [
                'name' => 'Name',
                'slug' => 'Slug',
            ],
        ]
    ],
    'components' => [
        'archive' => [
            'details' => [
                'name' => 'Blog Archive List',
                'description' => 'Displays a blog date archive on a page.'
            ],
            'properties' => [
                'parent' => [
                    'title' => 'Filter Archive By Parent',
                    'description'=> 'Parent page to filter posts by.'
                ],
                'render' => [
                    'title' => 'Render Posts\' By',
                    'description'=> 'Chose how you would like to render posts',
                    'group' => 'Rendering'
                ],
                'specific' => [
                    'title' => 'Render Page',
                    'description'=> 'Page that will render posts',
                    'group' => 'Rendering'
                ],
            ]
        ],
        'bloglist' => [
            'details' => [
                'name' => 'ProBlog List',
                'description' => 'Displays a list of latest ProBlog posts on a page.'
            ],
            'properties' => [
                'postsperpage' => [
                    'title' => 'Posts per page',
                    'validationmessage'=> 'Invalid format of the posts per page value.',
                    'group' => 'Pagination'
                ],
                'filter_type' => [
                    'title' => 'Filter Type',
                    'description'=> 'Type of filter?',
                    'group' => 'Filters'
                ],
                'filter_value' => [
                    'title' => 'Filter Value',
                    'description'=> 'The filter value to search for.',
                    'group' => 'Filters'
                ],
                'pagination' => [
                    'title' => 'Pagination',
                    'description'=> 'Show Pagination?',
                    'group' => 'Pagination'
                ],
                'parent' => [
                    'title' => 'Filter By Parent Page',
                    'description'=> 'Parent page to filter posts by.',
                    'group' => 'Filters'
                ],
                'render' => [
                    'title' => 'Render Posts\' By',
                    'description'=> 'Chose how you would like to render posts',
                    'group' => 'Rendering'
                ],
                'specific' => [
                    'title' => 'Render Page',
                    'description'=> 'Page that will render posts',
                    'group' => 'Rendering'
                ],
                'enable_rss' => [
                    'title' => 'RSS Link',
                    'description'=> 'Show RSS Link?',
                    'group' => 'Rss'
                ],
                'rss_title' => [
                    'title' => 'RSS Title',
                    'description'=> 'Show RSS Title?',
                    'group' => 'Rss'
                ],
                'rss_description' => [
                    'title' => 'RSS Description',
                    'description'=> 'Show RSS Description?',
                    'group' => 'Rss'
                ]
            ],
        ],
        'categories' => [
            'details' => [
                'name' => 'Blog Category List',
                'description' => 'Displays a list of ProBlog categories on a page.'
            ],
            'properties' => [
	            'parent' => [
                    'title' => 'Filter Categories By Parent',
                    'description'=> 'Parent page to filter posts by.'
                ],
                'categorypage' => [
                    'title' => 'Blog Search Page',
                    'description'=> 'Name of your blog search page. This property is used by the default component partial.'
                ],
            ]
        ],
        'tags' => [
            'details' => [
                'name' => 'Blog Tag List',
                'description' => 'Displays a list of ProBlog tags on a page.'
            ],
            'properties' => [
	            'parent' => [
                    'title' => 'Filter Tags By Parent',
                    'description'=> 'Parent page to filter posts by.'
                ],
                'tagpage' => [
                    'title' => 'Blog Search Page',
                    'description'=> 'Name of your blog search page. This property is used by the default component partial.'
                ],
            ]
        ],
        'post' => [
            'details' => [
                'name' => 'ProBlog Post',
                'description' => 'Displays your Blog Posts on a page.'
            ],
            'properties' => [
                'slug' => [
                    'title' => 'ID parameter',
                    'description'=> 'The URL route parameter used for looking up the post by its slug.'
                ],
                'search' => [
                    'title' => 'Blog Search Page',
                    'description'=> 'Page to render tag/category search results'
                ],
            ]
        ],
    ]
];
