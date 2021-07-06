<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $userInfo = User::find($post->user_id);
        // 작성자 이름
        $user = $userInfo->name;
        // 현재 로그인한 사람과 작성자가 같은 사람인지 아닌지 판단
        $user_id1 = $userInfo->id;
        $user_id2 = Auth::user()->id;
        $flag = null;

        if ($user_id1 == $user_id2) $flag = true;
        else $flag = false;

        return view('posts.show', compact('post', 'page', 'user', 'flag'));
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
    public function edit(Post $id)
    {
        // 수정 폼 생성
        return view('posts.edit')->with('post', $id);
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

        if ($req->file('imageFile')) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete($imagePath);
            $post->image = $this->uploadPostImage($req);
        }
        // 게시글을 데이터베이스에서 수정
        $post->title = $req->title;
        $post->content = $req->content;
        $post->save();

        return redirect()->route('posts.show', ['id' => $id]);
    }

    // 게시글 삭제
    public function destroy($id)
    {
        // 파일 시스템에서 이미지 파일 삭제
        // 게시글을 데이터베이스에서 삭제
    }

    public function index()
    {
        // $posts = Post::orderBy('created_at', 'desc')->get();
        // $posts = Post::latest()->get();
        $posts = Post::latest()->paginate(5);

        return view('posts.index', ['posts' => $posts]);
    }
}
