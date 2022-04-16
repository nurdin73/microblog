@extends('admin.template.main')
@section('title', 'Edit Collection')
@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Edit Collection
    </h2>
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
    <form action="{{ route('admin.collections.update', $collection->id) }}" method="post">
      @csrf
      @method('put')
      <label class="block text-sm mb-2">
        <span class="text-gray-700 dark:text-gray-400">Collection</span>
        <select
          class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
          name="collection_id"
        >
          <option value="">Choose</option>
          @foreach ($shopify_collections as $sc)
            <option value="{{ $sc->id }}" @if($collection->collection_id == $sc->id) selected @endif>{{ $sc->title }}</option>
          @endforeach
        </select>
        @error('collection_id')
          <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
        @enderror
      </label>
      <label class="block text-sm mb-2">
        <span class="text-gray-700 dark:text-gray-400">Title</span>
        <input
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Jane Doe"
          name="title"
          value="{{ old('title') ?? $collection->title }}"
        />
        @error('title')
          <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
        @enderror
      </label>
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Caption</span>
        <input
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Jane Doe"
          name="caption"
          value="{{ old('caption') ?? $collection->caption }}"
        />
        @error('caption')
          <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
        @enderror
      </label>
      <div class="flex mt-3">
        <button class="px-4 py-2 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" type="submit">
          Save
        </button>
        <a class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" href="{{ route('admin.collections.index') }}">
          Cancel
        </a>
      </div>
    </form>
  </div>    
@endsection