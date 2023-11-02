@section('title', $info['title'])
<div class="w-full">
    <x-dialog z-index="z-50" blur="md" align="center" />
    <div class="my-4">
        <livewire:components.training-request-action :wire:key="$req->req_code" :code="$req->req_code"/>
    </div>
    <div class="bg-white rounded-lg drop-shadow-lg flex gap-2 p-2 mb-4">
        <x-button gray label="Back" :href="route('training.request.index')"/>

        <span class="ml-auto">
        </span>

        @switch($req->req_obj)
            @case('internal')
            <x-button sm label="FM-LDS-008" :href="route('training.request.show-008',['id'=>$req->req_code])" />
            <x-button sm label="FM-LDS-009" :href="route('training.request.show-009',['id'=>$req->req_code])" />
                @break
            @case('external')
            <x-button sm label="FM-LDS-006" :href="route('training.request.show-006',['id'=>$req->req_code])" />
                @break
            @default

        @endswitch

    </div>
    @if ($val)

        <div class="container w-full  grid place-items-center">
        <x-card title="Error" class="container ">
                @foreach ($val as $msg)
                <x-badge icon="exclamation" warning label="{{$msg}}" />
                @endforeach
                <x-slot name="footer">
                </x-slot>

        </x-card>
        </div>
    @else 
    <div class="bg-white rounded-lg drop-shadow-lg gap-2 p-2 mb-4">
        <x-badge label="{{ $req->req_code }}"/>
        <h2 class="text-2xl font-bold pb-4 my-2">{{ $info['title'] }}</h2>

        <div class="grid lg:grid-cols-2 gap-2 mb-4">
            <span>Requester Information : {{$req->user->name}}</span>
            <span>Date Request : {{$req->created_at}}</span>
            <span>Department : {{$req->user->department}}</span>
            <span>Department Head : {{$req->user->HOD()->name}}</span>
        </div>
{{-- {{dd($info)}} --}}
        @if($req->req_obj=='internal')
            <div class="grid lg:grid-cols-2 gap-2 mb-4">
                <span class="lg:col-span-2">Instructor : {{$instructor->name}}</span>
                <span>Date Strat : {{ $info['start_date'] }} {{$info['start_date']==$info['end_date']?'':' - '.$info['end_date']}}</span>
                <span>Time Strat : {{ $info['start_time'] }} - {{ $info['end_time'] }}</span>
            </div>
        @endif
        {{-- @isset($info['filePDF-certificate'])
        {{dd($info['filePDF-certificate'])}}
        <x-button href="{{ asset($info['filePDF-certificate']) }}" label="ดาว์โหลด certificate"/>
        @endisset --}}
        @isset($info['filePDF'])
        <x-button href="{{ asset($info['filePDF']) }}" label="ดาว์โหลด เอกสารประกอบ"/>
        <object data="{{ asset($info['filePDF']) }}" type="application/pdf" width="100%" height="600px">
            <p>Unable to display PDF file. <a href="{{ asset($info['filePDF']) }}">Download</a> instead.</p>
        </object>
        @endisset

        @switch($req->req_obj)
            @case('internal')
            <div class="my-4">
                <livewire:training-requested.view.fmlds008 :id="$req->req_code"/>
            </div>
            <div class="my-4">
                <livewire:training-requested.view.fmlds009 :id="$req->req_code"/>
            </div>
        @break
            @case('external')
            <div class="my-4">
                <livewire:training-requested.view.fmlds006 :id="$req->req_code"/>
            </div>
        @break
            @default

        @endswitch
        <table class="table-fixed min-w-full my-4">
            <thead>
                <tr class="border border-primary-300 bg-primary-500 text-white hidden lg:table-row">
                    <th class="border border-primary-300 p-2 w-1/2 lg:table-cell">
                        <span class="m-2">DCC เจ้าหน้าที่ควบควมเอกสาร	</span>
                    </th>
                    <th class="border border-primary-300 p-2 w-1/2 lg:table-cell">
                        <span class="m-2">OMR/MR ตัวแทนฝ่ายบริหารพิจารณาอนุมัติ</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-primary-300 block lg:table-cell">
                        <div class="lg:hidden p-2 w-3/4 border-b-2 border-primary-500">
                        DCC เจ้าหน้าที่ควบควมเอกสาร</div>
                        @if($reviewer!=null && $reviewer!="")
                        <div class="m-2">
                            <strong>Name : {{$reviewer->name}}</strong><br>
                            <strong>Date : {{$req->req_dateReview}}</strong>
                        </div>
                        @endif
                    </td>
                    <td class="border border-primary-300 block lg:table-cell">
                        <div class="lg:hidden p-2 w-3/4 border-b-2 border-primary-500">
                        OMR/MR ตัวแทนฝ่ายบริหารพิจารณาอนุมัติ</div>
                        @if($reviewer!=null && $reviewer!="")

                        <div class="m-2">
                            <strong>Name : {{$reviewer->name}}</strong><br>
                            <strong>Date : {{$req->req_dateApprove}}</strong>
                        </div>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>   
    @endif
</div>
