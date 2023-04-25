<form action="{{ route('post.update', ['id' => $post->id]) }}" method="post">
    @csrf
    <input type="text" name="content" id="content" value="{{ $post->content }}"><br>
    <input type="hidden" name="user_id" value="{{ $post->user_id }}"><br>
    <button type="submit">送信</button>
</form>
