<header class="container m-auto flex items-center gap-4 fixed left-0 right-0 top-0 rounded-b-lg p-2 shadow-lg backdrop-blur z-30 bg-white/25">
    <a href="{{Route::currentRouteName()=='home'?'':route('home') }}">
        <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
    </a>
    <nav class="flex gap-2 w-full">
        <x-button flat label="หน้าหลัก" />

        <x-dropdown align="left">
            <x-slot name="trigger">
                <x-button flat label="เอกสาร" />
            </x-slot>

            <x-dropdown.item label="เอกสารขึ้นทะเบียน"
            :href="route('document.index')"/>
            <x-dropdown.item label="บีนทึกเอกสาร"
            :href="route('record.index')"/>

            <x-dropdown.item label="ขึ้นทะเบียนการเอกสาร"
            :href="route('document.request.create')" />
            <x-dropdown.item label="เอการของฉัน"
            :href="route('document.request.index')" />
        </x-dropdown>

        <x-dropdown align="left">
            <x-slot name="trigger">
                <x-button flat label="การอบรม" />
            </x-slot>

            <x-dropdown.item label="ขึ้นทะเบียนแล้ว"
            :href="route('training.index')"/>
            <x-dropdown.item label="ขึ้นทะเบียนการอบรม"
            :href="route('training.request.create')" />
            <x-dropdown.item label="การอบรมของฉัน"
            :href="route('training.request.index')" />
        </x-dropdown>


        <x-button flat label="ผู้ใช้งาน" :href="route('user.index')" />

        <div class="ml-auto">
            @auth
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-button.circle outline icon="user" primary />
                    </x-slot>

                    <x-dropdown.header label="{{Auth::user()->staff_id}}">
                        <x-dropdown.item label="ข้อมูลของฉัน" />
                </x-dropdown.header>

                <x-dropdown.item label="ออกจากระบบ" href="{{ route('logout') }}"/>
            </x-dropdown>
            @else

            <x-button href="{{ route('login') }}" label="Log in"/>
            @if (Route::has('register'))
            <x-button href="{{ route('register') }}" label="Register"/>
            @endif
            @endauth
        </div>
    </nav>
</header>
