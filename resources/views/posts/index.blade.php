<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('목록리스트') }}
        </h2>
    </x-slot>
    <div class="container m-10">
        @auth
        <a href="/posts/create" class="btn btn-primary">게시글 작성</a>
        @endauth
        <ul class="list-group mt-3">
            @foreach ($posts as $post)
            <li class="list-group-item">
                <span>
                    <a href="{{ route('posts.show', [
                        'id'=>$post->id, 'page'=>$posts->currentPage(), 'user_id'=>$post->user_id, 'url'=>$url])}}">Title: {{ $post->title }}</a>
                    {{ $post->viewers->count() }} {{ $post->viewers->count() > 0 ? Str::plural('view', $post->viewers->count()) : 'view' }}
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
</x-app-layout>
