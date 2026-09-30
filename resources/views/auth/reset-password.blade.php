<x-guest-layout>
    @php $resetEmail = old('email', request('email')); @endphp

    <h1 class="g-title">Choose a new password</h1>
    <p class="g-sub">
        Setting a new password for <strong>{{ $resetEmail }}</strong>. Pick something you have not used before.
    </p>

    @error('email')
        <div class="g-alert" style="background:#F6ECEA;border-color:var(--burg);color:var(--burg)" role="alert">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        <input type="hidden" name="email" value="{{ $resetEmail }}">

        <div class="g-field">
            <label for="password">New password</label>
            <input id="password" type="password" name="password" autocomplete="new-password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required autofocus>
            @error('password')<div class="g-err">{{ $message }}</div>@enderror
        </div>
        <div class="g-field">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
        </div>
        <button type="submit" class="g-btn">Reset password</button>
    </form>

    <a class="g-back" href="{{ route('login') }}">Back to sign in</a>
</x-guest-layout>