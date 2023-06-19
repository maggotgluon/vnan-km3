@extends('layouts.base')
<style>
    footer,header {
        font-size: 9px;
        color: #232323;
        text-align: center;
        width: 100%;
    }
    main{
        margin: 10px;
    }
    footer {
        position: fixed;
        bottom: 0;
    }
    header {
        position: fixed;
        top: 0;
    }

    @page {
        size: A4;
        margin: 10mm 10mm 10mm 10mm;
    }

    @media print {
        footer {
            position: fixed;
            bottom: 0;
        }
        header {
            position: fixed;
            top: 0;
        }

        .content-block, p {
            page-break-inside: avoid;
        }

        html, body {
            width: 210mm;
            height: 297mm;
        }
    }

</style>
@section('body')
<div class="absolute w-full text-right p-4 print:hidden">
        <x-button icon="printer" onclick="window.print();" class="py-1">print</x-button>
</div>
        <div id="htmlPDF" class="">


        <header class="hidden print:block">
            <span class="float-left flex w-32">
                <img src="{{asset('img/logo.png')}}" alt="">
            </span>

            <span class="float-right text-right">
                Printed by {{Auth::user()->name}} ( {{Auth::user()->staff_id}} )<br> Date : {{Carbon\Carbon::now()->toDateString()}}
            </span>
        </header>
        <main class="content-block">
            <div class="flex items-start justify-center container mx-auto min-h-screen py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
        <footer class="hidden print:block">
            <span class="float-left">
                @if (isset($name))
                    {{ $name }}
                @endif
            </span>

            <span class="float-right ">
                @if (isset($rev))
                    {{ $rev }}
                @endif
            </span>
        </footer>
        </div>
    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
