<div>
    <x-slot name="name">
        {{ __('FM-LDS-006') }}
    </x-slot>
    <x-slot name="rev">
        {{ __('Rev. 01 : 15.03.2019') }}
    </x-slot>


    @if ($val)
        <x-errors />
        <div class="container w-full h-screen grid place-items-center">
        <x-card title="Error" class="container ">
                {{-- {{dd($req)}} --}}
                @foreach ($val as $msg)
                {{-- {{dd($msg)}} --}}
                <x-badge icon="exclamation" warning label="{{$msg}}" />
                @endforeach
                <x-slot name="footer">
                    <livewire:components.training-request-action :wire:key="$req->req_code" :code="$req->req_code"/>
                </x-slot>

        </x-card>
        </div>

        {{-- {{$val}} --}}
        {{-- {{dd($val,$val->all()[0])}} --}}
    @else
    <div id="FM-LDS-008" class="text-sm max-w-3xl m-auto p-2 shadow-lg print:shadow-none">
        <img class="h-16 w-full object-contain pb-4" src="{{asset('/img/logo.png') }}">
        <section class="pb-4">
            <h1 class="text-xl mb-2 font-bold text-center">
                EXTERNAL TRAINING รายงานการฝึกอบรมภายนอก
            </h1>
        </section>
         <!-- dd($info) }} -->
        <section class="pb-4 grid grid-cols-12 gap-2">
                <span class="font-bold col-span-2">Trainee :<br>ชื่อผู้เข้าอบรม </span>
                    <span class="col-span-4">{{$instructor->name}}</span>
                <span class="font-bold col-span-2">ID No. :<br>รหัสพนักงาน </span>
                    <span class="col-span-4">{{$instructor->staff_id}}</span>

                <span class="font-bold col-span-2">Position :<br>ตำแหน่ง </span>
                    <span class="col-span-4">{{$instructor->position}}</span>
                <span class="font-bold col-span-2">Department :<br>แผนก </span>
                    <span class="col-span-2">{{$instructor->department}}</span>
        </section>
        <section class="pb-4 grid grid-cols-8 gap-2">
                <span class="font-bold col-span-3">
                    Training Program/Seminar :<br>ได้ผ่านการอบรม/สัมนา หลักสูตร
                </span>
                <p class="col-span-5"> {{$req->req_title}} </p>
        </section>
        <hr class="my-2 py-2 col-span-8 border-t border-dashed border-black w-3/4 m-auto">
        <section class="pb-4 grid grid-cols-12 gap-2">
                <span class="font-bold col-span-2">Training Date :<br>วันที่อบรม </span>
                    <span class="col-span-3">
                        {{$info['start_date']}}
                        @if( $info['start_date']!==$info['end_date'] )
                            - {{$info['end_date']}}
                        @endif
                    </span>
                <span class="font-bold col-span-2">Duration :<br>ระยะเวลา </span>
                    <span class="text-center">{{$info['duration']}} ชั่วโมง</span>
                <span class="font-bold">Venue :<br>สถานที่ </span>
                    <span class="col-span-3">{{$info['venue']}}</span>

                <span class="font-bold col-span-2">Lecturer :<br>วิทยากร </span>
                    <span class="col-span-3">{{$info['lecturer']}}</span>
                <span class="font-bold col-span-2">Institution :<br>สถาบัน </span>
                    <span class="col-span-4">{{$info['institution']}}</span>
        </section>
        <hr class="my-2 py-2 col-span-12 border-t border-dashed border-black w-3/4 m-auto">

        <!-- <hr class="w-1/2 m-auto mt-4 mb-2 border-2"> -->

        <!-- <hr class="my-2   mb-2 border-2"> -->

        <section class="pb-4">
            <div class="pb-2">
                <h4 class="font-bold py-2">
                    Hightlihts of training program/seminar :<br>มีเนื้อหาโดยสังเขป
                </h4>
                <span>{!! nl2br($info['Hightlihts'])??'-' !!} </span>
            </div>

            <div class="pb-2">
                <h4 class="font-bold py-2">
                    Application of new learning on the job :<br>แนวทางการนำมาประยุกต์ในงาน
                </h4>
                <span>{!! nl2br($info['applic_action'])??'-' !!} </span>
            </div>
        </section>

        <hr class="my-2 py-2 col-span-12 border-t border-dashed border-black w-3/4 m-auto">

        <section class="pb-4 grid grid-cols-8">
            <span class="font-bold col-span-2">Report by รายงานโดย </span>
                <span class="col-span-4">{{$requester->name}}</span>
            <span class="font-bold">Date:<br> วันที่ </span>
                <span class="">{{$req->created_at}}</span>
        </section>


        <!-- <hr class="my-2   mb-2 border-2"> -->


        <section class="pb-4">

            <div class="grid grid-cols-8">
            <p class="col-span-4">
                    <strong>{{__('Reviewed')}}: </strong>{{$reviewer->name??'-'}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Position')}}: </strong>{{$reviewer->position??'-'}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Date')}}: </strong>{{$req->req_dateReview??'-'}}
                </p>
            </div>

            <div class="grid grid-cols-8">
            <p class="col-span-4">
                    <strong>{{__('Approved')}}: </strong>{{$approver->name??'-'}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Position')}}: </strong> {{$approver->position??'-'}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Date')}}: </strong>{{$req->req_dateApprove??'-'}}
                </p>
            </div>
        </section>


    </div>
    @endif
</div>
