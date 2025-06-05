<section class="mt-5">
  <header class="mb-3">
    <h2 class="h5 text-dark">
      {{ __('Update Password') }}
    </h2>
    <p class="text-muted">
      {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>
  </header>

  <form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
      <label for="update_password_current_password" class="form-label">
        {{ __('Current Password') }}
      </label>
      <input
        type="password"
        id="update_password_current_password"
        name="current_password"
        class="form-control"
        autocomplete="current-password"
        required
      >
      @if ($errors->updatePassword->has('current_password'))
        <div class="text-danger mt-1">
          {{ $errors->updatePassword->first('current_password') }}
        </div>
      @endif
    </div>

    <div class="mb-3">
      <label for="update_password_password" class="form-label">
        {{ __('New Password') }}
      </label>
      <input
        type="password"
        id="update_password_password"
        name="password"
        class="form-control"
        autocomplete="new-password"
        required
      >
      @if ($errors->updatePassword->has('password'))
        <div class="text-danger mt-1">
          {{ $errors->updatePassword->first('password') }}
        </div>
      @endif
    </div>

    <div class="mb-3">
      <label for="update_password_password_confirmation" class="form-label">
        {{ __('Confirm Password') }}
      </label>
      <input
        type="password"
        id="update_password_password_confirmation"
        name="password_confirmation"
        class="form-control"
        autocomplete="new-password"
        required
      >
      @if ($errors->updatePassword->has('password_confirmation'))
        <div class="text-danger mt-1">
          {{ $errors->updatePassword->first('password_confirmation') }}
        </div>
      @endif
    </div>

    <div class="d-flex align-items-center gap-3">
      <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

      @if (session('status') === 'password-updated')
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
