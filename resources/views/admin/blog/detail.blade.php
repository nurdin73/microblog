@extends('admin.template.main')
@section('title', 'Detail Blog')
@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="mt-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      {{ $blog->title }} 
      @if($blog->status == 'published')
        <span class="px-2 py-1 font-semibold text-sm text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
          {{ $blog->status }}
        </span>
      @else
        <span class="px-2 py-1 font-semibold text-sm text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
          {{ $blog->status }}
        </span>
      @endif
    </h2>
    <span class="block text-gray-700 dark:text-gray-200 text-xs mb-6 mt-1 italic">Created At {{ $blog->created_at->format('d F Y H:i:s') }}</span>
    @if ($blog->photos->count() > 0)
      <div id="carouselExampleControls" class="carousel slide relative" data-bs-ride="carousel">
        <div class="carousel-inner relative w-full overflow-hidden">
          @foreach ($blog->photos as $key => $val)
            @php
              if(filter_var($val->src, FILTER_VALIDATE_URL)) {
                  $image = $val->src;
              } else {
                  $image = asset('storage'.$val->src);
              }
            @endphp
            <div class="carousel-item @if($key == 0) active @endif relative float-left w-full">
              <img
                src="{{ $image }}"
                class="block w-full"
                alt="{{ $val->src }}"
              />
            </div>
          @endforeach
        </div>
        <button
          class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
          type="button"
          data-bs-target="#carouselExampleControls"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon inline-block bg-no-repeat" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
          type="button"
          data-bs-target="#carouselExampleControls"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon inline-block bg-no-repeat" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    @endif
    <ul class="flex items-center justify-start space-x-3 my-3">
      @foreach ($blog->tags as $tag)
      <li class="cursor-pointer text-green-900 px-2 rounded bg-green-500 hover:bg-green-700 hover:text-green-100 transition duration-500">
        <span>{{ Str::limit($tag->name, 20) }}</span>
      </li>
      @endforeach
    </ul>
    <div class="block text-gray-700 dark:text-gray-200 text-sm">
      {!! $blog->content !!}
    </div>
    <div class="flex mt-3">
      <a class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" href="{{ route('admin.blogs.index') }}">
        Back
      </a>
    </div>
  </div>    
@endsection