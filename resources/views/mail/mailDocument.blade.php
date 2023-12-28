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
        color:aliceblue;
        background: maroon;
    }
    .bg-Pending{
        color:aliceblue;
        background: darkkhaki;
    }
    .bg-Reviewed{
        color:aliceblue;
        background: navy;
    }
    .bg-Approved{
        color:aliceblue;
        background: darkgreen;
    }
</style>
<div class="flex justify-center container mx-auto min-h-screen py-6 pt-28 bg-gray-200 sm:px-6 lg:px-8">
    <p>
    @switch($request->req_status)
        @case(-1)
        <span class="bg-reject status">สถานะ : ปฏิเสธ</span>
            @break
        @case(1)
        <span class="bg-Pending status">สถานะ : รอการตรวจสอบ</span>
            @break
        @case(2)
        <span class="bg-Reviewed status">สถานะ : ตรวจสอบแล้ว</span>
            @break
        @case(3)
        <span class="bg-Approved status">สถานะ : อนุมัติ</span>
            @break
        @default
        <span class="bg-reject status">ผิดพลาด</span>
    @endswitch
    </p>
    @if ($request->remark)
    <div class="bg-reject" style="padding:.5em">
        หมายเหตุ : {{$request->remark}}
    </div>
    @endif
    ส่งโดย : {{$requeser->name}} ({{$requeser->staff_id}} )<br>
    <b>ข้อมูล</b><br>
    
        รหัสเอกสาร : {{$request->req_title}} rev. {{$request->info->meta_value['ver']??"0"}}<br>
        ชื่อเอกสาร : {{$request->info->meta_value['name_en']??''}} {{$request->info->meta_value['name_th']??''}}<br>
        
        รายละเอียด คำร้อง<br>
        {{$request->info->meta_value['discription']??''}}

        @if ($request->req_status===3)
        <p>
            เอกสารจะมีผลบังคับใช้งาน {{$request->info->meta_value['effective']??''}}
        </p>
        @endif
            <div style="margin-top: 1rem;">
                <a class="button" href="{{route('document.request.show',['id'=>$request->req_code])}}">request</a>
            </div>

        {{-- {{$request}} --}}
    
</div>

@endsection