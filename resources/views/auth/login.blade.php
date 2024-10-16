<form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
        <label>Email</label>
        <input type="email" name="email" value="clark@strauss.com">
    </div>
    <div>
        <label>Password</label>
        <input type="text" name="password" value="Strauss@08">
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
    @error('email')
        <span>{{ $message }}</span>
    @enderror
</form>
