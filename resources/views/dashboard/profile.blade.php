@extends('layouts.app')

@section('title', 'My Profile - Telkom Marketplace') {{-- Optional: Set a title --}}

@section('content')

<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 md:p-8">

    {{-- Profile Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100">
            My Profile
        </h1>
        <a href="{{ route('dashboard') }}" class="mt-3 sm:mt-0 text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-500 font-medium flex items-center transition-colors duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-700/30 border-l-4 border-green-500 dark:border-green-400 text-green-700 dark:text-green-300 p-4 rounded-md shadow" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500 dark:text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        {{-- Laravel often uses @method('PATCH') or @method('PUT') for updates, check your route definition --}}
        {{-- If your route for profile.update is a POST route, then @csrf is enough. If it's PUT/PATCH, add: --}}
        {{-- @method('PUT') --}}

        {{-- Profile Photo Section --}}
        <div class="flex flex-col items-center space-y-4 pb-8 border-b border-gray-200 dark:border-gray-700">
            @if($user->profile_photo)
                <img src="{{ asset('storage/profile_photos/'.$user->profile_photo) }}"
                     alt="{{ $user->name }}'s Profile Photo" class="w-32 h-32 rounded-full object-cover shadow-lg border-4 border-white dark:border-gray-700">
            @else
                {{-- Fallback to initials if no profile photo --}}
                <span class="inline-flex items-center justify-center h-32 w-32 rounded-full bg-red-600 text-white shadow-lg border-4 border-white dark:border-gray-700">
                    <span class="text-4xl font-semibold">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }} {{-- U for User as default --}}
                    </span>
                </span>
            @endif
            <div>
                <label for="profile_photo_input" class="cursor-pointer mt-4 inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                    </svg>
                    Change Photo
                </label>
                <input type="file" name="profile_photo" id="profile_photo_input" accept="image/*" class="sr-only">
                @error('profile_photo') <p class="text-red-600 text-xs mt-2 text-center">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Personal Information Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('name', $user->name) }}">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-600 dark:text-gray-400 sm:text-sm cursor-not-allowed" value="{{ $user->email }}" readonly>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Email cannot be changed.</p>
            </div>

            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIM</label>
                <input type="text" id="nim" name="nim" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('nim', $user->nim) }}">
                @error('nim') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                <input type="text" id="phone" name="phone" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('phone', $user->phone) }}" placeholder="e.g., 08123456789">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="faculty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Faculty</label>
                <input type="text" id="faculty" name="faculty" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('faculty', $user->faculty) }}">
                @error('faculty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="major" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Major</label>
                <input type="text" id="major" name="major" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('major', $user->major) }}">
                @error('major') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
            <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" placeholder="Tell us a little about yourself...">{{ old('bio', $user->bio) }}</textarea>
            @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Address Section --}}
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 space-y-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Address Details</h3>
            <div>
                <label for="street_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street Address</label>
                <input type="text" id="street_address" name="street_address" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('street_address', $user->street_address) }}">
                @error('street_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                    <input type="text" id="city" name="city" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('city', $user->city) }}">
                    @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Province</label>
                    <input type="text" id="province" name="province" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('province', $user->province) }}">
                    @error('province') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                    <input type="text" id="postal_code" name="postal_code" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:text-white sm:text-sm" value="{{ old('postal_code', $user->postal_code) }}">
                    @error('postal_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="pt-8 flex justify-end space-x-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('dashboard') }}"
               class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold text-sm rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-md shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection