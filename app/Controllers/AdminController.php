<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Models\User;
use App\Libraries\Hash;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\Category;
use App\Models\Calculators;
use App\Models\Theme;
use SSP;
use \Mberecall\CI_Slugify\SlugService;
use App\Models\Post;


class AdminController extends BaseController
{
    protected $helpers = ['url','form','CIMail','CIFunctions'];
    protected $db;

    public function __construct()
    {
        require_once APPPATH.'ThirdParty/ssp.php';
        $this->db = db_connect();
    }

    public function index()
    {
        $data = [
            'pageTitle'=>'Dashboard',
        ];
        return view('backend/pages/home', $data);
    }

    public function logoutHandler(){
         CIAuth::forget();
         return redirect()->route('admin.login.form')->with('fail','You are logged out!');
    }

    public function profile(){
        $data = array(
            'pageTitle'=>'Profile'
        );
        return view('backend/pages/profile', $data);
    }

    public function updateProfilePicture(){
        $request = \Config\Services::request();
        $user_id = CIAuth::id();
        $user = new User();
        $user_info = $user->asObject()->where('id',$user_id)->first();

        $path = 'images/users/';
        $file = $request->getFile('user_profile_file');
        $old_picture = $user_info->picture;
        $new_filename = 'UIMG_'.$user_id.$file->getRandomName();

        $upload_image = \Config\Services::image()
                      ->withFile($file)
                      ->resize(450,450,true,'height')
                      ->save($path.$new_filename);

        if( $upload_image ){
            if( $old_picture != null && file_exists($path.$new_filename) ){
                unlink($path.$old_picture);
            }
            $user->where('id',$user_info->id)
                 ->set(['picture'=>$new_filename])
                 ->update();

            echo json_encode(['status'=>1,'msg'=>'Done!, your profile picture has been successfully updated.']);
        }else{
            echo json_encode(['status'=>0,'msg'=>'Something went wrong']);
        }
    }

    public function updatePersonalDetails(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $user_id = CIAuth::id();

        if( $request->isAJAX() ){
            $this->validate([
                'name'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Full name is required'
                    ]
                ],
                'username'=>[
                    'rules'=>'required|min_length[4]|is_unique[users.username,id,'.$user_id.']',
                    'errors'=>[
                        'required'=>'Username is required',
                        'min_length'=>'Username must have minimum of 4 characters',
                        'is_unique'=>'Username is already taken!'
                    ]
                ]
            ]);

