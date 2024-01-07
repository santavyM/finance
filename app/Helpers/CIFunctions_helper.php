<?php

use App\Libraries\CIAuth;
use App\Models\Category;
use App\Models\User;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\SubCategory;
use App\Models\Post;
use Carbon\Carbon;

/** GETTING LOGGED IN USER DETAILS */
if( !function_exists('get_user') ){
    function get_user(){
        if( CIAuth::check() ){
            $user = new User();
            return $user->asObject()->where('id',CIAuth::id())->first();
        }else{
            return null;
        }
    }
}

/** GETTING SETTINGS DATA */
if( !function_exists('get_settings') ){
    function get_settings(){
        $settings = new Setting();
        $settings_data = $settings->asObject()->first();

        if( !$settings_data ){
            $data = array(
                'blog_title'=>'CI4Blog',
                'blog_email'=>'info@ci4blog.test',
                'blog_phone'=>null,
                'blog_meta_keywords'=>null,
                'blog_meta_description'=>null,
                'blog_logo'=>null,
                'blog_favicon'=>null,
            );
            $settings->save($data);
            $new_settings_data = $settings->asObject()->first();
            return $new_settings_data;
        }else{
            return $settings_data;
        }
    }
}

/** GETTING SOCIAL MEDIA */
if( !function_exists('get_social_media') ){
    function get_social_media(){
        $result = null;
        $social_media = new SocialMedia();
        $social_media_data = $social_media->asObject()->first();

        if(!$social_media_data){
           $data = array(
              'facebook_url'=>null,
              'twitter_url'=>null,
              'instagram_url'=>null,
              'youtube_url'=>null,
              'github_url'=>null,
              'linkedin_url'=>null
           );
           $social_media->save($data);
           $new_social_media_data = $social_media->asObject()->first();
           $result = $new_social_media_data;
        }else{
           $result = $social_media_data;
        }
        return $result;
    }
}

/** GETTING CURRENT ROUTE NAME */
if( !function_exists('current_route_name') ){
    function current_route_name(){
        $router = \CodeIgniter\Config\Services::router();
        $route_name = $router->getMatchedRouteOptions()['as'];
        return $route_name;
    }
}

/**
 * FRONTEND FUNCTIONS
 */

 /** GETTING PARENT CATEGORIES */
if( !function_exists('get_parent_categories') ){
    function get_parent_categories(){
        $category = new Category();
        return $category->asObject()->orderBy('ordering','asc')->findAll();
    }
}

/** GET SUBCATEGORIES THROUGHT PARENT CATEGGORY ID */
if( !function_exists('get_subcategories_by_parent_category_id') ){
    function get_subcategories_by_parent_category_id($id){
        $subcategory = new SubCategory();
        return $subcategory->asObject()
                           ->orderBy('ordering','asc')
                           ->where('parent_cat',$id)
                           ->findAll();
    }
}

/** GET DEPENDENT SUBCATEGORIES */
if( !function_exists('get_dependent_subcategories') ){
    function get_dependent_subcategories(){
        $subcategory = new SubCategory();
        return $subcategory->asObject()
                           ->orderBy('ordering','asc')
                           ->where('parent_cat =',0)
                           ->findAll();
    }
}

/** Date format eg: JAN 12, 2024 */
if( !function_exists('date_formatter') ){
    function date_formatter($date){
        return Carbon::createFromFormat('Y-m-d H:i:s',$date)->isoFormat('ll');
    }
}

/** CALCULATE READING DURATION */
if( !function_exists('get_reading_time') ){
    function get_reading_time($content){
        $word_count = str_word_count(strip_tags($content));
        $word_per_minute = 200;
        $m = ceil($word_count / $word_per_minute);
        return $m <= 1 ? $m.' Min read' : $m.' Mins read';
    }
}

/** LIMIT WORDS */
if( !function_exists('limit_words') ){
    function limit_words($content = null, $limit = 20){
        $content = preg_replace("/<img[^>]+\>/i","",$content);
        return word_limiter($content,$limit);
    }
}

/** GET HOME MAIN LATEST POST */
if( !function_exists('get_home_main_latest_post') ){
    function get_home_main_latest_post(){
        $post = new Post();
        return $post->asObject()
                    ->where('visibility',1)
                    ->orderBy('created_at','desc')
                    ->first();
    }
}

