<div>
    <x-dialog />
    <x-notifications />
    <div class="grid md:grid-cols-4 gap-2">
        <div class="h-max sticky top-24 hidden md:block">
            <h3>
                @switch($objective)
                @case('internal')
                ขึ้นทะเบียนการฝึกอบรม <br>
                <x-badge label="FM-LDS-008 / FM-LDS-009" />

                @break

                @case('external')
                ขึ้นทะเบียนการฝึกอบรมภายนอก <br>
                <x-badge label="FM-LDS-006" />
                @break
                @default

                @endswitch
            </h3>
            {{ $edit_mode?$req_id:'' }}
            <p>
                <span class="font-bold">ผู้เขียนคำร้อง</span><br>
                <span class="font-bold">ชื่อ </span> {{Auth::user()->name}}<br>
                <span class="font-bold">รหัสพนักงาน </span> {{Auth::user()->staff_id}}<br>
                <span class="font-bold">แผนก </span> {{Auth::user()->department}}<br>
                <span class="font-bold">หัวหน้าแผนก </span> {{Auth::user()->HOD()->name}}<br>
            </p>

            @if(env('APP_DEBUG'))
            <ul>
                @foreach($data as $key=>$value)
                <li>{{ $key }}:{!! getType($value)=='array'?implode(',',$value):nl2br(e($value)) !!}</li>
                @endforeach
            </ul>
            @endif
            <x-errors />

        </div>

        <div class="md:col-span-3">

            <x-native-select label="select Objective" wire:model.lazy="objective"
            class="my-2 {{$edit_mode?'pointer-events-none opacity-50':''}}">
                <option value="null" label="Select Objective" />

                <option value="1" label="ขอออกเอกสารใหม่ - New Registration/Document" />
                <option value="2" label="ขอเปลี่ยนแปลง/แก้ไขเอกสาร - Revision" />
                <option value="3" label="ขอยกเลิก - Canclation" />
                <option value="4" label="ขอทำลายบันทึกเอกสาร - Destruction" />
                <option value="5" label="ขอสำเนาเอกสารเพิ่มเติม - Additional Copy" />
                <option value="6" label="ขอนำเอกสารภายนอกเข้าระบบ - Register for External Document" />

                <option value="7" label="บีนทึกเอกสาร - Records" />

            </x-native-select>


            <div class="mt-4">
                {{-- {{$objective}} --}}
                @switch($objective)
                @case(1)
                <!-- create -->
                <x-card title="ขอออกเอกสารใหม่ - New Registration/Document">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="col-span-2">
                            <x-native-select label="ประเภทเอกสาร" wire:model.lazy="data.type">
                                <option value="nulled">Please select Document Type</option>
                                <!-- <optgroup label="Document"> -->
                                <option value="SM">Document-SM</option>
                                <option value="PR">Document-PR</option>
                                <option value="WI">Document-WI</option>
                                <option value="SD">Document-SD</option>
                                <option value="SP">Document-SP</option>
                                <option value="DS">Document-DS/KM</option>
                                <option value="FM">Document-FM</option>
                                <!-- </optgroup> -->
                                <!-- <optgroup label="Form">
                                    <option value="ADM">Form-ADM</option>
                                    <option value="ENG">Form-ENG</option>
                                    <option value="HRM">Form-HRM</option>
                                    <option value="Other">Form-Other</option>
                                </optgroup> -->
                                <!-- <optgroup label="External">
                                    <option disabled="" value="Report">External-Report</option>
                                </optgroup> -->
                                <!-- <optgroup label="Record">
                                    <option disabled="" value="KPIs">Record-KPIs</option>
                                    <option disabled="" value="Risk">Record-ISO9001</option>
                                    <option disabled="" value="Rish">Record-ISO45001</option>
                                    <option disabled="" value="Chemical">Record-Chemical</option>
                                    <option disabled="" value="Legal">Record-Legal</option>
                                    <option disabled="" value="Communication">Record-Plan</option>
                                    <option disabled="" value="Review">Record-Review</option>
                                    <option disabled="" value="Other">Record-Other</option>
                                </optgroup> -->
                                <!-- <optgroup label="Training">
                                    <option disabled="" value="diamond">Training-diamond</option>
                                    <option disabled="" value="unprotected">Training-unprotected</option>
                                    <option disabled="" value="consider">Training-consider</option>
                                </optgroup>      -->
                            </x-native-select>
                        </div>
                        <div class="col-span-2">
                            <x-input label="รหัสเอกสาร" placeholder="รหัสเอกสาร" mask="AAA-###" wire:model.lazy="data.code" prefix="{{$data['type']??'XX'}} - " style="padding-left:{{(strlen($data['type']??1)*1)+5}}ch" />
                            <!-- hint="{{$data['type']??''}} - {{$data['code']??''}}" -->
                        </div>
                        <div class="col-span-2">
                            <x-input label="ชื่อเอกสาร (ภาษาไทย)" placeholder="ชื่อเอกสาร (ภาษาไทย)" wire:model.lazy="data.name_th" hint="ชื่อเอกสาร (ภาษาไทย)" />
                        </div>
                        <div class="col-span-2">
                            <x-input label="ชื่อเอกสาร (ภาษาอังกฤษ)" placeholder="ชื่อเอกสาร (ภาษาอังกฤษ)" wire:model.lazy="data.name_en" hint="ชื่อเอกสาร (ภาษาอังกฤษ)" />
                        </div>

                        <div class="col-span-4">
                            <x-textarea label="คำอธิบาย" placeholder="คำอธิบาย" wire:model.lazy="data.discription" hint="คำอธิบาย" class="min-h-[30ch]" />
                        </div>
                        <div>

                            <x-datetime-picker without-time label="วันบังคับใช้" placeholder="วันบังคับใช้" :min="$mindate" display-format="D MMMM YYYY" clearable=false wire:model.lazy="data.effective" />
                            <!-- x-input label="วันบังคับใช้" type="date" min="{{$mindate}}"  wire:model.lazy="data.effective"/> -->
                        </div>
                        <div>
                            @isset($data['age'])
                            @if ($data['age'] < 0)
                                <x-input label="อายุเอกสาร" class="pointer-events-none" value="จนกว่าจะมีการเปลี่ยนแปลง " hint="อายุเอกสาร" />
                            @else
                                <x-input type="number" label="อายุเอกสาร" min="0" wire:model.lazy="data.age" hint="อายุเอกสาร" />
                            @endif
                            @endisset
                        </div>

                        <div class="col-span-2 grid gap-2">
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                @isset($data['file_pdf'])
                                <x-badge>
                                    <a href="{{asset($data['file_pdf'])}}"> PDF File</a>
                                </x-badge>
                                @endisset
                                <!-- File Input -->
                                <x-input label="Pdf" type="file" wire:model.lazy="data.file_pdf"
                                accept=".pdf" class="file:mr-2 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-primary-500 file:text-white
                                    hover:file:bg-primary-700"/>

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                            </div>

                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                @isset($data['file_word'])
                                <x-badge>
                                    <a href="{{asset($data['file_word'])}}"> Word File</a>
                                </x-badge>
                                @endisset
                                <!-- File Input -->
                                <x-input label="Word" type="file"
                                accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                                .xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                                wire:model.lazy="data.file_word"
                                                class="file:mr-2 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-primary-500 file:text-white
                                    hover:file:bg-primary-700"/>

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                            </div>
                        </div>

                        <x-slot name="footer">
                            <div class="flex justify-between items-center">
                                <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                                <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                            </div>
                        </x-slot>




                    </div>
                </x-card>
                @break
                @case(2)
                <!-- update -->
                <x-card title="ขอเปลี่ยนแปลง/แก้ไขเอกสาร - Revision">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="col-span-2">
                            {{-- {{$selectedDocument}} --}}
                            <x-native-select label="เลือกเอกสารที่ขึ้นทะเบียนแล้ว" wire:model.lazy="data.selectedDocument">
                                <option value="nulled">Please select Document to add revise</option>
                                @foreach ($documents as $doc)
                                <option value="{{ $doc->id }}"> {{ $doc->doc_code }} : {{ $doc->doc_name_th }}/{{ $doc->doc_name_en }}</option>
                                @endforeach
                            </x-native-select>
                        </div>
                        <div>

                            <x-datetime-picker without-time label="วันบังคับใช้" placeholder="วันบังคับใช้" :min="$mindate" display-format="D MMMM YYYY" clearable=false wire:model.lazy="data.effective" />
                            <!-- x-input type="date" label="วันบังคับใช้" placeholder="วันบังคับใช้" wire:model.lazy="data.effective" hint="วันบังคับใช้" /> -->
                        </div>
                        <div>
                            @if ($data['age'] < 0)
                            <x-input label="อายุเอกสาร" class="pointer-events-none" value="จนกว่าจะมีการเปลี่ยนแปลง " hint="อายุเอกสาร" />
                            @else <x-input type="number" label="อายุเอกสาร" placeholder="อายุเอกสาร" wire:model.lazy="data.age" hint="อายุเอกสาร" />
                            @endif
                        </div>

                        <div class="col-span-2">
                            <x-input label="ชื่อเอกสาร (ภาษาไทย)" placeholder="ชื่อเอกสาร (ภาษาไทย)" wire:model.lazy="data.name_th" hint="ชื่อเอกสาร (ภาษาไทย)" />
                        </div>
                        <div class="col-span-2">
                            <x-input label="ชื่อเอกสาร (ภาษาอังกฤษ)" placeholder="ชื่อเอกสาร (ภาษาอังกฤษ)" wire:model.lazy="data.name_en" hint="ชื่อเอกสาร (ภาษาอังกฤษ)" />
                        </div>

                        <div class="col-span-4">
                            <x-textarea label="คำอธิบาย" placeholder="คำอธิบาย" wire:model.lazy="data.discription" hint="คำอธิบาย" class="min-h-[30ch]" />
                        </div>

                        <div class="col-span-4 grid grid-cols-2 gap-2">
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <!-- File Input -->
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
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <!-- File Input -->
                                <x-input label="Word" type="file" wire:model.lazy="data.file_word" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                                .xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="file:mr-2 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-primary-500 file:text-white
                                    hover:file:bg-primary-700"/>

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="flex justify-between items-center">
                            <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                            <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                        </div>
                    </x-slot>
                </x-card>
                @break
                @case(3)
                <!-- removed -->
                <x-card title="ขอยกเลิก - Canclation">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="col-span-2">
                            <x-native-select label="เลือกเอกสารที่ขึ้นทะเบียนแล้ว" wire:model.lazy="data.selectedDocument">
                                <option value="nulled">Please select Document to add revise</option>
                                @foreach ($documents as $doc)
                                <option value="{{ $doc->id }}"> {{ $doc->doc_code }} : {{ $doc->doc_name_th }}/{{ $doc->doc_name_en }}</option>
                                @endforeach
                            </x-native-select>
                        </div>
                        <div class="col-span-2">
                            <x-datetime-picker without-time label="วันบังคับใช้" placeholder="วันบังคับใช้" :min="$mindate" display-format="D MMMM YYYY" clearable=false wire:model.lazy="data.effective" />
                            <!-- x-input label="วันบังคับใช้" placeholder="วันบังคับใช้" wire:model.lazy="data.effective" hint="วันบังคับใช้" /> -->
                        </div>

                        <div class="col-span-4">
                            <x-textarea label="คำอธิบาย" placeholder="คำอธิบาย" wire:model.lazy="data.discription" hint="คำอธิบาย" class="min-h-[30ch]" />
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="flex justify-between items-center">
                            <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                            <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                        </div>
                    </x-slot>
                </x-card>
                @break
                @case(4)
                <!-- Destruction  -->

                <x-card title="ขอทำลายบันทึกเอกสาร - Destruction">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="col-span-2">
                            <x-native-select label="เลือกเอกสารที่ขึ้นทะเบียนแล้ว" wire:model.lazy="data.selectedDocument">
                                <option value="nulled">Please select Document to add revise</option>
                                @foreach ($documents as $doc)
                                <option value="{{ $doc->id }}"> {{ $doc->doc_code }} : {{ $doc->doc_name_th }}/{{ $doc->doc_name_en }}</option>
                                @endforeach
                            </x-native-select>
                        </div>
                        <div class="col-span-2">

                            <x-datetime-picker without-time label="วันบังคับใช้" placeholder="วันบังคับใช้" :min="$mindate" display-format="D MMMM YYYY" clearable=false wire:model.lazy="data.effective" />
                            <!-- x-input label="วันบังคับใช้" placeholder="วันบังคับใช้" wire:model.lazy="data.effective" hint="วันบังคับใช้" /> -->
                        </div>

                        <div class="col-span-4">
                            <x-textarea label="คำอธิบาย" placeholder="คำอธิบาย" wire:model.lazy="data.discription" hint="คำอธิบาย" class="min-h-[30ch]" />
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="flex justify-between items-center">
                            <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                            <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                        </div>
                    </x-slot>
                </x-card>
                @break
                @case(5)
                <!-- Copy -->

                <x-card title="ขอสำเนาเอกสารเพิ่มเติม - Additional Copy">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="col-span-4">
                            <x-native-select label="เลือกเอกสารที่ขึ้นทะเบียนแล้ว" wire:model.lazy="data.selectedDocument">
                                <option value="nulled">Please select Document to add revise</option>
                                @foreach ($documents as $doc)
                                <option value="{{ $doc->id }}"> {{ $doc->doc_code }} : {{ $doc->doc_name_th }}/{{ $doc->doc_name_en }}</option>
                                @endforeach
                            </x-native-select>
                        </div>
                        <div class="col-span-1">
                            <x-input type="number" label="จำนวน" placeholder="จำนวน" wire:model.lazy="data.copy_number" hint="จำนวน" />
                        </div>

                        <div class="col-span-3">
                            <x-input label="สำหรับหน่วยงาน/พื้นที่" placeholder="สำหรับหน่วยงาน/พื้นที่" wire:model.lazy="data.discription" hint="สำหรับหน่วยงาน/พื้นที่" />
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="flex justify-between items-center">
                            <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                            <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                        </div>
                    </x-slot>
                </x-card>
                @break
                @case(6)
                <!-- Register External -->

                <x-card title="ขอนำเอกสารภายนอกเข้าระบบ - Register for External Document">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="col-span-2">
                            <x-native-select label="ประเภทเอกสาร" wire:model.lazy="data.type">
                                <option value="EX">External Document</option>
                            </x-native-select>
                        </div>
                        <div class="col-span-2">
                            <x-input label="รหัสเอกสาร" placeholder="รหัสเอกสาร" wire:model.lazy="data.code" prefix="{{$data['type']??'XX'}} - {{$year}} -" style="padding-left:{{(strlen($data['type']??1)*1)+strlen($year)+6.5}}ch" />
                            <!-- hint="{{$data['type']??''}} - {{$data['code']??''}}" -->
                        </div>
                        <div class="col-span-2">
                            <x-input label="ชื่อเอกสาร (ภาษาไทย)" placeholder="ชื่อเอกสาร (ภาษาไทย)" wire:model.lazy="data.name_th" hint="ชื่อเอกสาร (ภาษาไทย)" />
                        </div>
                        <div class="col-span-2">
                            <x-input label="ชื่อเอกสาร (ภาษาอังกฤษ)" placeholder="ชื่อเอกสาร (ภาษาอังกฤษ)" wire:model.lazy="data.name_en" hint="ชื่อเอกสาร (ภาษาอังกฤษ)" />
                        </div>

                        <div class="col-span-4">
                            <x-textarea label="คำอธิบาย" placeholder="คำอธิบาย" wire:model.lazy="data.discription" hint="คำอธิบาย" class="min-h-[30ch]" />
                        </div>
                        <div>

                            <x-datetime-picker without-time label="วันบังคับใช้" placeholder="วันบังคับใช้" :min="$mindate" display-format="D MMMM YYYY" clearable=false wire:model.lazy="data.effective" />
                            <!-- x-input label="วันบังคับใช้" placeholder="วันบังคับใช้" wire:model.lazy="data.effective" hint="วันบังคับใช้" /> -->
                        </div>
                        <div>
                            <x-input label="อายุเอกสาร" class="pointer-events-none" value="จนกว่าจะมีการเปลี่ยนแปลง " hint="อายุเอกสาร" />
                            <!-- x-input label="อายุเอกสาร" placeholder="อายุเอกสาร" wire:model.lazy="data.age" hint="อายุเอกสาร" /> -->
                        </div>

                        <div class="col-span-2 grid gap-2">
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <!-- File Input -->
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
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <!-- File Input -->
                                <x-input label="Word" type="file" wire:model.lazy="data.file_word" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                                .xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="file:mr-2 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-primary-500 file:text-white
                                    hover:file:bg-primary-700"/>

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <x-slot name="footer">
                        <div class="flex justify-between items-center">
                            <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                            <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                        </div>
                    </x-slot>
                </x-card>

                @break

                @break
                @case(7)
                <!-- Records -->

                <x-card title="บันทึกเอกสาร - Records">
                    <div class="grid md:grid-cols-4 gap-4">
                        <div class="col-span-1">
                            <x-native-select label="ประเภทเอกสาร" wire:model.lazy="data.rec_type">
                                <option value="nulled">Please select Document Type</option>
                                <option value="KPI">KPI</option>
                                <option value="RST">Risks 45001</option>
                                <option value="RQT">Risks 9001</option>
                                <option value="RMS">Risks MS</option>
                                <option value="LAW">Law and Compliance </option>
                                <option value="CMU">Communication Plan </option>
                                <option value="CHE">Chemical List </option>
                                <option value="DCC">Review Document </option>
                                <option value="REC">Review Record </option>
                                <option value="MNT">Management Review Report </option>
                                <option value="EMR">Emergency Plan </option>
                                <option value="POS">Policy Safety </option>
                                <option value="POQ">Policy Quailty</option>
                                <option value="POG">Policy GHPs</option>
                            </x-native-select>
                        </div>
                        @isset ($data['rec_type'])
                        <div class="col-span-1">
                            <x-native-select label="ฉบับจริงเก็บที่แผนก" wire:model.lazy="data.rec_department_store">
                                <option value="nulled">Please select Document Type</option>
                                <option value="ADS">ADS</option>
                                <option value="ENG">ENG</option>
                                <option value="EVS">EVS</option>
                                <option value="EXE">EXE</option>
                                <option value="FIN">FIN</option>
                                <option value="FBS">FBS</option>
                                <option value="HKS">HKS</option>
                                <option value="HRM">HRM</option>
                                <option value="ITS">ITS</option>
                                <option value="LND">LND</option>
                                <option value="LDS">LDS</option>
                                <option value="MKT">MKT</option>
                                <option value="OPT">OPT</option>
                                <option value="PUS">PUS</option>
                                <option value="RTS">RTS</option>
                                <option value="SAS">SAS</option>
                            </x-native-select>
                        </div>
                        @endisset

                        @isset ($data['rec_department_store'])
                        <div class="col-span-1">
                            <x-input label="ปี" placeholder="ปี" type="number" min="{{$year}}" step="1" wire:model.lazy="data.rec_effective" />
                        </div>
                        @endisset


                        <div class="col-span-4">
                            <x-textarea label="คำอธิบาย" placeholder="คำอธิบาย" wire:model.lazy="data.discription" hint="คำอธิบาย" class="min-h-[30ch]" />
                        </div>
                        <x-fileupload wire:model.lazy="data.file_pdf" accept=".pdf"/>
                        <div class="col-span-4" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <!-- File Input -->
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
                        <div class="hidden">
                            <x-input wire:model.lazy="data.code" />
                        </div>


                    </div>

                    <x-slot name="footer">
                        <div class="flex justify-between items-center">
                            <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                            <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                        </div>
                    </x-slot>
                </x-card>
                @break


                @break

                @default

                @endswitch
            </div>
        </div>
    </div>

</div>
