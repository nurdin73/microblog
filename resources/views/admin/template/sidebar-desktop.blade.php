@php
    $route = Route::getCurrentRoute()->getName();
@endphp
<aside
  class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0"
>
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <a
      class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
      href="{{ route('admin.home') }}"
    >
      {{ config('app.name') }}
    </a>
    <ul class="mt-6">
      <li class="relative px-6 py-3">
        <!-- Active items have the snippet below -->
        <!-- <span
          class="absolute inset-y-0 left-0 w-1 bg-green-700 rounded-tr-lg rounded-br-lg"
          aria-hidden="true"
        ></span> -->

        <!-- Add this classes to an active anchor (a tag) -->
        <!-- text-gray-800 dark:text-gray-100 -->
        <a
          class="inline-flex items-center w-full @if($route == 'admin.home') text-gray-800 dark:text-gray-100 @endif text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('admin.home') }}"
        >
          <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          <span class="ml-4">Dashboard</span>
        </a>
      </li>
      <li class="relative px-6 py-3 focus:outline-none">
        <button
          class="@if($route == 'admin.master.tags.index') text-gray-800 dark:text-gray-100 @endif inline-flex items-center focus:outline-none justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          @click="togglePagesMenu"
          aria-haspopup="true"
        >
          <span class="inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
            <span class="ml-4">Master</span>
          </span>
          <svg
            class="w-4 h-4"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </button>
        <template x-if="isPagesMenuOpen">
          <ul
            x-transition:enter="transition-all ease-in-out duration-300"
            x-transition:enter-start="opacity-25 max-h-0"
            x-transition:enter-end="opacity-100 max-h-xl"
            x-transition:leave="transition-all ease-in-out duration-300"
            x-transition:leave-start="opacity-100 max-h-xl"
            x-transition:leave-end="opacity-0 max-h-0"
            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
            aria-label="submenu"
          >
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="{{ route('admin.master.tags.index') }}">Tags</a>
            </li>
          </ul>
        </template>
      </li>
      <li class="relative px-6 py-3">
        <a
          class="@if($route == 'admin.blogs.index') text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('admin.blogs.index') }}"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
          </svg>
          <span class="ml-4">Micro Blog</span>
        </a>
      </li>
      {{--  <li class="relative px-6 py-3">
        <a
          class="@if($route == 'admin.quote-funfacts.index') text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('admin.quote-funfacts.index') }}"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
          </svg>
          <span class="ml-4">Blog Link</span>
        </a>
      </li>  --}}
      <li class="relative px-6 py-3">
        <a
          class="@if($route == 'admin.collections.index') text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('admin.collections.index') }}"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
          <span class="ml-4">Collections</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <a
          class="@if($route == 'admin.holiday.index') text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('admin.holiday.index') }}"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span class="ml-4">Holiday</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <a
          class="@if($route == 'admin.surveys') text-gray-800 dark:text-gray-100 @endif inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('admin.surveys') }}"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
          </svg>
          <span class="ml-4">Survey Results</span>
        </a>
      </li>
    </ul>
  </div>
</aside>