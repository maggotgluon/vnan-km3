@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center py-12 sm:px-6 lg:px-8">


        <div class="flex items-center justify-center">
            <div class="flex flex-col justify-around">
                <div class="space-y-6">
                    <a href="{{ route('home') }}">
                        <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
                    </a>

                    <h1 class="text-5xl font-extrabold tracking-wider text-center text-gray-600">
                        {{ config('app.name') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection
