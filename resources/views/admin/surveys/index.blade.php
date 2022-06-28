@extends('admin.template.main')
@section('title', 'Survey answer results')

@section('content')
<div class="container px-6 mx-auto grid">
  <div class="flex justify-between align-center my-6">
    <h2 class=" text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Survey Answer Results
    </h2>
  </div>
  <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <form method="GET" action="{{ route('admin.surveys') }}">
        <div class="relative text-gray-500 focus-within:text-green-700">
          <input
            class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray form-input"
            placeholder="Search by answer"
            name="search"
            id="search"
            value="{{ $search }}"
          />
          <input type="hidden" name="page" value="{{ request()->page ?? 1 }}">
          <button type="submit" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-r-md active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
            Search
          </button>
        </div>
      </form>
    <table class="w-full whitespace-no-wrap my-3">
      <thead>
        <tr
          class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
        >
          <th class="px-4 py-3 text-center w-5">No</th>
          <th class="px-4 py-3">Answer</th>
          <th class="px-4 py-3 w-10">Total Answer</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
        @php
          $no = $surveys->firstItem();
        @endphp
        @forelse ($surveys as $s)
          <tr class="text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3 text-center">
              {{ $no++ }}
            </td>
            <td class="px-4 py-3 text-sm ">{{ $s->answer }}</td>
            <td class="px-4 py-3 text-sm text-center">{{ $s->total_answer }}</td>
            {{--  <td class="px-4 py-3 text-sm text-center">
              {{ \Carbon\Carbon::parse($h->start_date)->format('Y-m-d') ?? '-' }}
            </td>  --}}
          </tr>
        @empty
          <tr class="text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3 text-center" colspan="5">
              No answer survey found
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div
      class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
    >
      <span class="flex items-center col-span-3">
        Showing {{ $surveys->firstItem() ?? 0 }} - {{ $surveys->lastItem() ?? 0 }} of {{ $surveys->total() }}
      </span>
      <span class="col-span-2"></span>
      <!-- Pagination -->
      <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
        {{ $surveys->links() }}
      </span>
    </div>
  </div>
</div>    
@endsection

