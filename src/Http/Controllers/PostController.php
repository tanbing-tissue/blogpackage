<?php
/**
 *PostController
 * @author tan bing
 * @date 2021-06-03 15:08
 */
namespace Tanbing\BlogPackage\Http\Controllers;

use Tanbing\BlogPackage\Events\PostWasCreated;
use Tanbing\BlogPackage\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        // 应用我们注册的中间件
        $this->middleware('capitalize');
    }

    /**
     * 从控制器返回视图
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author tan bing
     * @date 2021-06-04 9:40
     */
    public function index()
    {
        $posts = Post::all();
        return view('blogpackage::posts.index', compact('posts'));
    }

    /**
     * 从控制器返回视图
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author tan bing
     * @date 2021-06-04 9:41
     */
    public function show()
    {
        $post = Post::findOrfail(request('post'));
        return view('blogpackage::posts.show', compact('post'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author tan bing
     * @date 2021-06-04 9:41
     */
    public function store()
    {
        // Let's assume we need to be authenticated
        // to create a new post
        if (! auth()->check()) {
            abort (403, 'Only authenticated users can create new posts.');
        }

        request()->validate([
            'title' => 'required',
            'body'  => 'required',
        ]);

        // Assume the authenticated user is the post's author
        $author = auth()->user();

        $post = $author->posts()->create([
            'title'     => request('title'),
            'body'      => request('body'),
        ]);

        // 创建事件
        event(new PostWasCreated($post));

        return redirect(route('posts.show', $post));
    }
}