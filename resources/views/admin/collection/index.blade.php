@extends('admin.template.main')
@section('title', 'Collections')
@section('content')
  <div class="container px-6 mx-auto grid">
    <div class="flex justify-between align-center my-6">
      <h2 class=" text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Collections
      </h2>
      <button type="button" class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-toggle="modal" data-bs-target="#exampleModalCenteredScrollable">
        New Collection
      </button>
    </div>
    @if (session('success'))
      <div class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ session('success') }}</span>
        </div>
      </div>
    @endif
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
    <div class="flex justify-between align-center mb-4">
      <label class="block text-sm w-24">
        <select onchange="limitItem()" id="limit" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
          <option value="10" @if($limit == 10) selected @endif>10</option>
          <option value="25" @if($limit == 25) selected @endif>25</option>
          <option value="50" @if($limit == 50) selected @endif>50</option>
          <option value="100" @if($limit == 100) selected @endif>100</option>
        </select>
      </label>
      <form method="GET" action="{{ route('admin.collections.index') }}">
        <div class="relative text-gray-500 focus-within:text-purple-600">
          <input
            class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
            placeholder="Search by title"
            name="search"
            id="search"
            value="{{ $search }}"
          />
          <input type="hidden" name="limit" value="{{ $limit }}">
          {{-- <input type="hidden" name="page" value="{{ request()->page }}"> --}}
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
            @forelse ($collections as $c)
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-center">
                  {{ $loop->iteration }}
                </td>
                <td class="px-4 py-3 text-sm ">
                  <span class="text-purple-600 dark:text-gray-200 block">{{ \Str::limit($c->title, 60) }}</span>
                  <small class="text-purple-600 dark:text-gray-200 block text-xs">{{ \Str::limit($c->caption, 60) }}</small>
                </td>
                <td class="px-4 py-3 text-xs text-center">
                  @if($c->is_active == 1)
                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                      Published
                    </span>
                  @else
                    <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                      Draft
                    </span>
                  @endif
                </td>
                <td class="px-4 py-3 text-sm text-center">
                  {{ $c->created_at->format('d F Y') }}
                </td>
                <td class="px-4 py-3 text-sm text-center flex align-center justify-center">
                  <a href="{{ route('admin.collections.edit', ['collection' => $c->id]) }}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Edit
                  </a>
                  <form action="{{ route('admin.collections.destroy', $c->id) }}" method="post" class="deleteItem">
                    @csrf
                    @method('delete')
                    <button type="submit" class="px-3 ml-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-center" colspan="5">
                  No collection found
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
          Showing {{ $collections->firstItem() }} - {{ $collections->lastItem() }} of {{ $collections->total() }}
        </span>
        <span class="col-span-2"></span>
        <!-- Pagination -->
        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
          {{ $collections->links() }}
        </span>
      </div>
    </div>
  </div>    
@endsection

@section('modal')
  <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="exampleModalCenteredScrollable" tabindex="-1" aria-labelledby="exampleModalCenteredScrollable" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable relative w-auto pointer-events-none">
      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray bg-clip-padding rounded-md outline-none text-current">
        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800 rounded-t-md">
          <h5 class="text-xl font-medium leading-normal text-gray-700 dark:text-gray-200" id="exampleModalCenteredScrollableLabel">
            Add Collection
          </h5>
          <button type="button"
            class="btn-close box-content w-4 h-4 p-1 text-black dark:text-gray-200 border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
            data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.collections.store') }}" method="post">
          @csrf
          <div class="modal-body relative p-4">
            <label class="block text-sm mb-2">
              <span class="text-gray-700 dark:text-gray-400">Collection</span>
              <select
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                name="collection_id"
              >
                <option value="">Choose</option>
                @foreach ($shopify_collections as $sc)
                  <option value="{{ $sc->id }}">{{ $sc->title }}</option>
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
                value="{{ old('title') }}"
              />
              @error('title')
                <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
              @enderror
            </label>
            <label class="block text-sm">
              <span class="text-gray-700 dark:text-gray-400">Caption</span>
              <textarea
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                rows="3"
                placeholder="Enter some long form caption."
                name="caption"
              >{{ old('caption') }}</textarea>
              @error('caption')
                <small class="text-xs text-gray-600 dark:text-purple-600 italic">{{ $message }}</small>
              @enderror
            </label>
          </div>
          <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 dark:border-gray-800 rounded-b-md">
            <button type="button"
              class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
              data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit"
              class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">
              Save changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')

  <script>
    function limitItem() {  
      var limit = $('#limit').val();
      var search = $('#search').val();
      const form = document.createElement('form');
      form.method = 'GET';
      form.action = '{{ route('admin.collections.index') }}';
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
        confirmButtonColor: '#3085d6',
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