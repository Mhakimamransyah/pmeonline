<form class="ui form" method="POST" action="{{ route('login') }}">

    <h4 class="ui horizontal divider header">
        Login
    </h4>

    @csrf

    <div class="field">
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    </div>

    <div class="field">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">
    </div>

    <button type="submit" class="ui blue button right floated">
        {{ __('Login') }}
        <i class="chevron right icon"></i>
    </button>

</form>