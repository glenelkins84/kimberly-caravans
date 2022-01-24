<form method="POST" action="{{ $url }}" class="admin-form">
  @include('admin._partials.errors')

  @if ($businessArea->exists)
    @method('put')
  @endif
  @csrf

  @include('admin._partials.redirect-input')

  <div>
    <label for="name">
      Name
    </label>
    <input name="name" value="{{ old("name", $businessArea->name) }}" type="text" placeholder="Name" required>
  </div>

  <div>
    <label for="email">
      Email
    </label>
    <input name="email" value="{{ old("email", $businessArea->email) }}" type="email" placeholder="Email" required>
  </div>

  <div class="flex items-center justify-between">
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
      @if ($businessArea->exists)
        @lang('global.update')
      @else
        @lang('global.create')
      @endif
    </button>
  </div>
</form>