<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->except(['index', 'show']);
    }

    // 게시글 등록페이지
    public function create() {
        return view('posts.create');
    }

    public function show(Request $req) {
        // $user = User::find($req->);
        $page = $req->page;
        $post = Post::find($req->id);
        $user = User::find($req->user_id)->name;
        return view('posts.show', compact('post', 'page', 'user'));
    }

    // 게시글 디비에 저장
    public function store(Request $req) {
        // $req->input['title'];
        // $req->input['contents'];
        $req->validate([
            'title' => 'required|min:3',
            'content' => 'required'
        ]);

        $title = $req->title;
        $content = $req->content;

        // DB에 저장
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        $post->user_id = Auth::user()->id;

        $post->save();

        // 결과 뷰를 반환
        return redirect('/posts/index');
    }

    // 게시글 수정
    public function edit() {

    }

    public function index() {
        // $posts = Post::orderBy('created_at', 'desc')->get();
        // $posts = Post::latest()->get();
        $posts = Post::latest()->paginate(5);

        return view('posts.index', ['posts' => $posts]);
    }
}
