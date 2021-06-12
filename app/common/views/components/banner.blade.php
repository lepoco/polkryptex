<div class="h-100 p-5 {{ isset($dark) ? ($dark ? 'text-white bg-dark' : 'bg-light') : 'bg-light' }} rounded-3">
  <h2>{{ $title ?? 'Title' }}</h2>
  <p>{{ $text ?? 'text' }}</p>
  <button class="btn btn-outline-{{ isset($dark) ? ($dark ? 'light' : 'dark') : 'dark' }}" type="button">{{ $button ?? 'Example button' }}</button>
</div>