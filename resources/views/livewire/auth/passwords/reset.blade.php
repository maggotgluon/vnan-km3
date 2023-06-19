@section('title', 'Reset password')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('home') }}">
            <x-logo class="w-auto h-48 mx-auto text-indigo-600" />
        </a>
    </div>

    <x-card title="Sign in to your account"
        shadow="shadow-xl"
        cardClasses="mt-8 sm:mx-auto sm:w-full sm:max-w-md bg-slate-200"
        class="grid gap-2 bg-slate-100">
        <x-slot name="header">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
                แก้ไขรหัสผ่าน
            </h2>
        </x-slot>

        <x-input label="อีเมลล์" wire:model.lazy="email" wire:keydown.Enter="resetPassword" required autofocus/>
        <x-inputs.password label="รหัสผ่าน" wire:model.lazy="password" wire:keydown.Enter="resetPassword"/>
        <x-inputs.password label="ยืนยันรหัสผ่าน" wire:model.lazy="passwordConfirmation" wire:keydown.Enter="resetPassword"/>

        <x-slot name="footer">
            <div class="flex justify-center items-center">
                <x-button label="แก้ไขรหัสผ่าน" primary wire:click="resetPassword"/>
            </div>
        </x-slot>
    </x-card>

</div>
