<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CREATE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        @include('posts.nav')
      <form class="row g-3" action="{{ route('post.update', ['id' => $post->id, 'page' => $page]) }}" method="post" enctype="multipart/form-data"> {{-- 중요! enctype이 반드시 있어야 파일을 보낼수있다 --}}
        @csrf
        @method("put")

        {{-- method spoofing --}}
        {{-- <input type="hidden" name="_method" value="put"> --}}
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" placeholder="title" name="title"
          value="{{ old('title') ? old('title') : $post->title }}">
            @error('title')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
          <label for="content" class="form-label">Content</label>
          <textarea class="form-control" id="content" rows="3" placeholder="content" name="content">
              {{ old('content') ? old('content') : $post->content }}</textarea>
            @error('content')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <img class="img-thumbnail" width="20%" src="{{ $post->imagePath() }}" >
        </div>
        <div class="form-group">
            <label for="file" class="form-label">File</label>
            <input type="file" id="file" name="imageFile"><br />
            @error('imageFile')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-warning">수정</button>
        </div>
      </form>
    </div>
</body>
</html>
