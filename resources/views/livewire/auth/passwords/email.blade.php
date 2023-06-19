@section('title', 'Reset password')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('home') }}">
            <x-logo class="w-auto h-48 mx-auto text-indigo-600" />
        </a>
    </div>
    <x-dialog z-index="z-50" blur="md" align="center" />
    <x-card title="Reset password"
        shadow="shadow-xl"
        cardClasses="mt-8 sm:mx-auto sm:w-full sm:max-w-md bg-slate-200"
        class="grid gap-2 bg-slate-100">
        <x-slot name="header">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
                การกู้คืนรหัสผ่าน
            </h2>
        </x-slot>
        <p class="text-center">
            การกู้คืนรหัสผ่านจำเป็นต้องใช้อีเมลล์ <br>ที่เชื่อมต่อกับระบบ {{ config('app.name') }} <br>หากท่านไม่มีอีเมลล์ที่เชื่อมต่อ <br>กรุณาติดต่อหัวหน้างาน <br>หรือ เจ้าหน้าที่ ที่เกี่ยวข้อง
        </p>
        <x-input label="อีเมลล์" wire:model.lazy="email" wire:keydown.Enter="sendResetPasswordLink" required autofocus/>


        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <x-button label="กลับ" flat href="{{ route('login') }}"/>
                <x-button label="ส่ง link เพื่อเปลี่ยนรหัสผ่าน" primary wire:click="sendResetPasswordLink"/>
            </div>
        </x-slot>
    </x-card>

</div>
