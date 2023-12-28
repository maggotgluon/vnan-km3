<div class="w-full">
    Show Single request {{ $req->req_code }}
    <livewire:components.document-request-action :wire:key="$req->req_code" :code="$req->req_code"/>
    {{-- {{ dd($req,$req->info->meta_value) }} --}}
    
    <x-badge outline>
        {{$req->req_obj->discription()}}
    </x-badge>
    <x-badge outline>
        เลขที่เอกสาร : {{$req->req_code}}
    </x-badge>

    @isset($req->info->meta_value['discription'])
        <div class="border border-primary-300 rounded-lg p-4 my-2 mt-6 relative">
            <h2 class="bg-gray-200 absolute top-0 -translate-y-1/2 px-2">
                คำอธิบาย
            </h2>
            {{$req->info->meta_value['discription']}}
        </div>
    @endisset

    <ul>
    @foreach($req->info->meta_value as $key=>$val)
        <li>{{$key}} : {{$val}}</li>
    @endforeach
    </ul>
    {{-- {{var_export(asset($req->info->meta_value['file_pdf']))}} --}}
    @isset ($req->info->meta_value['file_pdf'])
        <livewire:components.pdf-viewer :wire:key="$req->req_code" :file="asset($req->info->meta_value['file_pdf'])"/>
    @endisset

    {{$req}}



    <!-- "id" => 3
    "req_code" => "DAR20230003"
    "req_obj" => "7"
    "req_title" => "KPI-ADS-2023"
    "req_status" => 0
    "user_id" => 103
    "req_dateReview" => "2023-06-13 17:59:13"
    "user_review" => "103"
    "req_dateApprove" => "2023-06-13 17:59:13"
    "user_approve" => "103"
    "remark" => null
    "created_at" => "2023-06-13 17:55:22"
    "updated_at" => "2023-06-13 18:45:00" -->

</div>
