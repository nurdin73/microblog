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

