@section('title', 'Sign in to your account')

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
                เข้าสู่ระบบ {{ config('app.name') }}
            </h2>
        </x-slot>
        @if (Route::has('register'))
            <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
                Or
                <x-button href="{{ route('register') }}" label="create a new account" />
            </p>
        @endif
        <x-errors />

        <x-input label="หรัสพนักงาน" wire:model.lazy="username" wire:keydown.Enter="authenticate" autofocus/>
        <x-inputs.password label="รหัสผ่าน" wire:model.lazy="password" wire:keydown.Enter="authenticate"/>

        <x-checkbox label="จดจำ" wire:model.lazy="remember" wire:keydown.Enter="authenticate" />

        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <x-button label="คุณลืมรหัสผ่าน?" flat href="{{ route('password.request') }}"/>
                <x-button label="เข้าสู่ระบบ" primary wire:click="authenticate"/>
            </div>
        </x-slot>
    </x-card>
</div>