/** GET 6 HOME LATEST POSTS */
if( !function_exists('get_6_home_latest_posts') ){
    function get_6_home_latest_posts(){
        $post = new Post();
        return $post->asObject()
                    ->where('visibility',1)
                    ->limit(6,1)
                    ->orderBy('created_at','desc')
                    ->get()
                    ->getResult();
    }
}

/** GET SIDEBAR RANDOM POSTS */
if( !function_exists('get_sidebar_random_posts') ){
    function get_sidebar_random_posts($max = 4){
        $post = new Post();
        return $post->asObject()
                    ->where('visibility',1)
                    ->limit($max)
                    ->orderBy('rand()')
                    ->get()
                    ->getResult();
    }
}

/** GET SIDEBAR CATEGORIES */
if( !function_exists('get_sidebar_categories') ){
    function get_sidebar_categories(){
        $subcat = new Category();
        return $subcat->asObject()
                      ->orderBy('name','asc')
                      ->findAll();
    }
}

/** COUNT POSTS BY CATEGORY ID */
if( !function_exists('posts_by_category_id') ){
    function posts_by_category_id($id){
        $post = new Post();
        $posts = $post->where('visibility',1)
                      ->where('category_id',$id)
                      ->findAll();
        return count($posts);
    }
}

/** GET SIDEBAR LATEST POSTS */
if( !function_exists('sidebar_latest_posts') ){
    function sidebar_latest_posts($except = null){
        $post = new Post();
        return $post->where('visibility',1)
                    ->where('id !=',$except)
                    ->orderBy('created_at','desc')
                    ->limit(4)
                    ->get()
                    ->getResult();
    }
}

/** GET ALL TAGS FROM POSTS TABLE */
if( !function_exists('get_tags') ){
    function get_tags(){
        $post = new Post();
        $tagsArray = [];
        $posts = $post->asObject()
                      ->where('visibility',1)
                      ->where('tags !=','')
                      ->orderBy('created_at','desc')
                      ->findAll();
        foreach( $posts as $post ){
            array_push($tagsArray,$post->tags);
        }
        $tagsList = implode(',',$tagsArray);
        return array_unique(array_map('trim',array_filter(explode(',',$tagsList),'trim')));
    }
}

/** GET TAGS BY POST ID */
if( !function_exists('get_tags_by_post_id') ){
    function get_tags_by_post_id($id){
        $post = new Post();
        $tags = $post->asObject()->find($id)->tags;
        return $tags != '' ? explode(',',$tags) : [];
    }
}

/** GET RELATED POSTS */
if( !function_exists('get_related_posts_by_post_id') ){
    function get_related_posts_by_post_id($id, $limit = 3){
        $post = new Post();
        $tags = $post->asObject()->find($id)->tags;
        $tagsArray = $tags != '' ? explode(',',$tags) : [];
        if( empty($tagsArray) ){
            $related_posts = [];
        }else{
            $post->select('*');
            $post->groupStart();
            foreach( $tagsArray as $tag ){
                $post->orLike('title',$tag)
                     ->orLike('tags',$tag);
            }
            $post->groupEnd();
            $posts = $post->asObject()
                          ->where('id !=',$id)
                          ->where('visibility',1)
                          ->limit($limit)
                          ->get()
                          ->getResult();

            $related_posts = count($posts) > 0 ? $posts : [];
        }
        return $related_posts;
    }
}

/** GET PREVIOUS POSTS */
if( !function_exists('get_previous_post') ){
    function get_previous_post($id){
        $post = new Post();
        $prev_post = $post->asObject()
                          ->where('id <',$id)
                          ->where('visibility',1)
                          ->limit(1)
                          ->orderBy('id','desc')
                          ->first();
        return !empty($prev_post) ? $prev_post : [];
    }
}

/** GET NEXT POSTS */
if( !function_exists('get_next_post') ){
    function get_next_post($id){
        $post = new Post();
        $next_post = $post->asObject()
                          ->where('id >',$id)
                          ->where('visibility',1)
                          ->limit(1)
                          ->orderBy('id','asc')
                          ->first();
        return !empty($next_post) ? $next_post : [];
    }
}