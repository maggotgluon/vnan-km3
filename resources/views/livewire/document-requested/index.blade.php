<div class="w-full p-2">
    <x-dialog class="absolute" z-index="z-50" blur="md" align="center" />
    Show All Request
    <div class="w-full bg-slate-100 overflow-x-auto soft-scrollbar">
        <table class="table-auto min-w-full border">
            <thead>
                <tr class="bg-primary-500 text-white">
                    <th class="w-32 border border-primary-300 hidden md:table-cell"><x-button primary label="No." /></th>
                    <th class="w-32 border border-primary-300 hidden md:table-cell"><x-button primary label="Request Objective" /></th>
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
                <td class="p-2 md:border border-primary-300 table-row-group md:table-cell text-left md:text-center" data-cell="No">{{ $req->getObjective() }}</td>
                <td class="p-2 md:border border-primary-300 table-row-group lg:table-cell md:whitespace-nowrap" data-cell="Detail">
                   <x-button label="{{ $req->req_title }}" :href="route('document.request.show',['id'=>$req->req_code])" />
                   <div>
                    <x-button label="edit" :href="route('document.request.edit',['id'=>$req->req_code])" />
                   </div>
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
                        <livewire:components.document-request-action :wire:key="$req->req_code" :code="$req->req_code"/>
                    </td>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $requests->links() }}
</div>
