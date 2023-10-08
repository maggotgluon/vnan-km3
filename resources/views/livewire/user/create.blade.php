<div>
    <x-card title="ข้อมูลผู้ใช้งาน" cardClasses="mb-4">
        <div class="grid md:grid-cols-3 gap-2 items-center">
            
            <div class="md:col-span-2"><x-input label="ชื่อ" wire:model="userdata.name"/></div>
            <x-input label="รหัสพนักงาน" wire:model="userdata.staff_id"/>
            <x-input label="Email" wire:model="userdata.email"/>
            <div class="md:col-span-2"><x-input label="ตำแหน่ง" wire:model="userdata.position"/></div>
            <x-native-select label="แผนก" 
                wire:model="userdata.department">
                @foreach ($departmentList as $department)
                    <option value="{{$department->department}}">{{$department->department}}</option>
                @endforeach
            </x-native-select>
            <div class="md:col-span-2">
                {{-- <x-input label="หัวหน้าแผนก" wire:model="userdata.department_head"/> --}}
                <x-native-select label="หัวหน้าแผนก" 
                wire:model="userdata.department_head">
                    @foreach ($HODList as $HOD)
                        <option value="{{$HOD->id}}">{{$HOD->name}}</option>
                    @endforeach
                </x-native-select>
            </div>
            <hr class="my-4 md:col-span-3" />
            <x-input label="ระดับผู้ใช้" wire:model="userdata.user_level"/>
        </div>
        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <x-button label="ล้าง" wire:click="clearProfile" />
                <x-button label="บันทึก" wire:click="createProfile" />
            </div>
        </x-slot>
    </x-card>
</div>
