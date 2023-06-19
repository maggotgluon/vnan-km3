<div class="w-full p-2">
    My Training
    <x-dialog class="absolute" z-index="z-50" blur="md" align="center" />
    <div class="flex gap-2 my-4">
        <x-input wire:model="search" type="search" placeholder="Search posts by title..." />
        <x-native-select placeholder="แสดงทั้งหมด"
            :options="[
                ['name' => 'ฉบับร่าง/Draft',  'id' => 0],
                ['name' => 'รอการตรวจสอบ/Pending', 'id' => 1],
                ['name' => 'รอการอนุมัติ/Reviewed',   'id' => 2],
                ['name' => 'อนุมัติ/Approved',    'id' => 3],
                ['name' => 'ไม่อนุมัติ/Rejected',    'id' => -1],
            ]"
            option-label="name"
            option-value="id"
            wire:model="filter_status"/>
            <span class="ml-auto">
        <x-native-select
            :options="[
                ['name' => 'การฝึกอบรม - FM-LDS-008 / FM-LDS-009',  'id' => 'internal'],
                ['name' => 'การฝึกอบรมภายนอก - FM-LDS-006', 'id' => 'external'],
            ]"
            option-label="name"
            option-value="id"
            wire:model="filter_objective"/>
            </span>
    </div>

    <div class="w-full bg-slate-100 overflow-x-auto soft-scrollbar">
        <table class="table-auto min-w-full border">
            <thead>
                <tr class="bg-primary-500 text-white">
                    <th class="w-32 border border-primary-300 hidden md:table-cell"><x-button primary label="No." /></th>
                    <th class="border border-primary-300 "><x-button primary label="รายการ / Detail" /></th>
                    <th class="w-32 border border-primary-300 hidden lg:table-cell"><x-button primary label="ปรับแรุงเมื่อ / Update" /></th>
                    <th class="w-28 border border-primary-300 hidden lg:table-cell"><x-button primary label="สถานะ / Status" /></th>
                    <th class="w-52 border border-primary-300 hidden md:table-cell"><x-button primary label="Action" /></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $req)
                <tr class="border border-primary-300 border-separate">
                    <td class="p-2 md:border border-primary-300 table-row-group md:table-cell text-left md:text-center" data-cell="No">{{ $req->req_code }}</td>
                    <td class="p-2 md:border border-primary-300 table-row-group lg:table-cell md:whitespace-nowrap" data-cell="Detail">
                        <x-button label="{{ $req->req_title }}" :href="route('training.request.show',['id'=>$req->req_code])" />
                        <div>
                            @if($req->req_status=='0')
                            <x-button sm rounded label="edit" :href="route('training.request.edit',['id'=>$req->req_code])"/>
                            @endif
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
                        <!-- livewire:training-requested.view.fmlds008 :code="$req->req_code" />
                        livewire:training-requested.view.fmlds009 :code="$req->req_code" /> -->
                    </td>
                    <td class="p-2 md:border border-primary-300 table-row lg:table-cell text-left md:text-center" data-cell="Update">
                        <span class="lg:hidden">ปรับแรุงเมื่อ : </span>
                        {{ carbon::parse($req->updated_at)->toFormattedDateString() }}
                        <x-badge icon="clock" label="{{ carbon::parse($req->updated_at)->toTimeString() }}" />

                    </td>
                    <td class="p-2 md:border border-primary-300 table-row lg:table-cell text-left md:text-center" data-cell="Status">
                        <span class="lg:hidden">สถานะ : </span>
                        <x-badge color="{{ $req->getColor() }}" icon="tag" label="{{ $req->getStatus() }}" />

                    </td>
                    <td class="p-2 md:border border-primary-300 table-row-group md:table-cell" data-cell="Action">
                        <livewire:components.training-request-action :wire:key="$req->req_code" :code="$req->req_code"/>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $requests->links() }}
</div>
