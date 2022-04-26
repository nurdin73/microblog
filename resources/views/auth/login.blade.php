@extends('auth.template')
@section('title', 'Login')
@section('content')
  <div class="w-full">
    <form action="{{ route('login') }}" method="post">
      @csrf
      <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Login</h1>
      @if (session('status'))
      <div class="flex items-center justify-between p-4 mb-9 mt-3 text-sm font-semibold text-green-100 bg-green-700 rounded-lg shadow-md focus:outline-none focus:shadow-outline-green">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ session('status') }}</span>
        </div>
      </div>
      @endif
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Email</span>
        <input
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="system@system.com"
          name="email"
          type="email"
        />
        @error('email')
          <small class="text-xs italic text-gray-600">{{ $message }}</small>
        @enderror
      </label>
      <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Password</span>
        <input
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="***************"
          type="password"
          name="password"
        />
        @error('password')
          <small class="text-xs text-gray-600 italic">{{ $message }}</small>
        @enderror
      </label>

      <!-- You should use a button here, as the anchor is only used for the example  -->
      {{-- <a
        class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-lg active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
        href="../index.html"
      >
        Log in
      </a> --}}
      <button type="submit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-lg active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">Log In</button>

      <p class="mt-4">
        <a
          class="text-sm font-medium text-green-700 dark:text-green-400 hover:underline"
          href="{{ route('password.request') }}"
        >
          Forgot your password?
        </a>
      </p>
    </form>
  </div>
@endsection