            if( $validation->run() == FALSE ){
                 $errors = $validation->getErrors();
                 return json_encode(['status'=>0,'error'=>$errors]);
            }else{
                $user = new User();
                $update = $user->where('id',$user_id)
                               ->set([
                                  'name'=>$request->getVar('name'),
                                  'username'=>$request->getVar('username'),
                                  'bio'=>$request->getVar('bio'),
                               ])->update();


                if( $update ){
                    $user_info = $user->find($user_id);
                    return json_encode(['status'=>1,'user_info'=>$user_info,'msg'=>'Your personal details have been successfully updated.']);
                }else{
                    return json_encode(['status'=>0,'msg'=>'Something went wrong.']);
                }             
            }
        }
    }

    public function settings(){
        $themes = new Theme();
        $data = [
            'pageTitle'=>'Settings',
            'themes'=>$themes->asObject()->findAll()
        ];
        return view('backend/pages/settings',$data);
    }

    public function updateGeneralSettings(){
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $validation = \Config\Services::validation();

            $this->validate([
                'blog_title'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Blog title is required'
                    ]
                ],
                'blog_email'=>[
                    'rules'=>'required|valid_email',
                    'errors'=>[
                        'required'=>'Blog email is required',
                        'valid_email'=>'Invalid email address'
                    ]
                ]
            ]);

            if( $validation->run() === FALSE ){
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
                $settings = new Setting();
                $setting_id = $settings->asObject()->first()->id;
                $update = $settings->where('id',$setting_id)
                                   ->set([
                                    'blog_title'=>$request->getVar('blog_title'),
                                    'blog_email'=>$request->getVar('blog_email'),
                                    'blog_phone'=>$request->getVar('blog_phone'),
                                    'blog_meta_keywords'=>$request->getVar('blog_meta_keywords'),
                                    'blog_meta_description'=>$request->getVar('blog_meta_description')
                                   ])->update();
                if( $update ){
                    return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'General settings have been updated successfully.']);
                }else{
                    return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong.']);
                }
            }
        }
    }

    public function uploadTheme(){
        $request = \Config\Services::request();
        $db = \Config\Database::connect();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();

            $this->validate([
                'theme_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Theme name is required',
                    ]
                ],
                'theme_file' => [
                    'rules' => 'uploaded[theme_file]|ext_in[theme_file,css,less]',
                    'errors' => [
                        'uploaded' => 'Theme file is required',
                        'ext_in' => 'Please upload a .css or .less file',
                    ]
                ],
            ]);

            if ($validation->run() === FALSE) {
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $errors]);
            } else {
                $user_id = CIAuth::id();
                $path = 'themes/';
                $file = $request->getFile('theme_file');
                $filename = $file->getClientName();

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                if ($file->move($path, $filename)) {
                    $theme = new Theme();

                    $data = array(
                        'user_id' => $user_id,
                        'theme_name' => $request->getVar('theme_name'),
                        'theme_file' => $filename,
                        'active' => 1,
                    );

                    $db->table('themes')->update(['active' => 0], ['user_id' => $user_id]);
                    $save = $theme->insert($data);

                    if ($save) {
                        return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'New theme has been successfully uploaded and activated.']);
                    } else {
                        return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Something went wrong.']);
                    }
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Error on uploading theme file.']);
                }
            }
        }
    }

    public function selectTheme()
    {
        $request = \Config\Services::request();
        $db = \Config\Database::connect();
    
        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
    
            $this->validate([
                'theme' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Téma je vyžadováno',
                    ]
                ],
            ]);
    
            if ($validation->run() === FALSE) {
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $errors]);
            } else {
                $user_id = CIAuth::id();
                $theme_file = $request->getVar('theme');
    
                // Set all themes to inactive
                $db->table('themes')->update(['active' => 0], ['user_id' => $user_id]);
    
                // Set the selected theme to active
                $db->table('themes')->update(['active' => 1], ['user_id' => $user_id, 'theme_file' => $theme_file]);
    
                return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Téma bylo úspěšně změněno.']);
            }
        }
    }

    public function updateBlogLogo(){
       $request = \Config\Services::request();
       
       if( $request->isAJAX() ){
          $settings = new Setting();
          $path = 'images/blog/';
          $file = $request->getFile('blog_logo');
          $setting_data = $settings->asObject()->first();
          $old_blog_logo = $setting_data->blog_logo;
          $new_filename = 'CI4blog_logo'.$file->getRandomName();

          if( $file->move($path, $new_filename) ){
               if( $old_blog_logo != null && file_exists($path.$old_blog_logo) ){
                 unlink($path.$old_blog_logo);
               }
            $update = $settings->where('id', $setting_data->id)
                               ->set(['blog_logo'=>$new_filename])
                               ->update();

            if($update){
                return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Done!, Blog logo has been successfully updated.']);
            }else{
                return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Something went wrong on updating new logo info.']);
            }
          }else{
            return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong on uploading new logo.']);
          }
       }
    }

    public function updateBlogFavicon(){
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $settings = new Setting();
            $path = 'images/blog/';
            $file = $request->getFile('blog_favicon');
            $setting_data = $settings->asObject()->first();
            $old_blog_favicon = $setting_data->blog_favicon;
            $new_filename = 'favicon_'.$file->getRandomName();

            if( $file->move($path, $new_filename) ){
                  if( $old_blog_favicon != null && file_exists($path.$old_blog_favicon) ){
                    unlink($path.$old_blog_favicon);
                  }

                $update = $settings->where('id', $setting_data->id)
                                   ->set(['blog_favicon'=>$new_filename])
                                   ->update();
                if( $update ){
                    return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Done!, CI4Blog favicon has been successfully updated.']);
                }else{
                    return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong on updating new blog favicon.']);
                }
            }else{
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong on uploading new blog favicon file.']);
            }
        }
    }

    public function updateSocialMedia(){
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $validation = \Config\Services::validation();
            $this->validate([
                'facebook_url'=>[
                    'rules'=>'permit_empty|valid_url_strict',
                    'errors'=>[
                        'valid_url_strict'=>'Invalid facebook page URL',
                    ]
                ],
                'twitter_url'=>[
                    'rules'=>'permit_empty|valid_url_strict',
                    'errors'=>[
                        'valid_url_strict'=>'Invalid twitter URL'
                    ]
                    ],
                'instagram_url'=>[
                    'rules'=>'permit_empty|valid_url_strict',
                    'errors'=>[
                        'valid_url_strict'=>'Invalid instagram URL'
                    ]
                ],
                'youtube_url'=>[
                    'rules'=>'permit_empty|valid_url_strict',
                    'errors'=>[
                        'valid_url_strict'=>'Invalid youtube channel URL'
                    ]
                ],
                'github_url'=>[
                    'rules'=>'permit_empty|valid_url_strict',
                    'errors'=>[
                        'valid_url_strict'=>'Invalid GitHub URL'
                    ]
                ],
                'linkedin_url'=>[
                    'rules'=>'permit_empty|valid_url_strict',
                    'errors'=>[
                        'valid_url_strict'=>'Invalid linkedin URL'
                    ]
                ],
            ]);

            if( $validation->run() === FALSE ){
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
               $social_media = new SocialMedia();
               $social_media_id = $social_media->asObject()->first()->id;
               $update = $social_media->where('id', $social_media_id)
                                      ->set([
                                        'facebook_url'=>$request->getVar('facebook_url'),
                                        'twitter_url'=>$request->getVar('twitter_url'),
                                        'instagram_url'=>$request->getVar('instagram_url'),
                                        'youtube_url'=>$request->getVar('youtube_url'),
                                        'github_url'=>$request->getVar('github_url'),
                                        'linkedin_url'=>$request->getVar('linkedin_url'),
                                      ])->update();

                if( $update ){
                    return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Done!, Blog social media have been successfully updated.']);
                }else{
                    return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong on updating blog social media.']);
                }
            }
        }
    }

    public function updateCalculators(){
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $validation = \Config\Services::validation();
            $this->validate([
                'mortgage'=>[
                    'rules'=>'required'
                ],
                'rent'=>[
                    'rules'=>'required'
                ],
                'invest'=>[
                    'rules'=>'required'
                ],
            ]);

            if( $validation->run() === FALSE ){
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
               $calculators = new Calculators();
               $calculators_id = $calculators->asObject()->first()->id;
               $update = $calculators->where('id', $calculators_id)
                                      ->set([
                                        'mortgage'=>$request->getVar('mortgage'),
                                        'rent'=>$request->getVar('rent'),
                                        'invest'=>$request->getVar('invest'),
                                      ])->update();

                if( $update ){
                    return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Done!, Blog social media have been successfully updated.']);
                }else{
                    return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong on updating blog social media.']);
                }
            }
        }
    }

    public function categories(){
        $data = [
            'pageTitle'=>'Categories'
        ];
        return view('backend/pages/categories', $data);
    }

    public function addCategory(){
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $validation = \Config\Services::validation();

            $this->validate([
                'category_name'=>[
                    'rules'=>'required|is_unique[categories.name]',
                    'errors'=>[
                        'required'=>'Category name is required',
                        'is_unique'=>'Category name is already exists'
                    ]
                ]
            ]);

            if( $validation->run() === FALSE ){
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
                // return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Validated..']);
                $category = new Category();
                $save = $category->save(['name'=>$request->getVar('category_name')]);

                if( $save ){
                    return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'New category has been successfully added.']);
                }else{
                    return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong.']);
                }
            }
        }
    }

    public function getCategories(){
        //DB Details
        $dbDetails = array(
            "host"=>$this->db->hostname,
            "user"=>$this->db->username,
            "pass"=>$this->db->password,
            "db"=>$this->db->database
        );

        $table = "categories";
        $primaryKey = "id";
        $columns = array(
            array(
                "db"=>"id",
                "dt"=>0
            ),
            array(
                "db"=>"name",
                "dt"=>1
            ),
            array(
                "db"=>"id",
                "dt"=>2,
                "formatter"=>function($d, $row){
                    return "<div class='btn-group'>
                        <button class='btn btn-sm btn-link p-0 mx-1 editCategoryBtn' data-id='".$row['id']."'>Edit</button>
                        <button class='btn btn-sm btn-link p-0 mx-1 deleteCategoryBtn' data-id='".$row['id']."'>Delete</button>
                    </div>";
                }
            ),
            array(
                "db"=>"ordering",
                "dt"=>3
            ),
        );

        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function getCategory()
    {
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $id = $request->getVar('category_id');
            $category = new Category();
            $category_data = $category->find($id);
            return $this->response->setJSON(['data'=>$category_data]);
        }
    }

    public function updateCategory()
    {
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $id = $request->getVar('category_id');
            $validation = \Config\Services::validation();

            $this->validate([
                'category_name'=>[
                    'rules'=>'required|is_unique[categories.name,id,'.$id.']',
                    'errors'=>[
                        'required'=>'Category name is required',
                        'is_unique'=>'Category name is already exists'
                    ]
                ]
            ]);

            if( $validation->run() === FALSE ){
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
                // return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Validated..']);
                $category = new Category();
                $update = $category->where('id',$id)
                                   ->set(['name'=>$request->getVar('category_name')])
                                   ->update();

                if( $update ){
                    return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Category has been successfully update.']);
                }else{
                    return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong.']);
                }
            }
        }
    }

    public function deleteCategory()
    {
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $id = $request->getVar('category_id');
            $category = new Category();

                //Delete category
                $delete = $category->where('id',$id)->delete();
                if( $delete ){
                    return $this->response->setJSON(['status'=>1,'msg'=>'Category has been successfully deleted.']);
                }else{
                    return $this->response->setJSON(['status'=>0,'msg'=>'Something went wrong.']);
                }
            }
    }

    public function reorderCategories()
    {
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $positions = $request->getVar('positions');
            $category = new Category();

            foreach($positions as $position){
                $index = $position[0];
                $newPosition = $position[1];
                $category->where('id',$index)
                         ->set(['ordering'=>$newPosition])
                         ->update();
            }
            return $this->response->setJSON(['status'=>1,'msg'=>'Categories ordering has been successfully updated.']);
        }
    }

    public function getParentCategories()
    {
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $id = $request->getVar('parent_category_id');
            $options = '<option value="0">Uncategorized</option>';
            $category = new Category();
            $parent_categories = $category->findAll();

            if( count($parent_categories) ){
                $added_options = '';
                foreach($parent_categories as $parent_category){
                    $isSelected = $parent_category['id'] == $id ? 'selected' : '';
                    $added_options.='<option value="'.$parent_category['id'].'" '.$isSelected.'>'.$parent_category['name'].'</option>';
                }
                $options = $options.$added_options;
                return $this->response->setJSON(['status'=>1,'data'=>$options]);
            }else{
                return $this->response->setJSON(['status'=>1,'data'=>$options]);
            }
        }
    }

    public function addPost()
    {
        $category = new Category();
        $data = [
            'pageTitle'=>'Add new post',
            'categories'=>$category->asObject()->findAll()
        ];
        return view('backend/pages/new-post',$data);
    }
    public function createPost()
    {
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $validation = \Config\Services::validation();

            $this->validate([
                'title'=>[
                    'rules'=>'required|is_unique[posts.title]',
                    'errors'=>[
                        'required'=>'Post title is required',
                        'is_unique'=>'This post title is already exists',
                    ]
                ],
                
                'featured_image'=>[
                    'rules'=>'uploaded[featured_image]|is_image[featured_image]|max_size[featured_image,2048]',
                    'errors'=>[
                        'uploaded'=>'Featured image is required',
                        'is_image'=>'Select an image file type',
                        'max_size'=>'Select image that not excess 2MB is size'
                    ]
                ],
            ]);

            if( $validation->run() === FALSE ){
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
                // return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Validated.']);
                $user_id = CIAuth::id();
                $path = 'images/posts/';
                $file = $request->getFile('featured_image');
                // $filename = $file->getClientName();
                $filename = 'pimg_'.time().$file->getClientName();

                //Make post featured images folder is not exists
                if( !is_dir($path) ){ mkdir($path,0777,true); }

                //Uploade featured image
                if( $file->move($path,$filename) ){
                    //Create thumb image
                    \Config\Services::image()
                        ->withFile($path.$filename)
                        ->fit(150, 150, 'center')
                        ->save($path.'thumb_'.$filename);

                    //Create resized image
                    \Config\Services::image()
                        ->withFile($path.$filename)
                        ->resize(450, 300, true, 'width')
                        ->save($path.'resized_'.$filename);

                    //Save new post details

                    $post = new Post();

                    $title = $request->getVar('title');
                    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
                    $slug = SlugService::model(Post::class)->make($slug);

                    $data = array(
                        'author_id'=>$user_id,
                        'category_id'=>$request->getVar('category'),
                        'title'=>$title,
                        'slug'=>$slug,
                        'content'=>$request->getVar('content'),
                        'featured_image'=>$filename,
                        'tags'=>$request->getVar('tags'),
                        'meta_keywords'=>$request->getVar('meta_keywords'),
                        'meta_description'=>$request->getVar('meta_description'),
                        'visibility'=>$request->getVar('visibility'),
                    );
                    $save = $post->insert($data);
                    $last_id = $post->getInsertID();

                    if( $save ){
                        return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'New blog post has been successfully created.']);
                    }else{
                        return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong.']);
                    }
                }else{
                    return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Error on uploading featured image.']);
                }
            }
        }
    }

    public function allPosts()
    {
        $data = [
            'pageTitle'=>'All posts'
        ];
        return view('backend/pages/all-posts',$data);
    }

    public function getPosts()
    {
        //DB Details
        $dbDetails = array(
            "host"=>$this->db->hostname,
            "user"=>$this->db->username,
            "pass"=>$this->db->password,
            "db"=>$this->db->database
        );
        $table = "posts";
        $primaryKey = "id";
        $columns = array(
            array(
                "db"=>"id",
                "dt"=>0
            ),
            array(
                "db"=>"id",
                "dt"=>1,
                "formatter"=>function($d, $row){
                    $post = new Post();
                    $image = $post->asObject()->find($row['id'])->featured_image;
                    return "<img src='/images/posts/thumb_$image' class='img-thumbnail' style='max-width:70px'>";
                }
            ),
            array(
                "db"=>"title",
                "dt"=>2
            ),
            array(
                "db"=>"id",
                "dt"=>3,
                "formatter"=>function($d, $row){
                    $post = new Post();
                    $category_id = $post->asObject()->find($row['id'])->category_id;
                    $category = new Category();
                    //$category_name = $category->asObject()->find($category_id)->name;
                    //return $category_name;

                    $categoryObject = $category->asObject()->find($category_id);

                    if ($categoryObject !== null) {
                        return $categoryObject->name;
                    } else {
                        // Handle the case where the category is not found
                        return 'Category Not Found';
                    }
                }
            ),
            array(
                "db"=>"id",
                "dt"=>4,
                "formatter"=>function($d, $row){
                    $post = new Post();
                    $visibility = $post->asObject()->find($row['id'])->visibility;
                    return $visibility == 1 ? 'Public' : 'Private';
                }
            ),
            array(
                "db"=>"id",
                "dt"=>5,
                "formatter"=>function($d, $row){
                    return "<div class='btn-group'>
                       <a href='".route_to('edit-post',$row['id'])."' class='btn btn-sm btn-link p-0 mx-1'>Edit</a>
                       <button class='btn btn-sm btn-link p-0 mx-1 deletePostBtn' data-id='".$row['id']."'>Delete</button>
                    </div>";
                }
            )
        );
        return json_encode(
            SSP::simple($_GET,$dbDetails,$table,$primaryKey,$columns)
        );
    }

    public function editPost($id)
    {
        $category = new Category();
        $post = new Post();
        $data = [
            'pageTitle'=>'Edit post',
            'categories'=>$category->asObject()->findAll(),
            'post'=>$post->asObject()->find($id)
        ];
        return view('backend/pages/edit-post',$data);
    }
    public function updatePost()
    {
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $validation = \Config\Services::validation();
            $post_id = $request->getVar('post_id');
            $user_id = CIAuth::id();
            $post = new Post();

            if( isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name']) ){
                $this->validate([
                    'title'=>[
                        'rules'=>'required|is_unique[posts.title,id,'.$post_id.']',
                        'errors'=>[
                            'required'=>'Post title is required',
                            'is_unique'=>'This post title is already exists'
                        ]
                    ],
                    'content'=>[
                        'rules'=>'required|min_length[20]',
                        'errors'=>[
                            'required'=>'Post content is required',
                            'min_length'=>'Post content must have atleast 20 characters'
                        ]
                    ],
                    'featured_image'=>[
                        'rules'=>'uploaded[featured_image]|is_image[featured_image]|max_size[featured_image,2048]',
                        'errors'=>[
                            'uploaded'=>'A valid featured image is required',
                            'is_image'=>'Select image file type',
                            'max_size'=>'Selected image is too big. Maximum size is 2MB'
                        ]
                    ]
                ]);
            }else{
                $this->validate([
                    'title'=>[
                        'rules'=>'required|is_unique[posts.title,id,'.$post_id.']',
                        'errors'=>[
                            'required'=>'Post title is required',
                            'is_unique'=>'This post title is already exists'
                        ]
                    ],
                    'content'=>[
                        'rules'=>'required|min_length[20]',
                        'errors'=>[
                            'required'=>'Post content is required',
                            'min_length'=>'Post content must have atleast 20 characters'
                        ]
                    ],
                ]);
            }

            if( $validation->run() === FALSE ){
                $errors = $validation->getErrors();
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
                // return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Vlidated.']);
                if( isset($_FILES['featured_image']['name']) && !empty($_FILES['featured_image']['name']) ){
                    $path = 'images/posts/';
                    $file = $request->getFile('featured_image');
                    // $filename = $file->getClientName();
                    $filename = 'pimg_'.time().$file->getClientName();
                    $old_post_featured_image = $post->asObject()->find($post_id)->featured_image;

                    //Upload featured image
                    if( $file->move($path,$filename) ){
                        //Create thumb image
                        \Config\Services::image()
                             ->withFile($path.$filename)
                             ->fit(150, 150, 'center')
                             ->save($path.'thumb_'.$filename);

                        //Create resized image
                        \Config\Services::image()
                            ->withFile($path.$filename)
                            ->resize(450, 300, true, 'width')
                            ->save($path.'resized_'.$filename);

                        //Delete old images
                        if( $old_post_featured_image != null && file_exists($path.$old_post_featured_image) ){
                            unlink($path.$old_post_featured_image);
                        }

                        if( file_exists($path.'thumb_'.$old_post_featured_image) ){
                            unlink($path.'thumb_'.$old_post_featured_image);
                        }

                        if( file_exists($path.'resized_'.$old_post_featured_image) ){
                            unlink($path.'resized_'.$old_post_featured_image);
                        }

                        //Update post details in DB
                        $title = $request->getVar('title');
                        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
                        $slug = SlugService::model(Post::class)->make($slug);

                        $data = array(
                            'author_id'=>$user_id,
                            'category_id'=>$request->getVar('category'),
                            'title'=>$title,
                            'slug'=>$slug,
                            'content'=>$request->getVar('content'),
                            'featured_image'=>$filename,
                            'tags'=>$request->getVar('tags'),
                            'meta_keywords'=>$request->getVar('meta_keywords'),
                            'meta_description'=>$request->getVar('meta_description'),
                            'visibility'=>$request->getVar('visibility'),
                        );
                        $update = $post->update($post_id,$data);
                        if($update){
                            return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Blog post has been successfully updated.']);
                        }else{
                            return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong.']);
                        }
                    }else{
                        return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Error on uploading featured image.']);
                    }
                }else{
                    //Update post details
                    $title = $request->getVar('title');
                    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
                    $slug = SlugService::model(Post::class)->make($slug);

                    $data = array(
                        'author_id'=>$user_id,
                        'category_id'=>$request->getVar('category'),
                        'title'=>$title,
                        'slug'=>$slug,
                        'content'=>$request->getVar('content'),
                        'tags'=>$request->getVar('tags'),
                        'meta_keywords'=>$request->getVar('meta_keywords'),
                        'meta_description'=>$request->getVar('meta_description'),
                        'visibility'=>$request->getVar('visibility'),
                    );
                    $update = $post->update($post_id,$data);
                    if($update){
                        return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Blog post has been successfully updated.']);
                    }else{
                        return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong.']);
                    }
                }
            }
        }
    }

    public function deletePost()
    {
        $request = \Config\Services::request();

        if( $request->isAJAX() ){
            $path = 'images/posts/';
            $post_id = $request->getVar('post_id');
            $post = new Post();
            $postInfo = $post->asObject()->find($post_id);
            $post_featured_image = $postInfo->featured_image;

            //Delete post images
            if( $post_featured_image != null && file_exists($path.$post_featured_image) ){
                unlink($path.$post_featured_image);
            }

            if( file_exists($path.'thumb_'.$post_featured_image) ){
                unlink($path.'thumb_'.$post_featured_image);
            }

            if( file_exists($path.'resized_'.$post_featured_image) ){
                unlink($path.'resized_'.$post_featured_image);
            }

            //Delete post in DB
            $delete = $post->delete($post_id);

            if($delete){
                return $this->response->setJSON(['status'=>1,'token'=>csrf_hash(),'msg'=>'Good!. Post has been successfully deleted.']);
            }else{
                return $this->response->setJSON(['status'=>0,'token'=>csrf_hash(),'msg'=>'Something went wrong.']);
            }
        }
    }
  
}
