@extends('admin.template.main')
@section('title', 'Detail Blog link')
@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="mt-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Detail {{ $qf->type }}
      @if($qf->status == 'published')
        <span class="px-2 py-1 font-semibold text-sm text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
          {{ $qf->status }}
        </span>
      @else
        <span class="px-2 py-1 font-semibold text-sm text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
          {{ $qf->status }}
        </span>
      @endif
    </h2>
    <span class="inline-block mb-6 dark:text-gray-200 text-gray-700 text-xs">Published at {{ \Carbon\Carbon::parse($qf->published_at)->format('d F Y') }}</span>
    <div class="flex justify-center flex-col">
      <a href="{{ $qf->link }}" class="font-semibold text-green-700 text-lg">{{ $qf->title }}</a>
      <div class="mb-4">
        <svg
          aria-hidden="true"
          focusable="false"
          data-prefix="fas"
          data-icon="quote-left"
          class="w-6 pr-2 text-gray-600"
          role="img"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512"
        >
          <path
            fill="currentColor"
            d="M464 256h-80v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8c-88.4 0-160 71.6-160 160v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48zm-288 0H96v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8C71.6 32 0 103.6 0 192v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48z"
          ></path>
        </svg>
        <div class="italic text-gray-600">
          {!! $qf->content !!}
        </div>
        <svg
          aria-hidden="true"
          focusable="false"
          data-prefix="fas"
          data-icon="quote-left"
          class="w-6 pr-2 text-gray-600"
          role="img"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512"
        >
          <path
            fill="currentColor"
            d="M464 256h-80v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8c-88.4 0-160 71.6-160 160v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48zm-288 0H96v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8C71.6 32 0 103.6 0 192v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48z"
          ></path>
        </svg>
      </div>
      <div class="flex mt-3">
        <a class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" href="{{ route('admin.quote-funfacts.index') }}">
          Back
        </a>
      </div>
    </div>
  </div>    
@endsection