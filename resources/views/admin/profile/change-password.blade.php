@extends('admin.template.main')
@section('title', 'Change password')
@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Change Password
    </h2>
    @if (session('status'))
      <div class="flex items-center justify-between p-4 mb-9 mt-3 text-sm font-semibold text-green-100 bg-green-700 rounded-lg shadow-md focus:outline-none focus:shadow-outline-green">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="ml-1">{{ session('status') }}</span>
        </div>
      </div>
    @endif
    <form action="{{ route('admin.change-password.update') }}" method="post">
      @csrf
      <label class="block text-sm mb-2">
        <span class="text-gray-700 dark:text-gray-400">Old Password</span>
        <input
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Jane Doe"
          name="old_password"
          value="{{ old('old_password') }}"
          type="password"
        />
        @error('old_password')
          <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
        @enderror
      </label>
      <label class="block text-sm mb-2">
        <span class="text-gray-700 dark:text-gray-400">New Password</span>
        <input
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Jane Doe"
          name="password"
          value="{{ old('password') }}"
          type="password"
        />
        @error('password')
          <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
        @enderror
      </label>
      <label class="block text-sm mb-2">
        <span class="text-gray-700 dark:text-gray-400">Password Confirmation</span>
        <input
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          placeholder="Jane Doe"
          name="password_confirmation"
          value="{{ old('password_confirmation') }}"
          type="password"
        />
        @error('password_confirmation')
          <small class="text-xs text-gray-600 dark:text-green-700 italic">{{ $message }}</small>
        @enderror
      </label>
      <div class="flex mt-3">
        <button class="px-4 py-2 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-700 border border-transparent rounded-md active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-green" type="submit">
          Change
        </button>
        <a class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" href="{{ route('admin.collections.index') }}">
          Cancel
        </a>
      </div>
    </form>
  </div>    
@endsection