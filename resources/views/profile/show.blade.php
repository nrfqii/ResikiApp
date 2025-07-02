@extends('layouts.main')

@section('title', 'My Profile')
@section('subtitle', 'View and manage your profile information')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Profile Picture -->
        <div class="flex-shrink-0">
            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-600 mb-4 capitalize">{{ $user->role }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="text-gray-800">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">No Hp</p>
                    <p class="text-gray-800">{{ $user->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Alamat</p>
                    <p class="text-gray-800">{{ $user->alamat ?? '-' }}</p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection