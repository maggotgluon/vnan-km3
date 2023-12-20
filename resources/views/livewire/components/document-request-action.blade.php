<div class="@container w-full">

    {{-- <div class=" @xs:flex items-center gap-2">
        <span>Status : </span> <x-badge color="{{ $req->getColor() }}" icon="tag" label="{{ $req->getStatus() }}" />
        <x-button negative icon="x" label="Delete" class="!justify-start" wire:click="delete" spinner />
        <x-button primary icon="check" label="Submit" class="!justify-start" wire:click="edit" spinner />
        <x-button info icon="check" label="Review" class="!justify-start" wire:click="review" spinner />
        <x-button positive icon="check" label="Approve" class="!justify-start" wire:click="approve" spinner />
        <x-button warning icon="x" label="Reject" class="!justify-start" wire:click="$set('remark', 'true')" spinner />
    </div> --}}
    <div class="@xs:flex grid gap-2">
        {{-- <x-button label="mail" wire:click="sendEmailAcknowledgment" spinner/> --}}

        @if ($remark)
        <div class="grid gap-2">
            <x-textarea label="Remark" wire:model="comment"/>

            <x-button warning icon="x" label="Reject" class="!justify-start" wire:click="reject" spinner />
        </div>
        @else
        @switch($req->req_status)
            @case(0)
                <x-button negative icon="x" label="Delete" class="!justify-start" wire:click="delete" spinner />
                <x-button primary icon="check" label="Submit" class="!justify-start" wire:click="edit" spinner />
                @break
            @case(1)

                @can('review_document')
                    <x-button info icon="check" label="Review" class="!justify-start" wire:click="review" spinner />
                    @if (!$remark)
                        <x-button warning icon="x" label="Reject" class="!justify-start" wire:click="$set('remark', 'true')" spinner />
                    @endif
                @endcan
                @break
            @case(2)
                @can('publish_document')
                    <x-button positive icon="check" label="Approve" class="!justify-start" wire:click="approve" spinner />
                    @if (!$remark)
                        <x-button warning icon="x" label="Reject" class="!justify-start" wire:click="$set('remark', 'true')" spinner />
                    @endif
                @endcan
                @break
            @default

        @endswitch
        @endif
    </div>
</div>
