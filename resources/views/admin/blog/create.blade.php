@extends('admin.template.main')
@section('title', 'Add New Blog')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- include summernote css/js -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="mt-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      New Blog
    </h2>
    <span class="block text-gray-700 dark:text-gray-200 text-sm mb-6">Add new blog post</span>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
      <form action="{{ route('admin.blogs.store') }}" method="post">
        @csrf
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Title</span>
            <input
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="Jane Doe"
              name="title"
            />
            @error('title')
              <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
            @enderror
          </label>
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400 mb-2">Tags</span>
            <select id="select2" name="tags" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" multiple>
              @foreach ($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
              @endforeach
            </select>
          </label>
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Content</span>
            <textarea
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
              rows="3"
              placeholder="Enter some long form content."
              id="summernote"
            ></textarea>
            @error('title')
              <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
            @enderror
          </label>
        </div>
      </form>
    </div>
  </div>    
@endsection


@section('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#select2').select2();
      $('#summernote').summernote({
        placeholder: 'Enter some long form content.',
        tabsize: 2,
        height: 300
      });
    });
  </script>
@endsection