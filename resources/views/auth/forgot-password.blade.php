<x-guest-layout>
    <h1 class="g-title">Forgot your password?</h1>
    <p class="g-sub">Enter the email on your account and we will send you a link to choose a new one. If you signed up with Google, use Continue with Google on the sign-in page instead.</p>

    @if (session('status'))
        <div class="g-alert g-ok" role="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="g-field">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="juan@email.com" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required autofocus>
            @error('email')<div class="g-err">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="g-btn">Email reset link</button>
    </form>

    <a class="g-back" href="{{ route('login') }}">Back to sign in</a>
</x-guest-layout>