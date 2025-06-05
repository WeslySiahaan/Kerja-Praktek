<section class="mt-5">
  <header class="mb-3">
    <h2 class="h5 text-dark">
      {{ __('Delete Account') }}
    </h2>
    <p class="text-muted">
      {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>
  </header>

  <!-- Delete button triggers modal -->
  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
    {{ __('Delete Account') }}
  </button>

  <!-- Modal -->
  <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
        @csrf
        @method('delete')

        <div class="modal-header">
          <h5 class="modal-title" id="deleteAccountModalLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
        </div>

        <div class="modal-body">
          <p>
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
          </p>

          <div class="mt-3">
            <label for="password" class="form-label visually-hidden">{{ __('Password') }}</label>
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              placeholder="{{ __('Password') }}"
              required
            >
            @if ($errors->userDeletion->has('password'))
              <div class="text-danger mt-1">
                {{ $errors->userDeletion->first('password') }}
              </div>
            @endif
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            {{ __('Cancel') }}
          </button>
          <button type="submit" class="btn btn-danger">
            {{ __('Delete Account') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
