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

    <div class="bg-white rounded-lg drop-shadow-lg gap-2 p-2 mb-4">
        <x-badge label="{{ $req->req_code }}"/>
        <h2 class="text-2xl font-bold pb-4 my-2">{{ $info['title'] }}</h2>

        <div class="grid lg:grid-cols-2 gap-2 mb-4">
            <span>Requester Information : {{$req->user->name}}</span>
            <span>Date Request : {{$req->created_at}}</span>
            <span>Department : {{$req->user->department}}</span>
            <span>Department Head : {{$req->user->HOD()->name}}</span>
        </div>

        @if($req->req_obj=='internal')
            <div class="grid lg:grid-cols-2 gap-2 mb-4">
                <span class="lg:col-span-2">Instructor : {{$instructor->name}}</span>
                <span>Date Strat : {{ $info['start_date'] }} {{$info['start_date']==$info['end_date']?'':' - '.$info['end_date']}}</span>
                <span>Time Strat : {{ $info['start_time'] }} - {{ $info['end_time'] }}</span>
            </div>
        @endif
        @isset($info['filePDF'])
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
                        <div class="m-2">
                            <strong>Name : {{$reviewer->name}}</strong><br>
                            <strong>Date : {{$req->req_dateReview}}</strong>
                        </div>
                    </td>
                    <td class="border border-primary-300 block lg:table-cell">
                        <div class="lg:hidden p-2 w-3/4 border-b-2 border-primary-500">
                        OMR/MR ตัวแทนฝ่ายบริหารพิจารณาอนุมัติ</div>
                        <div class="m-2">
                            <strong>Name : {{$reviewer->name}}</strong><br>
                            <strong>Date : {{$req->req_dateApprove}}</strong>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

     <!-- dd($info) }} -->


    <!-- "title" => "Tenetur culpa nam suscipit et delectus"
    "Remark" => "Voluptatem aliquam at reprehenderit est. Exercitationem eligendi illum necessitatibus numquam recusandae. Fuga qui possimus id repudiandae at earum."
    "end_date" => "2023-10-06"
    "end_time" => "14:15"
    "objective" => "Omnis sint accusantium pariatur ex dignissimos aut corrupti soluta. Ut aut ut incidunt. Excepturi nulla facere qui deleniti et dolore eum nostrum ut."
    "instructor" => 1
    "start_date" => "2023-10-20"
    "start_time" => "10:50"
    "activity_time" => "199"
    "evaluate_time" => "184"
    "assessmentTools" => "Alias non quia et odit culpa consectetur et. Dolore in sed ratione et et nemo ullam. Id voluptatibus id et cumque."
    "criteriamentPass" => "Ut ut omnis debitis."
    "information_time" => "391"
    "assessmentProcess" => array:3 [▶]
    "criteriamentNopass" => "Natus voluptatem ipsam deleniti et provident qui perspiciatis qui optio."
    "activityDiscription" => "Esse et quo dolor eum quisquam sint quia distinctio. Suscipit dolores est explicabo nostrum illo cumque consequuntur. Quisquam sint aut eos quod ut numquam susc ▶"
    "evaluateDiscription" => "Minima molestias quia corrupti. Similique dolores fuga ex dolore consequatur porro omnis tenetur rerum. Sequi cum ipsum."
    "subjectDetailsDiscription" => "Dignissimos enim porro odio beatae et quia." -->
</div>
