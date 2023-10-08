<div class="w-full p-2">
    {{-- The whole world belongs to you. --}}
    Index
    <div class="w-full bg-slate-100 overflow-x-auto soft-scrollbar">
        <table class="table-auto min-w-full border">
            <thead>
                <tr class="bg-primary-500 text-white">
                    </th>
                    <th class="w-32 border border-primary-300 hidden md:table-cell">
                        <x-button primary label="Code" />
                    </th>
                    </th>
                    <th class="w-32 border border-primary-300 hidden md:table-cell">
                        <x-button primary label="Department" />
                    </th>
                    <th class="w-32 border border-primary-300 hidden lg:table-cell">
                        <x-button primary label="Effective Date" />
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $doc)
                <tr class="border border-primary-300 border-separate">
                    <td class="p-2 md:border border-primary-300 table-row-group lg:table-cell md:whitespace-nowrap" data-cell="Code">
                        <x-button
                            label="{{ $doc->doc_name_th }} / {{ $doc->doc_name_en }} "
                            :href="route('document.show',['id'=>$doc->doc_code])" />

                    </td>
                    <td class="p-2 md:border border-primary-300 table-row-group lg:table-cell md:whitespace-nowrap" data-cell="Department">
                        {{ $doc->department }}
                    </td>
                    <td class="p-2 md:border border-primary-300 table-row lg:table-cell text-left md:text-center" data-cell="Update">
                        <span class="lg:hidden">บังคับใช้ : </span>
                        {{ $doc->effective }}
                        <x-badge icon="clock" label="ปรับปรุงล่าสุด {{ carbon::parse($doc->updated_at)->toDateTimeString() }}" />
                    </td>

                @endforeach
            </tbody>
        </table>
    </div>
    {{ $documents->links() }}
</div>
