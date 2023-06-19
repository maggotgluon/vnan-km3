<div class="w-full">
    Show Single request {{ $req->req_code }}
    <livewire:components.document-request-action :wire:key="$req->req_code" :code="$req->req_code"/>
    {{ dd($req,$req->info->meta_value) }}

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
