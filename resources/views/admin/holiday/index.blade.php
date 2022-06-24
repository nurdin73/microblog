@extends('admin.template.main')
@section('title', 'Holiday')

@section('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
<div class="container px-6 mx-auto grid">
  <div class="flex justify-between align-center my-6">
    <h2 class=" text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Holidays
    </h2>
    <button type="button" class="inline-block px-6 py-2.5 bg-green-700 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-toggle="modal" data-bs-target="#exampleModalCenteredScrollable">
      Add Holiday
    </button>
  </div>
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
  @if ($errors->any())
    <div class="p-4 mb-9 mt-3 text-sm font-semibold text-red-100 bg-red-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
  <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <label class="block text-sm w-24">
      <select onchange="limitItem()" id="limit" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:focus:shadow-outline-gray">
        <option value="10" @if($limit == 10) selected @endif>10</option>
        <option value="25" @if($limit == 25) selected @endif>25</option>
        <option value="50" @if($limit == 50) selected @endif>50</option>
        <option value="100" @if($limit == 100) selected @endif>100</option>
      </select>
    </label>
    <table class="w-full whitespace-no-wrap my-3">
      <thead>
        <tr
          class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
        >
          <th class="px-4 py-3 text-center">No</th>
          <th class="px-4 py-3">Title</th>
          <th class="px-4 py-3 text-center">Start Date</th>
          <th class="px-4 py-3 text-center">End Date</th>
          <th class="px-4 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
        @php
          $no = $holidays->firstItem();
        @endphp
        @forelse ($holidays as $h)
          <tr class="text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3 text-center">
              {{ $no++ }}
            </td>
            <td class="px-4 py-3 text-sm ">{{ \Str::limit($h->title, 60) }}</td>
            <td class="px-4 py-3 text-sm text-center">
              {{ \Carbon\Carbon::parse($h->start_date)->format('Y-m-d') ?? '-' }}
            </td>
            <td class="px-4 py-3 text-sm text-center">
              {{ $h->end_date ? \Carbon\Carbon::parse($h->end_date)->format('Y-m-d') : '-' }}
            </td>
            <td class="px-4 py-3 text-sm text-center flex align-center justify-center">
              <button type="button" class="inline-block px-3 py-1 bg-green-700 text-white font-medium text-sm leading-tight rounded-md shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-toggle="modal" data-bs-target="#exampleModalCenteredScrollable{{ $h->id }}">
                Edit
              </button>
              @include('admin.holiday.modal', ['method' => 'put', 'titleModal' => 'Update Holiday', 'typeModal' => "exampleModalCenteredScrollable$h->id", 'url' => route('admin.holiday.update', $h->id), 'title' => $h->title, 'startDate' => \Carbon\Carbon::parse($h->start_date)->format('Y-m-d'), 'endDate' => $h->end_date ? \Carbon\Carbon::parse($h->end_date)->format('Y-m-d') : '', 'status' => $h->status])
              <form action="{{ route('admin.holiday.destroy', $h->id) }}" method="post" class="deleteItem">
                @csrf
                @method('delete')
                <button type="submit" class="px-3 ml-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr class="text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3 text-center" colspan="5">
              No holiday found
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div
      class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
    >
      <span class="flex items-center col-span-3">
        Showing {{ $holidays->firstItem() ?? 0 }} - {{ $holidays->lastItem() ?? 0 }} of {{ $holidays->total() }}
      </span>
      <span class="col-span-2"></span>
      <!-- Pagination -->
      <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
        {{ $holidays->links() }}
      </span>
    </div>
  </div>
</div>    
@endsection


@section('modal')
  @include('admin.holiday.modal', ['typeModal' => 'exampleModalCenteredScrollable', 'titleModal' => 'Add Holiday', 'method' => 'post', 'url' => route('admin.holiday.store'), 'title' => '', 'startDate' => '', 'endDate' => '', 'status' => '']);
@endsection


@section('js')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script>
    function limitItem() {  
      var limit = $('#limit').val();
      var page = '{{ request()->page ?? 1 }}';
      const form = document.createElement('form');
      form.method = 'GET';
      form.action = '{{ route('admin.holiday.index') }}';
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'limit';
      input.value = limit;
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

    $('.start_date').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      autoApply: true,
      placeholder: 'select start date',
      autoUpdateInput: false,
      // applyButtonClasses: 'inline-block px-6 py-2.5 bg-green-700 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out',
      // maxDate: moment().format('YYYY-MM-DD'),
      locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
      }
    });
    $('.end_date').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      autoApply: true,
      autoUpdateInput: false,
      // applyButtonClasses: 'inline-block px-6 py-2.5 bg-green-700 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out',
      // maxDate: moment().format('YYYY-MM-DD'),
      locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
      }
    });

    $('.start_date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD'))
    });

    $('.end_date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD'))
    });

  </script>
@endsection
