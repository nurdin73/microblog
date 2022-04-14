@extends('admin.template.main')
@section('title', 'Update Blog')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Theme included stylesheets -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="mt-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Update Blog
    </h2>
    <span class="block text-gray-700 dark:text-gray-200 text-sm mb-6">Update Blog post</span>
    @if (session('error'))
      <div class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-red-100 bg-red-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-red">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ session('error') }}</span>
        </div>
      </div>
    @endif
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
      <form action="{{ route('admin.blogs.update', ['blog' => $blog->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid gap-6 mb-4 md:grid-cols-2 xl:grid-cols-2">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Title</span>
            <input
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="Jane Doe"
              name="title"
              value="{{ old('title') ?? $blog->title }}"
            />
            @error('title')
              <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
            @enderror
          </label>
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400 mb-2">Tags</span>
            <select id="select2" name="tags[]" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" multiple>
              @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" @if(Arr::where($blog->tags()->get()->toArray(), function($val, $key) use($tag) {
                  return $val['id'] == $tag->id;
                })) selected @endif>{{ Str::limit($tag->name, 20) }}</option>
              @endforeach
            </select>
          </label>
        </div>
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Content</span>
          <div id="content" class="block w-full mt-3 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
            {!! old('content') ?? $blog->content !!}
          </div>
          <input type="hidden" name="content" value="{!! old('content') ?? $blog->content !!}" id="field-content">
          @error('content')
            <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
          @enderror
        </label>
        <div class="grid grid-cols-2 gap-6 mt-3">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Photos</span>
            <input
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="Jane Doe"
              name="photos[]"
              type="file"
              multiple
            />
            @error('photos')
              <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
            @enderror
          </label>
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">
              Status
            </span>
            <select
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
              name="status"
            >
              <option value="">Choose</option>
              <option value="draft" @if($blog->status == 'draft') selected @endif>Draft</option>
              <option value="published" @if($blog->status == 'published') selected @endif>Published</option>
            </select>
            @error('status')
              <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
            @enderror
          </label>
        </div>
        <div class="flex mt-3">
          <button class="px-4 py-2 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" type="submit">
            Save
          </button>
          <a class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" href="{{ route('admin.blogs.index') }}">
            Cancel
          </a>
        </div>
      </form>
    </div>
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