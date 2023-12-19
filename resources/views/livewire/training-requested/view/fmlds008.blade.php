<div>
    <x-slot name="name">
        {{ __('FM-LDS-008') }}
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
                TRAINING OUTLINE เค้าโครงการฝึกอบรมรายหัวข้อ
            </h1>
            <div class="font-bold text-center">
                <h3>SUBJECT หัวข้อเรื่อง : {{$req->req_title}} </h3>
                <h3>วันที่เริ่มอบรม : {{$info['start_date']??'-'}} วันที่สิ้นสุด : {{$info['end_date']??'-'}}  </h3>
                <h3>เวลาเริ่ม : {{$info['start_time']??'-'}}  เวลาสิ้นสุด : {{$info['end_time']??'-'}}  </h3>
            </div>

        </section>


        <section class="pb-4">
            <h4 class="font-bold">
                Objective & Outcome วัตถุประสงค์
            </h4>
            <p>
                <strong>เพื่อให้พนักงานมีความรู้และความสามารถในเรื่องของ : </strong>
                <span>{!! nl2br($info['objective'])??'-' !!} </span>
            </p>
        </section>


        <!-- <hr class="w-1/2 m-auto mt-4 mb-2 border-2"> -->

        <!-- <hr class="my-2   mb-2 border-2"> -->

        <section class="pb-4">
            <table class=" w-full ">
                <thead class=" bg-gray-300 h-14">
                    <tr>
                        <th class="w-3/12">Topic รายการ</th>
                        <th class="w-7/12">Description รายละเอียด</th>
                        <th class="w-2/12">Duration เวลา(นาที)</th>
                    </tr>
                </thead>
                <tbody class="align-top">
                    <tr class="border-y">
                        <td class="font-bold pt-2  pl-2">Subject Details<br> รายละเอียดการอบรม</td>
                        <td class="pb-6 pt-2"> {!! nl2br($info['subjectDetailsDiscription'])??'-' !!} </td>
                        <td class="text-center pt-2"> {{$info['information_time']??'-'}} </td>
                    </tr>
                    <tr class="border-y">
                        <td class="font-bold pt-2 pl-2">Activity<br> กิจกรรม ในการอบรม</td>
                        <td class="pb-6 pt-2"> {!! nl2br($info['activityDiscription'])??'-' !!} </td>
                        <td class="text-center pt-2"> {{$info['activity_time']??'-'}} </td>
                    </tr>
                    <tr class="border-y">
                        <td class="font-bold pt-2 pl-2">Assessment<br> การประเมินผล</td>
                        <td class="pb-6 pt-2"> {!! nl2br($info['evaluateDiscription'])??'-' !!} </td>
                        <td class="text-center pt-2"> {{$info['evaluate_time']??'-'}} </td>
                    </tr>

                    <tr class="border-y">
                        <td class="font-bold pt-2 pl-2">Remark<br> หมายเหตุ</td>
                        <td colspan="2" class="pb-8 pt-2"> 
                            @isset($info['Remark'])
                                {!! nl2br($info['Remark'])??'-' !!} 
                            @endisset
                        </td>

                    </tr>

                </tbody>
            </table>
        </section>


        <!-- <hr class="my-2   mb-2 border-2"> -->


        <section class="pb-4">
            <div class="grid grid-cols-8">
                <p class="col-span-4">
                    <strong>{{__('Requester Information')}}: </strong> {{$requester->name}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Position')}}: </strong> {{$requester->position}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Date')}}: </strong> {{$req->created_at->isoFormat('Do MMM YYYY')}}
                </p>
            </div>

            <div class="grid grid-cols-8">
                <p class="col-span-4">
                    <strong>{{__('Instructor')}}: </strong> {{$instructor->name}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Position')}}: </strong> {{$instructor->position}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Date Strat')}}: </strong> {{$info['start_date']??'-'}}
                </p>
            </div>

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
