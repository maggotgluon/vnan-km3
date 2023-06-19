@extends('layouts.base')

@section('body')
        <x-nav-bar />
<div class="flex justify-center container mx-auto min-h-screen py-6 pt-28 bg-gray-200 sm:px-6 lg:px-8">
    @yield('content')
</div>

    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
