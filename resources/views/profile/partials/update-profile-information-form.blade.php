<section class="mt-5">
  <header class="mb-3">
    <h2 class="h5 text-dark">
      {{ __('Profile Information') }}
    </h2>
    <p class="text-muted">
      {{ __("Update your account's profile information and email address.") }}
    </p>
  </header>

  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
      <label for="name" class="form-label">{{ __('Name') }}</label>
      <input
        type="text"
        class="form-control"
        id="name"
        name="name"
        value="{{ old('name', $user->name) }}"
        required
        autofocus
        autocomplete="name"
      >
      @if ($errors->has('name'))
        <div class="text-danger mt-1">
          {{ $errors->first('name') }}
        </div>
      @endif
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">{{ __('Email') }}</label>
      <input
        type="email"
        class="form-control"
        id="email"
        name="email"
        value="{{ old('email', $user->email) }}"
        required
        autocomplete="username"
      >
      @if ($errors->has('email'))
        <div class="text-danger mt-1">
          {{ $errors->first('email') }}
        </div>
      @endif

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2">
          <p class="text-secondary mb-0">
            {{ __('Your email address is unverified.') }}
            <button
              type="submit"
              form="send-verification"
              class="btn btn-link p-0 align-baseline"
            >
              {{ __('Click here to re-send the verification email.') }}
            </button>
          </p>

          @if (session('status') === 'verification-link-sent')
            <div class="text-success mt-2">
              {{ __('A new verification link has been sent to your email address.') }}
            </div>
          @endif
        </div>
      @endif
    </div>

    <div class="d-flex align-items-center gap-3">
      <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

      @if (session('status') === 'profile-updated')
        <p
          class="text-success mb-0"
          x-data="{ show: true }"
          x-show="show"
          x-transition
          x-init="setTimeout(() => show = false, 2000)"
        >
          {{ __('Saved.') }}
        </p>
      @endif
    </div>
  </form>
</section>
