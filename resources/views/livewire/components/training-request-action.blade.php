<div class="@container w-full">

    <div class="hidden @md:flex items-center gap-2">
        <span>Status : </span> <x-badge color="{{ $req->getColor() }}" icon="tag" label="{{ $req->getStatus() }}" />
        @if(1==2)
        <x-button negative icon="x" label="Delete" class="!justify-start" wire:click="delete" spinner />
        <x-button primary icon="check" label="Submit" class="!justify-start" wire:click="edit" spinner />
        <x-button info icon="check" label="Review" class="!justify-start" wire:click="review" spinner />
        <x-button positive icon="check" label="Approve" class="!justify-start" wire:click="approve" spinner />
        <x-button warning icon="x" label="Reject" class="!justify-start" wire:click="$set('remark', 'true')" spinner />
        @endif
    </div>
    <div class="flex @xs:grid gap-2">

        @if ($remark)
        <div class="grid gap-2 w-full">
            <x-textarea label="Remark" wire:model="comment"/>
            <div class="flex justify-end gap-2">
                <x-button label="Cancle" class="!justify-start" spinner wire:click="cancel"/>
                <x-button warning icon="x" label="Reject" class="!justify-start" wire:click="reject" spinner />
            </div>
        </div>
        @else
        <!-- {{$req->req_status}} -->
        @switch($req->req_status)
            @case(0)
                <x-button negative icon="x" label="Delete" class="!justify-start" wire:click="delete" spinner />
                <x-button primary icon="check" label="Submit" class="!justify-start" wire:click="edit" spinner />
                @break
            @case(1)
                @can('review_trainDocument')
                    <x-button info icon="check" label="Review" class="!justify-start" wire:click="review" spinner />
                    @if (!$remark)
                        <x-button warning icon="x" label="Reject" class="!justify-start" wire:click="$set('remark', 'true')" spinner />
                    @endif
                
                @endcan
                @break
            @case(2)
                @can('publish_trainDocument')
                    <x-button positive icon="check" label="Approve" class="!justify-start" wire:click="approve" spinner />
                    @if (!$remark)
                        <x-button warning icon="x" label="Reject" class="!justify-start" wire:click="$set('remark', 'true')" spinner />
                    @endif
                @endcan
                @break
            @default
                -
        @endswitch
        @endif
    </div>
</div>
