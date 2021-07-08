<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->except(['index', 'show']);
    }

    protected function uploadPostImage($req)
    {
        $name = $req->file('imageFile')->getClientOriginalName();

        // extension메소드는 업로드 된 파일의 확장자를 얻기 위한 메소드
        $extension = $req->file('imageFile')->extension();
        // spaceship.jpg
        // spaceship_123kaswlfjslk.jpg
        $nameWithoutExtension = Str::of($name)->basename('.' . $extension);
        $fileName = $nameWithoutExtension . '_' . time() . '.' . $extension;

        // storeAs 파일의 경로와 이름 지정
        $req->file('imageFile')->storeAs('public/images', $fileName);

        return $fileName;
    }

    // 게시글 등록페이지
    public function create()
    {
        return view('posts.create');
    }

    public function show(Request $req)
    {
        // $user = User::find($req->);
        $page = $req->page;
        $post = Post::find($req->id);
        $url = $req->url;

        // $user = User::find($post->user_id)->name;
        // $user = DB::table('users')
        //     ->join('posts', function ($join) {
        //         $join->on('users.id', '=', 'posts.user_id')
        //             ->where('posts.user_id', '=', $post->user_id);
        //     })->get();

        return view('posts.show', compact('post', 'page', 'url'));
    }

    // 게시글 디비에 저장
    public function store(Request $req)
    {
        // $req->input['title'];
        // $req->input['contents'];
        $req->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'imageFile' => 'image|Max:2000'
        ]);

        $title = $req->title;
        $content = $req->content;

        // DB에 저장
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        $post->user_id = Auth::user()->id;

        // 업로드 된 파일의 원래 이름
        if ($req->file('imageFile')) {
            $post->image = $this->uploadPostImage($req);
        }

        $post->save();

        // 결과 뷰를 반환
        return redirect('/posts/index');
    }

    // 게시글 수정페이지
    public function edit(Request $req, Post $id)
    {
        // 수정 폼 생성
        return view('posts.edit', ['post' => $id, 'page' => $req->page]);
    }

    // 게시글 수정
    public function update(Request $req, $id)
    {
        // validation
        $req->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'imageFile' => 'image|Max:2000'
        ]);

        $post = Post::findOrFail($id);
        // 이미지 파일 수정. 파일 시스템에서
        // Authorization. 수정 권한이 있는지 검사
        // 즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크
        // if (auth()->user()->id != $post->user_id) {
        //     abort(403);
        // }

        if ($req->user()->cannot('update', $post)) {
            abort(403);
        }

        if ($req->file('imageFile')) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
            $post->image = $this->uploadPostImage($req);
        }
        // 게시글을 데이터베이스에서 수정
        $post->title = $req->title;
        $post->content = $req->content;
        $post->save();

        return redirect()->route('posts.show', ['id' => $id, 'page' => $req->page]);
    }

    // 게시글 삭제
    public function destroy(Request $req, $id)
    {
        // 파일 시스템에서 이미지 파일 삭제
        // 게시글을 데이터베이스에서 삭제
        $post = Post::findOrFail($id);

        // Authorization. 수정 권한이 있는지 검사
        // 즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크
        // if (auth()->user()->id != $post->user_id) {
        //     abort(403);
        // }

        if ($req->user()->cannot('delete', $post)) {
            abort(403);
        }

        if ($post->image) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
        }
        $post->delete();

        return redirect()->route('index', ['page' => $req->page]);
    }

    public function index()
    {
        // $posts = Post::orderBy('created_at', 'desc')->get();
        // $posts = Post::latest()->get();
        $posts = Post::latest()->paginate(5);
        $url = 'index';

        return view('posts.index', ['posts' => $posts, 'url' => $url]);
    }

    public function myIndex()
    {
        $posts = User::find(Auth::user()->id)->posts()->latest()->paginate(5);
        // $posts = auth()->user()->posts()->latest()->paginate(5);
        $url = 'myIndex';

        return view('posts.index', ['posts' => $posts, 'url' => $url]);
    }
}
