@extends('layouts.email')

@section('body')
<style>
    .status{
        padding: .5rem;
        background: black;
        color:aliceblue;
        border-radius: 100rem;
        display: block;
        margin: auto;
        width: max-content;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .bg-reject{
        background: maroon;
    }
    .bg-Pending{
        background: darkkhaki;
    }
    .bg-Reviewed{
        background: navy;
    }
    .bg-Approved{
        background: darkgreen;
    }
</style>
<div class="flex justify-center container mx-auto min-h-screen py-6 pt-28 bg-gray-200 sm:px-6 lg:px-8">
    <p>
    @switch($request->req_status)
        @case(-1)
        <span class="bg-reject status">Status : Rejected</span>
            @break
        @case(1)
        <span class="bg-Pending status">Status : Pending</span>
            @break
        @case(2)
        <span class="bg-Reviewed status">Status : Reviewed</span>
            @break
        @case(3)
        <span class="bg-Approved status">Status : Approved</span>
            @break
        @default
        <span class="bg-reject status">Other</span>
    @endswitch
    </p>
    ส่งโดย : {{$requeser->name}} ({{$requeser->staff_id}} )<br>
    <b>ข้อมูล</b><br>
    
        หัวข้อ : {{$request->req_title}}<br>
        ผู้สอน : {{$instructor->name}} ({{$instructor->staff_id}} )<br>
        ดูรายละเอียด<br>
            <div style="margin-top: 1rem;">
                <a class="button" href="{{route('training.request.show',['id'=>$request->req_code])}}">request</a>

                @switch($request->req_obj)
                    @case('internal')
                        <a class="button" href="{{route('training.request.show-008',['id'=>$request->req_code])}}" > FM-LDS-008 </a>
                        <a class="button" href="{{route('training.request.show-009',['id'=>$request->req_code])}}" > FM-LDS-009 </a>
                    @break
                    @case('external')
                        <a class="button" href="{{route('training.request.show-006',['id'=>$request->req_code])}}" > FM-LDS-006 </a>
                    @break
                    @default

                @endswitch

            </div>
</div>

@endsection