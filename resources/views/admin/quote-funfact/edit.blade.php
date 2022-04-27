@extends('admin.template.main')
@section('title', 'Edit Blog link')
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Theme included stylesheets -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Add Blog Link
    </h2>
    @if (session('error'))
      <div class="flex items-center justify-between p-4 mb-9 mt-3 text-sm font-semibold text-red-100 bg-red-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-red">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="ml-1">{{ session('error') }}</span>
        </div>
      </div>
    @endif
    <form action="{{ route('admin.quote-funfacts.update', $qf->id) }}" method="post">
      @csrf
      @method('put')
      <div class="grid gap-6 mb-4 md:grid-cols-2 xl:grid-cols-2">
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Title</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Jane Doe"
            name="title"
            value="{{ old('title') ?? $qf->title }}"
          />
          @error('title')
            <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
          @enderror
        </label>
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400 mb-2">Tags</span>
          <select id="select2" name="tags[]" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray" multiple>
            @foreach ($tags as $tag)
              <option value="{{ $tag->id }}" @if(Arr::where($qf->tags()->get()->toArray(), function($val, $key) use($tag) {
                return $val['id'] == $tag->id;
              })) selected @endif>{{ Str::limit($tag->name, 20) }}</option>
            @endforeach
          </select>
        </label>
      </div>
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Content</span>
        <div id="content" class="block w-full mt-3 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray">
          {!! old('content') ?? $qf->content !!} 
        </div>
        <input type="hidden" name="content" value="{!! old('content') ?? $qf->content !!}" id="field-content">
        @error('content')
          <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
        @enderror
      </label>
      <div class="grid grid-cols-3 gap-6 mt-3">
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Type</span>
          <select
            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray"
            name="type"
          >
            <option value="">Choose</option>
            <option value="quote" @if($qf->type == 'quote') selected @endif>Quote</option>
            <option value="funfact" @if($qf->type == 'funfact') selected @endif>Funfact</option>
          </select>
          @error('type')
            <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
          @enderror
        </label>
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Published at</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Jane Doe"
            name="published_at"
            value="{{ old('published_at') ?? $qf->published_at }}"
            type="date"
          />
          @error('published_at')
            <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
          @enderror
        </label>
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">
            Status
          </span>
          <select
            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray"
            name="status"
          >
            <option value="">Choose</option>
            <option value="draft" @if($qf->status == 'draft') selected @endif>Draft</option>
            <option value="published" @if($qf->status == 'published') selected @endif>Published</option>
          </select>
          @error('status')
            <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
          @enderror
        </label>
      </div>
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Link</span>
        <input
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="https://"
          name="link"
          type="url"
          value="{{ old('link') ?? $qf->link }}"
        />
        @error('link')
          <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
        @enderror
      </label>
      <div class="flex mt-3">
        <button class="px-4 py-2 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-md active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green" type="submit">
          Save
        </button>
        <a class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" href="{{ route('admin.quote-funfacts.index') }}">
          Cancel
        </a>
      </div>
    </form>
  </div>    
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Main Quill library -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script>
    $(document).ready(function() {
      $('#select2').select2();
      var quill = new Quill('#content', {
        theme: 'snow'
      });
      quill.on('text-change', function(delta, oldDelta, source) {
        $('#field-content').val(quill.root.innerHTML);
      });
    });
  </script>
@endsection