<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    // 게시글 등록페이지
    public function create() {
        return view('posts.create');
    }

    // 게시글 디비에 저장
    public function store() {

    }

    // 게시글 수정
    public function edit() {

    }

}
