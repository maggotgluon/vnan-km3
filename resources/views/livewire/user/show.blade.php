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
                <div class="grid md:grid-cols-3 gap-2 items-center">
                    
                    <div class="md:col-span-2"><x-input label="ชื่อ" wire:model="userdata.name"/></div>
                    @can('manage_users')
                        <x-input label="รหัสพนักงาน" wire:model="userdata.staff_id"/>
                    @else
                        รหัสพนักงาน : {{ $user->staff_id }}
                    @endcan
                    <x-input label="Email" wire:model="userdata.email"/>
                    
                    @can('manage_users')
                        <div class="md:col-span-2"><x-input label="ตำแหน่ง" wire:model="userdata.position"/></div>
                    @else
                        แผนก : {{ $user->department }}
                    @endcan

                    @can('manage_users')
                    <x-native-select label="แผนก" 
                    wire:model="userdata.department">
                        @foreach ($departmentList as $department)
                            <option value="{{$department->department}}">{{$department->department}}</option>
                        @endforeach
                    </x-native-select>
                    @else
                        ตำแหน่ง : {{ $user->position }}
                    @endcan
                    {{-- <x-input label="แผนก" wire:model="userdata.department"/> --}}
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


                    @can('manage_users')
                    <x-input label="ระดับผู้ใช้" wire:model="userdata.user_level"/>
                    {{-- <x-native-select label="ระดับผู้ใช้" 
                    wire:model="userdata.department_head">
                        @foreach ($HODList as $HOD)
                            <option value="{{$HOD->id}}">{{$HOD->name}}</option>
                        @endforeach
                    </x-native-select> --}}
                    @else
                        ระดับผู้ใช้ : {{ $user->user_level->name }}
                    @endcan
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
                @if($self|| Gate::allows('manage_users'))
                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <x-button label="เปลี่ยนแปลงรหัสผ่าน" wire:click="togglePassword" />
                        @if ($editmode)
                        <x-button p label="บันทึก" wire:click="editProfile" />
                        @else
                        <x-button label="แก้ไข" wire:click="toggleEditMode" />
                        @endif
                    </div>
                </x-slot>
                @endif

            </x-card>

            @if($self&& $editpassword)
            <x-card title="Password" cardClasses="mb-4" class="grid md:grid-cols-3 gap-2">
            <div><p>
                กำขหนดรหัสผ่าน
                <ul>
                    <li>จะต้องมีความยาวอย่างน้อย 6 ตัวอักษร </li>
                    <li>ประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์เล็ก และพิมพ์ใหญ่ </li>
                    <li>ตัวเลข อย่างน้อย 1 ตัวอักษร</li>
                    <li>อักระพิเศษ อย่างน้อย 1 ตัวอักษร</li>
                </ul>
            </p></div>
            <div class="md:col-span-2 grid gap-2">
            <x-inputs.password wire:model="userdata.currentPassword" label="Current Password"/>
            <x-inputs.password wire:model="userdata.newPassword" label="New Password"/>
            <x-inputs.password wire:model="userdata.newPassword_cf" label="Confirm New Password"/>
            </div>
            <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <x-button label="ยกเลิก" wire:click="togglePassword" />
                        <x-button label="บันทึก" wire:click="changePassword" />
                    </div>
            </x-slot>
            </x-card>
            @endif

            @if($selectuser->permissions)
            <x-card title="Spacial Permission" cardClasses="mb-4" class="grid md:grid-cols-3 gap-2">
                <ul class="col-span-3 ">
                @foreach($selectuser->permissions as $permission)
                    <li class="flex items-center">
                        {{$permission->permissions_type}} : {{$permission->parmission_name}} 
                        <span class="ml-auto">Status : </span>
                            @if($permission->allowance)
                            <x-icon name="check" class="w-5 h-5" /><x-button.circle icon="x"/>
                            @else
                            <x-icon name="x" class="w-5 h-5" /><x-button.circle icon="check"/>
                            @endif
                    </li>
                @endforeach
                </ul>
                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        {{-- <x-button label="ยกเลิก" wire:click="togglePassword" />
                        <x-button label="บันทึก" wire:click="changePassword" /> --}}
                    </div>
                </x-slot>
            </x-card>
            @endif
        </div>
    </div>



</div>
