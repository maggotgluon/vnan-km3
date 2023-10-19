<div class="w-full">
    @if(1==2)
    <div class="flex gap-2 items-end my-4">

        <x-native-select label="Internal"
            placeholder="Appointment Date"
            :options="[
                ['name' => 'Internal',  'id' => 'internal'],
                ['name' => 'External', 'id' => 'external'],
            ]"
            option-label="name"
            option-value="id"
            wire:model="filter_internal"/>
    </div>
    @endif
    <div class="flex gap-2 items-end my-4">
        <x-input label="ค้นหา"
            wire:model.lazy="filter_search" class="focus:w-48 active:w-48"/>
        {{-- <x-native-select label="แผนก"
            placeholder="Appointment Date"
            :options="[
                ['name' => 'IT',  'id' => '1'],
                ['name' => 'IT',  'id' => 'Information Technology'],
                ['name' => 'HR', 'id' => '2'],
            ]"
            option-label="name"
            option-value="id"
            wire:model="filter_department"/> --}}

        @if(1==2)
            <x-datetime-picker without-time clearable
                label="Training Date"
                placeholder="Appointment Date"
                wire:model.lazy="filter_date_from"
            />
            @if($filter_date_from)
            <x-datetime-picker without-time clearable
                label="to Date"
                placeholder="{{ $filter_date_from }}"
                value="{{ $filter_date_from }}"
                min="{{ $filter_date_from }}"
                wire:model.lazy="filter_date_to"
            />
            @endif
        @endif
        <x-button label="clear" wire:click="clear"/>
        <span class="ml-auto">
            <x-native-select label="show"
                :options="[5,10,25,50]"
                wire:model="filter_paginate"/>
        </span>
    </div>
    <div class="min-w-full overflow-x-scroll relative">
        <div wire:loading class="text-center absolute inset-0 top-10">
            <x-badge flat primary lg label="Loading" class="animate-pulse py-2 px-4">
                <x-slot name="prepend" class="relative flex items-center">
                    <x-icon name="cog" class="w-16 animate-spin-slow m-4"/>
                </x-slot>
            </x-badge>
        </div>
        <table class="table-auto w-full min-w-full transition-all " wire:loading.class="pointer-events-none animate-pulse">
            <thead>
                <tr class="border border-primary-300 bg-primary-500 text-white">
                    <th class="border border-primary-300"><x-button primary label="เรื่อง / Title" /></th>
                    <th class="border border-primary-300 w-64"><x-button primary label="แผนก / Department" /></th>
                    <th class="border border-primary-300 w-32"><x-button primary label="วันที่อบรม / Training Date" /></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $req)
                    <tr>
                        <td class="border border-primary-300 " cell-data="title">
                            <x-button label="{{$req->req_title}}" href="{{ route('training.show',['id'=>$req->req_code]) }}" />
                        </td>
                        <td class="border border-primary-300 md:text-center" cell-data="department">
                            <x-button label="{{ $req->user->department }}"/>
                                 {{-- wire:click="$set($filter_search, $req->user->department)"/> --}}
                        </td>
                        <td class="border border-primary-300 md:text-center" cell-data="date">
                            @isset($req->info->meta_value['start_date'])
                            {{ $req->info->meta_value['start_date'] }}
                            @endisset
                            @isset($req->info->meta_value['start_time'])
                            <x-badge label="{{ $req->info->meta_value['start_time'] }} " />
                            @endisset
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $requests->links() }}
    </div>
</div>
