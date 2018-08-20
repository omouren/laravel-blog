<?php

namespace didcode\Blog;

use App\Http\Controllers\Controller;
use didcode\Blog\Models\Post;
use didcode\Blog\Models\Category;
use didcode\Blog\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('blog::admin.index', [
            'posts' => $posts,
            'categories' => Category::all(),
            'optionRssName' => Option::get('rss_name'),
            'optionRssNumber' => Option::get('rss_number')
        ]);
    }

    public function createPost()
    {
        $post = new Post();
        if ($this->request->getMethod() === 'POST') {
            return $this->savePost($post);
        }

        $categories = Category::pluck('name', 'id');

        return view('blog::admin.post', [
            'categories' => $categories,
            'post' => $post
        ]);
    }

    public function editPost(Post $post)
    {
        if ($this->request->getMethod() === 'POST') {
            return $this->savePost($post);
        }

        $categories = Category::pluck('name', 'id');

        return view('blog::admin.post', [
            'categories' => $categories,
            'post' => $post
        ]);
    }

    private function savePost(Post $post)
    {
        if ($this->request->get('published_at_date') && $this->request->get('published_at_time')) {
            $this->request->offsetSet('published_at', \DateTime::createFromFormat('Y-m-d H:i', $this->request->get('published_at_date') . ' ' . $this->request->get('published_at_time')));
        }

        $validation = Validator::make(
            $this->request->all(),
            [
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'published_at' => 'date',
                'category_id' => 'required|string',
                'chapo' => 'string',
                'content' => 'string',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        DB::beginTransaction();

        try {
            // Clean up params
            $params = [];
            foreach ($this->request->all() as $item => $value) {
                $params[$item] = $value;

                if ($value === '') {
                    $params[$item] = null;
                }
            }

            if (!$post->id) {
                $post->fill($params);
                $post->save();
            } else {
                $post->update($params);
            }

            DB::commit();

            if ($this->request->action === 'update') {
                $redirect = $this->request->url();
                $message = [
                    'message' => [
                        'text' => "Post \"{$post->id}\" successfully updated.",
                        'type' => 'success'
                    ]
                ];

                return response()->redirectTo($redirect)->with($message);
            } else {
                return response()->redirectTo('/admin/blog');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Log::error($e);

            $redirect = $this->request->url();
            $message = [
                'message' => [
                    'text' => "An error occurred.",
                    'type' => 'error'
                ]
            ];

            return response()->redirectTo($redirect)->with($message);
        }
    }

    public function deletePost(Post $post)
    {
        DB::beginTransaction();

        try {
            $post->delete();

            DB::commit();

            $message = [
                'message' => [
                    'text' => "Post \"{$post->id}\" successfully deleted.",
                    'type' => 'success'
                ]
            ];

            return response()->redirectTo('/admin/blog')->with($message);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Log::error($e);

            $message = [
                'message' => [
                    'text' => "Can't delete this post. Please retry later.",
                    'type' => 'error'
                ]
            ];

            return response()->redirectTo('/admin/blog')->with($message);
        }
    }

    public function publishPost(Post $post)
    {
        DB::beginTransaction();

        try {
            $post->published_at = new \DateTime();
            $post->save();

            DB::commit();

            $message = [
                'message' => [
                    'text' => "Post \"{$post->id}\" successfully published.",
                    'type' => 'success'
                ]
            ];

            return response()->redirectTo('/admin/blog')->with($message);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Log::error($e);

            $redirect = $this->request->url();
            $message = [
                'message' => [
                    'text' => "An error occurred.",
                    'type' => 'error'
                ]
            ];

            return response()->redirectTo($redirect)->with($message);
        }
    }
    
    public function createCategory()
    {
        $category = new Category();
        if ($this->request->getMethod() === 'POST') {
            return $this->saveCategory($category);
        }

        return view('blog::admin.category', [
            'category' => $category
        ]);
    }

    public function editCategory(Category $category)
    {
        if ($this->request->getMethod() === 'POST') {
            return $this->saveCategory($category);
        }

        return view('blog::admin.category', [
            'category' => $category
        ]);
    }

    private function saveCategory(Category $category)
    {
        $validation = Validator::make(
            $this->request->all(),
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        DB::beginTransaction();

        try {
            // Clean up params
            $params = [];
            foreach ($this->request->all() as $item => $value) {
                $params[$item] = $value;

                if ($value === '') {
                    $params[$item] = null;
                }
            }

            if (!$category->id) {
                $category->fill($params);
                $category->save();
            } else {
                $category->update($params);
            }

            DB::commit();

            if ($this->request->action === 'update') {
                $redirect = $this->request->url();
                $message = [
                    'message' => [
                        'text' => "Category \"{$category->id}\" successfully updated.",
                        'type' => 'success'
                    ]
                ];

                return response()->redirectTo($redirect)->with($message);
            } else {
                return response()->redirectTo('/admin/blog');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Log::error($e);

            $redirect = $this->request->url();
            $message = [
                'message' => [
                    'text' => "An error occurred.",
                    'type' => 'error'
                ]
            ];

            return response()->redirectTo($redirect)->with($message);
        }
    }

    public function deleteCategory(Category $category)
    {
        DB::beginTransaction();

        try {
            $category->delete();

            DB::commit();

            $message = [
                'message' => [
                    'text' => "Category \"{$category->id}\" successfully deleted.",
                    'type' => 'success'
                ]
            ];

            return response()->redirectTo('/admin/blog')->with($message);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Log::error($e);

            $message = [
                'message' => [
                    'text' => "Can't delete this category. Please retry later.",
                    'type' => 'error'
                ]
            ];

            return response()->redirectTo('/admin/blog')->with($message);
        }
    }

    public function ajax_options_save() {
        $options = array_except(Input::all(), '_token' );

        foreach ($options as $key=>$val) {
            $option = Option::firstOrCreate( ['name' => $key]);
            $option->value = $val;
            $option->save();

            $ret[] = $option;
        }

        return response()->json($ret);
    }
}