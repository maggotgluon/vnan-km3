<div class="w-full p-2">
    show all user
    <div class="flex gap-2 items-end my-2">
        <x-native-select
            label="Department"
            placeholder="Select one status"
            :options="['Active', 'Pending', 'Stuck', 'Done']"
            wire:model="model"
        />
        <x-native-select
            label="User level"
            placeholder="Select one status"
            :options="['Active', 'Pending', 'Stuck', 'Done']"
            wire:model="model"
        />
        <span class="ml-auto">
        <x-input label="search"/>
        </span>
        <x-button label="create new"/>
    </div>
    <div class="hidden">
        <x-badge flat red label="Laravel">
            <x-slot name="append" class="relative flex items-center w-2 h-2">
                <button type="button">
                    <x-icon name="x" class="w-4 h-4" />
                </button>
            </x-slot>
        </x-badge>
        <x-badge flat red label="Laravel">
            <x-slot name="append" class="relative flex items-center w-2 h-2">
                <button type="button">
                    <x-icon name="x" class="w-4 h-4" />
                </button>
            </x-slot>
        </x-badge>
        <x-badge flat red label="Laravel">
            <x-slot name="append" class="relative flex items-center w-2 h-2">
                <button type="button">
                    <x-icon name="x" class="w-4 h-4" />
                </button>
            </x-slot>
        </x-badge>
        <x-badge flat red label="Laravel">
            <x-slot name="append" class="relative flex items-center w-2 h-2">
                <button type="button">
                    <x-icon name="x" class="w-4 h-4" />
                </button>
            </x-slot>
        </x-badge>
    </div>
    <div class="w-full bg-slate-100 overflow-x-auto soft-scrollbar mt-4">
        <table class="table-auto min-w-full border">
        <thead>
                <tr class="bg-primary-500 text-white">
                <th class="w-32 border border-primary-300 hidden md:table-cell">Staff ID</th>
                <th>Name</th>
                <th class="w-32 border border-primary-300 hidden md:table-cell">Department</th>
                <th class="w-32 border border-primary-300 hidden md:table-cell">User level</th>
                <!-- <th>Quick Action</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="border border-primary-300 border-separate">
                <td class="p-2 md:border border-primary-300 inline-block md:table-cell text-left md:text-center">{{ $user->staff_id }}</td>
                <td class="p-2 md:border border-primary-300 inline-block md:table-cell text-lef">
                    <x-button label="{{ $user->name }}" href="{{route('user.show',['id'=>$user->staff_id])}}" />

                </td>
                <td class="p-2 md:border border-primary-300 block md:table-cell text-left md:text-center"><span class="md:hidden">แผนก </span>{{ $user->department }}</td>
                <td class="p-2 md:border border-primary-300 block md:table-cell text-left md:text-center"><span class="md:hidden">ระดับผู้ใช้งาน </span>{{ $user->user_level->name }}</td>
                <!-- <td>Quick Action</td> -->
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    {{ $users->links() }}
        <br>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
</div>
