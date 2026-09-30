<x-guest-layout>
    <h1 class="g-title">Confirm your password</h1>
    <p class="g-sub">This is a secure area. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="g-field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" autocomplete="current-password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required autofocus>
            @error('password')<div class="g-err">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="g-btn">Confirm</button>
    </form>
</x-guest-layout>