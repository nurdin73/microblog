@extends('admin.template.main')
@section('title', 'Blog links')
@section('content')
  <div class="container px-6 mx-auto grid">
    <div class="flex justify-between align-center my-6">
      <h2 class=" text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Blog links
      </h2>
      <a href="{{ route('admin.quote-funfacts.create') }}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-md active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">New Blog Link</a>
    </div>
    @if (session('success'))
      <div class="flex items-center justify-between p-4 mb-9 mt-3 text-sm font-semibold text-green-100 bg-green-700 rounded-lg shadow-md focus:outline-none focus:shadow-outline-green">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="ml-1">{{ session('success') }}</span>
        </div>
      </div>
    @endif
    <div class="flex justify-between align-center mb-4">
      <label class="block text-sm w-24">
        <select onchange="limitItem()" id="limit" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray">
          <option value="10" @if($limit == 10) selected @endif>10</option>
          <option value="25" @if($limit == 25) selected @endif>25</option>
          <option value="50" @if($limit == 50) selected @endif>50</option>
          <option value="100" @if($limit == 100) selected @endif>100</option>
        </select>
      </label>
      <form method="GET" action="{{ route('admin.quote-funfacts.index') }}">
        <div class="relative text-gray-500 focus-within:text-green-700">
          <input
            class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray form-input"
            placeholder="Search by title"
            name="search"
            id="search"
            value="{{ $search }}"
          />
          <input type="hidden" name="limit" value="{{ $limit }}">
          <input type="hidden" name="page" value="{{ request()->page ?? 1 }}">
          <button type="submit" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-r-md active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
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
              <th class="px-4 py-3 text-center">Published at</th>
              <th class="px-4 py-3 text-center">Created At</th>
              <th class="px-4 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @php
              $no = $quote_funfacts->firstItem();
            @endphp
            @forelse ($quote_funfacts as $qf)
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-center">
                  {{ $no++}}
                </td>
                <td class="px-4 py-3 text-sm ">
                  <a title="{{ $qf->title }}" href="{{ route('admin.quote-funfacts.show', ['quote_funfact' => $qf->id]) }}" class="text-green-700 dark:text-gray-200 hover:underline">{{ \Str::limit($qf->title, 30) }}</a>
                </td>
                <td class="px-4 py-3 text-xs text-center">
                  @if($qf->status == 'published')
                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                      {{ $qf->status }}
                    </span>
                  @else
                    <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                      {{ $qf->status }}
                    </span>
                  @endif
                </td>
                <td class="px-4 py-3 text-sm text-center">
                  {{ \Carbon\Carbon::parse($qf->published_at)->format('d F Y') }}
                </td>
                <td class="px-4 py-3 text-sm text-center">
                  {{ $qf->created_at->format('d F Y') }}
                </td>
                <td class="px-4 py-3 text-sm text-center flex align-center justify-center">
                  <a href="{{ route('admin.quote-funfacts.edit', ['quote_funfact' => $qf->id]) }}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-md active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                    Edit
                  </a>
                  <form action="{{ route('admin.quote-funfacts.destroy', $qf->id) }}" method="post" class="deleteItem">
                    @csrf
                    @method('delete')
                    <button type="submit" class="px-3 ml-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-center" colspan="7">
                  No blog link found
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
          Showing {{ $quote_funfacts->firstItem() ?? 0 }} - {{ $quote_funfacts->lastItem() ?? 0 }} of {{ $quote_funfacts->total() }}
        </span>
        <span class="col-span-2"></span>
        <!-- Pagination -->
        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
          {{ $quote_funfacts->links() }}
        </span>
      </div>
    </div>
  </div>    
@endsection

@section('js')
  <script>
    function limitItem() {  
      var limit = $('#limit').val();
      var search = $('#search').val();
      var page = '{{ request()->page ?? 1 }}';
      const form = document.createElement('form');
      form.method = 'GET';
      form.action = '{{ route('admin.quote-funfacts.index') }}';
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'limit';
      input.value = limit;
      form.appendChild(input);
      input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'search';
      input.value = search;
      form.appendChild(input);
      input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'page';
      input.value = page;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }

    $('.deleteItem').on('submit', function(e) {
      e.preventDefault();
      var form = this;
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2f8d03',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  </script>
@endsection