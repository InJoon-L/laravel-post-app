<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    // 게시글 등록페이지
    public function create() {
        return view('posts.create');
    }

    // 게시글 디비에 저장
    public function store(Request $req) {
        // $req->input['title'];
        // $req->input['contents'];
        $title = $req->title;
        $content = $req->content;
        // dd($req);

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
        $posts = Post::all();

        return $posts;
    }
}
