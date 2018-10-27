<form method="POST" action="{{ route('forums.authenticate') }}">
    @csrf
    <input type="hidden" name="forum_id" value="{{ $forum->id }}">
    <input type="password" name="password">
    <button type="submit">submit</button>
</form>
