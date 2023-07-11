<div class="col-span-4" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
    <!-- File Input -->
    @isset($data['file_pdf'])
    file
    @endisset
    <x-input label="Pdf" type="file" wire:model.lazy="data.file_pdf" accept=".pdf" class="file:mr-2 file:py-2 file:px-4
            file:rounded-full file:border-0
            file:text-xs file:font-semibold
            file:bg-primary-500 file:text-white
            hover:file:bg-primary-700"/>

        <!-- Progress Bar -->
        <div x-show="isUploading">
            <progress max="100" x-bind:value="progress"></progress>
        </div>
</div>