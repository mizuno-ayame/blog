<form action="{{ route('post.store') }}" method="post">
    @csrf
    <input type="text" name="content" id="content"><br>
    <input type="hidden" name="user_id" value="1"><br>
    <button type="submit">送信</button>
</form>
