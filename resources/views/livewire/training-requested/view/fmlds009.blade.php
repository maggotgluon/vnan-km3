<div>
    <x-slot name="name">
        {{ __('FM-LDS-009')  }}
    </x-slot>
    <x-slot name="rev">
        {{ __('Rev. 00 : 17.02.2016')  }}
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
    <div id="FM-LDS-009" class="text-sm max-w-3xl m-auto p-2 shadow-lg print:shadow-none">
        <img class="h-16 w-full object-contain pb-4" src="{{asset('/img/logo.png') }}">
        <!-- <span class="text-sm text-gray-300">FM-LDS-009-rev.00-แนวทางการประเมินผลการอบรมในการปฏิบัติงาน</span> -->
        <section class="pb-2">
            <h2 class="text-xl mb-4 font-bold text-center">
                OJT ASSESSMENT GUIDELINE แนวทางการประเมินผลการอบรมในการปฏิบัติงาน
            </h2>

        </section>

        <section class="pb-2">
            <div class="border p-4 mt-2">
                <strong>DEPARTMENT แผนก :</strong>
                {{$instructor->department}}

            </div>
            <div class="border p-4 mt-2">
                <strong>SUBJECT หัวข้อ :</strong>
                {{ $info['title'] }}
            </div>
        </section>

        <section class="pb-2">
            <div class="border p-4 mt-2">
                <strong> รูปแบบการประเมิน :</strong>

                @if(gettype($info['assessmentProcess'])=="array")
                    @foreach ( $info['assessmentProcess'] as $assessmentProcess)
                        {{ $assessmentProcess }}
                    @endforeach
                @else
                    {{ $info['assessmentProcess'] }}
                @endif

                <!-- <span class="px-2 mx-2">☐ ถาม-ตอบ</span><span class="px-2 mx-2">☐ แบบทดสอบ</span><span class="px-2 mx-2">☐ ทดลองปฏิบัติงานจริง</span> -->
            </div>
            <div class="p-4">
                <strong> หมายเหตุ :</strong>
                <ol class="list-decimal	list-inside	">
                    <li>กรณีที่เป็นการถามตอบ กรุณาระบุคำถามและคำตอบโดยคร่าวพร้อมเกณฑ์การผ่านประเมิน</li>
                    <li>กรณีที่เป็นการทดสอบ กรุณาแนบแบบทดสอบพร้อมระบุเกณฑ์การผ่านประเมิน</li>
                    <li>กรณีที่เป็นการทดลองปฏิบัติงานจริง กรุณาระบุกิจกรรมพร้อมเกณฑ์การผ่านประเมิน</li>
                </ol>
            </div>

        </section>

        <section class="pb-2">
            <div class="border p-4 mt-2 pb-4">
                <strong>คำถาม/แบบทดสอบ/หัวข้อการปฏิบัติงาน : </strong>
                @if(isset($info['assessmentTools']))
                <p>  {!! nl2br( $info['assessmentTools'])??'-' !!} </p>
                @endif
            </div>
            <div class="border p-4 mt-2 pb-4">
                <strong>เกณฑ์การประเมิน : </strong>

                <p class="pb-2">
                    <strong>ผ่าน : </strong> {!! nl2br( $info['criteriamentPass'])??'-' !!}
                </p>
                <p class="pb-2">
                    <strong>ไม่ผ่าน : </strong> {!! nl2br( $info['criteriamentNopass'])??'-' !!}
                </p>

            </div>
        </section>

        <section class="pb-2">
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
                @if(isset($reviewer->name))
                <p class="col-span-4">
                    <strong>{{__('Reviewed')}}: </strong>{{$reviewer->name??'-'}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Position')}}: </strong>{{$reviewer->position??'-'}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Date')}}: </strong>{{$req->req_dateReview??'-'}}
                </p>
                @endif
            </div>

            <div class="grid grid-cols-8">
                
                @if(isset($reviewer->name))
                <p class="col-span-4">
                    <strong>{{__('Approved')}}: </strong>{{$approver->name??'-'}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Position')}}: </strong> {{$approver->position??'-'}}
                </p>
                <p class="col-span-2">
                    <strong>{{__('Date')}}: </strong>{{$req->req_dateApprove??'-'}}
                </p>
                @endif
            </div>
        </section>

    </div>
    @endif


</div>
