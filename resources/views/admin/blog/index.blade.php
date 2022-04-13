@extends('admin.template.main')
@section('title', 'Blogs')
@section('content')
  <div class="container px-6 mx-auto grid">
    <div class="flex justify-between align-center my-6">
      <h2 class=" text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Blogs
      </h2>
      <a href="{{ route('admin.blogs.create') }}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">New Blog</a>
    </div>
    <div class="flex justify-between align-center mb-4">
      <label class="block text-sm w-24">
        <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
          <option value="10" @if($limit == 10) selected @endif>10</option>
          <option value="25" @if($limit == 25) selected @endif>25</option>
          <option value="50" @if($limit == 50) selected @endif>50</option>
          <option value="100" @if($limit == 100) selected @endif>100</option>
        </select>
      </label>
      <form method="GET" action="{{ route('admin.blogs.index') }}">
        <div class="relative text-gray-500 focus-within:text-purple-600">
          <input
            class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
            placeholder="Search by title"
            name="search"
            value="{{ $search }}"
          />
          {{-- <input type="hidden" name="limit" value="{{ $limit }}">
          <input type="hidden" name="page" value="{{ request()->page }}"> --}}
          <button type="submit" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Search
          </button>
        </div>
      </form>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
            >
              <th class="px-4 py-3 text-center">No</th>
              <th class="px-4 py-3">Title</th>
              <th class="px-4 py-3 text-center">Status</th>
              <th class="px-4 py-3 text-center">Created At</th>
              <th class="px-4 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @forelse ($blogs as $b)
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-center">
                  {{ $loop->iteration }}
                </td>
                <td class="px-4 py-3 text-sm ">
                  <a title="{{ $b->title }}" href="{{ route('admin.blogs.show', ['blog' => $b->id]) }}" class="text-purple-600 dark:text-gray-200 hover:underline">{{ \Str::limit($b->title, 60) }}</a>
                </td>
                <td class="px-4 py-3 text-xs text-center">
                  @if($b->status == 'published')
                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                      {{ $b->status }}
                    </span>
                  @else
                    <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                      {{ $b->status }}
                    </span>
                  @endif
                </td>
                <td class="px-4 py-3 text-sm text-center">
                  {{ $b->created_at->format('d F Y') }}
                </td>
                <td class="px-4 py-3 text-sm text-center flex align-center justify-center">
                  <a href="{{ route('admin.blogs.edit', ['blog' => $b->id]) }}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Edit
                  </a>
                  <form action="{{ route('admin.blogs.destroy', $b->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="px-3 ml-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-center" colspan="5">
                  No blogs found
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div
        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
      >
        <span class="flex items-center col-span-3">
          Showing {{ $blogs->firstItem() }} - {{ $blogs->lastItem() }} of {{ $blogs->total() }}
        </span>
        <span class="col-span-2"></span>
        <!-- Pagination -->
        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
          {{ $blogs->links() }}
        </span>
      </div>
    </div>
  </div>    
@endsection