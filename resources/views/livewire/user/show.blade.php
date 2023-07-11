<div class="w-full">
    <div class="grid md:grid-cols-4 gap-2">
        <div class="h-max sticky top-24 hidden md:block">
            <x-icon name="user-circle"/>
        </div>

        <div class="md:col-span-3">
            <x-card title="ข้อมูลผู้ใช้งาน" cardClasses="mb-4">

                {{-- <x-slot name="action">
                    <x-dropdown>
                        <x-dropdown.header label="Settings">
                            <x-dropdown.item label="Preferences" />
                            <x-dropdown.item label="My Profile" />
                        </x-dropdown.header>

                        <x-dropdown.item separator label="Help Center" />
                        <x-dropdown.item label="Live Chat" />
                        <x-dropdown.item label="Logout" />
                    </x-dropdown>
                </x-slot> --}}

                @if ($editmode)
                <div class="grid md:grid-cols-3 gap-2">
                    
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
                    <x-input label="แผนก" wire:model="userdata.department"/>
                    <div class="md:col-span-2">
                        <x-input label="หัวหน้าแผนก" wire:model="userdata.department_head"/>
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
                @else
                    <p>
                    ชื่อ : {{ $user->name }}<br>
                    รหัสพนักงาน : {{ $user->staff_id }}<br>
                    Email : {{ $user->email }}<br>
                    ตำแหน่ง : {{ $user->position }}<br>
                    แผนก : {{ $user->department }}<br>
                    หัวหน้าแผนก : {{ $user->HOD()->name }}<br>
                    </p>
                    <hr class="my-4"/>
                    <p>
                    ระดับผู้ใช้ : {{ $user->user_level->name }}<br>
                    </p>
                @endif
                @if($self)
                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <x-button label="เปลี่ยนแปลงรหัสผ่าน" wire:click="togglePassword" />
                        @if ($editmode)
                        <x-button p label="บันทึก" wire:click="toggleEditMode" />
                        @else
                        <x-button label="แก้ไข" wire:click="toggleEditMode" />
                        @endif
                    </div>
                </x-slot>
                @endif

            </x-card>

            @if($self)
            <x-card title="Password" cardClasses="mb-4" class="grid md:grid-cols-3 gap-2">
            <div><p>
                กำขหนดรหัสผ่าน
                <ul>
                    <li>จะต้องมีความยาวอย่างน้อย 8 ตัวอักษร </li>
                    <li>ประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์เล็ก ใหญ่ </li>
                    <li>ตัวเลข อย่างน้อย 1 ตัวอักษร</li>
                    <li>อักระพิเศษ อย่างน้อย 1 ตัวอักษร</li>
                </ul>
            </p></div>
            <div class="md:col-span-2 grid gap-2">
            <x-input label="Current Password"/>
            <x-input label="New Password"/>
            <x-input label="Confirm New Password"/>
            </div>
            <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <x-button label="ยกเลิก" wire:click="togglePassword" />
                        <x-button label="บันทึก" wire:click="toggleEditMode" />
                    </div>
            </x-slot>
            </x-card>
            @endif
        </div>
    </div>



</div>
