<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SHOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container m-5">
        @include('posts.nav')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" readonly class="form-control" id="title" placeholder="title" name="title"
            value="{{ $post->title }}">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" readonly id="content" rows="3" placeholder="content" name="content">{{ $post->content }}</textarea>
        </div>
        <div class="from-group">
            <label for="imageFile">Post Image</label>
            <div class="my-6 mx-3 w-3/12">
                <img class="img-thumbnail rouded" width="20%" src="{{ $post->imagePath() }}">
            </div>
        </div>
        <div class="mb-3">
            <label>등록일</label>
            <input type="text" readonly class="form-control" value="{{ $post->created_at->diffForHumans() }}">
        </div>
        <div class="mb-3">
            <label>수정일</label>
            <input type="text" readonly class="form-control" value="{{ $post->updated_at }}">
        </div>
        <div class="mb-3">
            <label>작성자</label>
            <input type="text" readonly class="form-control" value="{{ $user }}">
        </div>
        <div class="col-12">
            @auth
            {{-- @if (auth()->user()->id == $post->user_id) --}}
            @can('update', $post)
            <a class="btn btn-warning" href="{{ route('post.edit', ['id' => $post->id, 'page' => $page]) }}" role="button">수정</a>
            <form action="{{ route('post.delete', ['id' => $post->id, 'page' => $page]) }}" method="POST">
                @csrf
                @method("delete")
                <button type="submit" class="btn btn-danger">삭제</button>
            </form>
            @endcan
            {{-- @endif --}}
            @endauth
            <a class="btn btn-primary" href="{{ route('index', ['page' => $page]) }}" role="button">뒤로가기</a>
        </div>
    </div>
</body>
</html>
