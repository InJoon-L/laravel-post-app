<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container mt-5 mb-5">
        @include('posts.nav')

        <h2>게시글 리스트</h2>
        @auth
        <a href="/posts/create" class="btn btn-primary">게시글 작성</a>
        @endauth
        <ul class="list-group mt-3">
            @foreach ($posts as $post)
            <li class="list-group-item">
                <span>
                    <a href="{{ route('posts.show', [
                        'id'=>$post->id, 'page'=>$posts->currentPage(), 'user_id'=>$post->user_id, 'url'=>$url])}}">Title: {{ $post->title }}</a>
                    {{ $post->count }} {{ $post->count > 0 ? Str::plural('view', $post->count) : 'view' }}
                </span>
                <div>
                    content: {!! $post->content !!}
                </div>
                <span>written on {{ $post->created_at->diffForHumans() }}</span>
                <hr />
            </li>
            @endforeach
        </ul>
        <div class="mt-5">
            {{ $posts->links() }}
        </div>
    </div>
</body>
</html>
