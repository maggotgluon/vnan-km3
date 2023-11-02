<div class="w-full">
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
            <x-native-select label="เลือกประเภทเอกสาร / Select Objective" wire:model="objective"
            class="my-2 {{$edit_mode?'pointer-events-none opacity-50':''}}">
                <option value="null" label="เลือกประเภทเอกสาร / Select Objective" />

                <option value="internal" label="ขอขึ้นทะเบียนการฝึกอบรม - FM-LDS-008 / FM-LDS-009" />
                <option value="external" label="ขอขึ้นทะเบียนการฝึกอบรมภายนอก - FM-LDS-006" />

            </x-native-select>

            @switch($objective)
                @case('internal')
                    <div class="mt-4">
                    <x-card title="ขอขึ้นทะเบียนการฝึกอบรม - FM-LDS-008 / FM-LDS-009">
                        <form>
                        <div class="grid md:grid-cols-4 gap-4">
                                <h2 class="text-xl font-bold md:col-span-4">FM-LDS-008</h2>
                                <div class="md:col-span-4">
                                    <x-native-select
                                        label="ผู้สอน" hint="Instructor"
                                        :options="Auth::user()->colleague()"
                                        option-label="name"
                                        option-value="id"
                                        wire:model="data.instructor"
                                    />

                                </div>
                                <div class="md:col-span-4">
                                    <x-input wire:model.lazy="data.title" label="หัวข้อเรื่อง" hint="Subject" />
                                </div>

                                <div class="md:col-span-2 grid gap-4">

                                    <x-datetime-picker without-time
                                        label="วันเริ่มต้นการอบรม"
                                        placeholder="วันเริ่มต้นการอบรม"
                                        :min="$mindate"
                                        hint="Start End"
                                        display-format="D MMMM YYYY"
                                        wire:model="data.start_date"
                                    />
                                    <!-- x-input wire:model.lazy="data.start_date" type="date" label="วันที่เริ่มการอบรม" hint="Date Strat" min="{{$mindate}}" /> -->
                                    <x-input wire:model.lazy="data.start_time" type="time" label="เริ่มเวลา" hint="Time Strat" step="600"/>
                                </div>
                                <div class="md:col-span-2 grid gap-4">

                                    <x-datetime-picker without-time
                                        label="วันสิ้นสุดการอบรม"
                                        placeholder="วันสิ้นสุดการอบรม"
                                        :min="$data['start_date']??$mindate"
                                        hint="Date End"
                                        display-format="D MMMM YYYY"
                                        wire:model="data.end_date"
                                    />
                                    <!-- x-input wire:model.lazy="data.end_date" type="date" label="วันสิ้นสุดการอบรม" hint="Date End" min="{{$data['start_date']??$mindate}}" /> -->
                                    <x-input wire:model.lazy="data.end_time" type="time" label="เวลาสิ้นสุด" hint="Time End" step="600"/>
                                </div>
                                <div class="md:col-span-4">
                                    <x-textarea wire:model.lazy="data.objective" label="วัตถุประสงค์" hint="Objective" >
                                        @isset($data['objective'])
                                        {{nl2br($data['objective'])}}
                                        @endisset
                                    </x-textarea>

                                </div>

                                <div class="md:col-span-3">
                                    <x-textarea wire:model.lazy="data.subjectDetailsDiscription" label="เนื้อหาการอบรบ" hint="Subject Details Discription" />
                                </div>
                                <x-input wire:model.lazy="data.information_time" type="number" label="เวลา(นาที)" hint="Duration" />

                                <div class="md:col-span-3">
                                    <x-textarea wire:model.lazy="data.activityDiscription" label="กิจกรรมในการอบรม" hint="Activity" />
                                </div>
                                <x-input wire:model.lazy="data.activity_time" type="number" label="เวลา(นาที)" hint="Duration" />

                                <div class="md:col-span-3">
                                    <x-textarea wire:model.lazy="data.evaluateDiscription" label="การประเมินผล" hint="Assessment" />
                                </div>
                                <x-input wire:model.lazy="data.evaluate_time" type="number" label="เวลา(นาที)" hint="Duration" />

                                <div class="md:col-span-4">
                                    <x-textarea wire:model.lazy="data.Remark" label="หมายเหตุ" hint="Remark" />
                                </div>

                                <h2 class="text-xl font-bold">FM-LDS-009</h2>

                                <p class="md:col-span-4">
                                    แนวทางการประเมินผลการอบรมในการปฏิบัติงาน / Assessment process :
                                </p>

                                <x-checkbox id="right-label 1" label="ถาม-ตอบ" wire:model.lazy="data.assessmentProcess.0" value="ถาม-ตอบ"/>
                                <x-checkbox id="right-label 2" label="แบบทดสอบ" wire:model.lazy="data.assessmentProcess.1" value="แบบทดสอบ"/>
                                <x-checkbox id="right-label 3" label="ทดลองปฏิบัติงานจริง" wire:model.lazy="data.assessmentProcess.2" value="ทดลองปฏิบัติงานจริง"/>

                                <div class="md:col-span-4">
                                    <strong> หมายเหตุ :</strong>
                                    <ol class="list-decimal	list-inside	">
                                        <li>กรณีที่เป็นการถามตอบ กรุณาระบุคำถามและคำตอบโดยคร่าวพร้อมเกณฑ์การผ่านประเมิน</li>
                                        <li>กรณีที่เป็นการทดสอบ กรุณาแนบแบบทดสอบพร้อมระบุเกณฑ์การผ่านประเมิน</li>
                                        <li>กรณีที่เป็นการทดลองปฏิบัติงานจริง กรุณาระบุกิจกรรมพร้อมเกณฑ์การผ่านประเมิน</li>
                                    </ol>
                                    <x-textarea wire:model.lazy="data.assessmentTools" label="คำถาม/แบบทดสอบ/หัวข้อการปฏิบัติงาน" hint="Assessment Tools :"/>
                                </div>
                                <div class="md:col-span-4">
                                    เกณฑ์การประเมิน / Assessment Criteriament :

                                    <x-textarea wire:model.lazy="data.criteriamentPass" label="ผ่าน" />

                                    <x-textarea wire:model.lazy="data.criteriamentNopass" label="ไม่ผ่าน" />
                                </div>
                                <div class="md:col-span-4"
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                >
                                    @isset ($data['filePDF'])
                                        File already upload {{$data['filePDF']}}
                                    @endisset
                                        <!-- File Input -->
                                        <!-- accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                                .xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" -->
                                        <x-input type="file" label="เอกสารประกอบ" hint="File PDF"
                                            accept=".pdf"
                                            wire:model="data.filePDF">
                                        <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </x-input>
                                    
                                </div>
                            </div>
                        </form>
                        <!-- x-form> -->
                        <x-slot name="footer">
                            <div class="flex justify-between items-center">
                                <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                                <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                            </div>
                        </x-slot>
                    </x-card>
                    </div>
                @break
                @case('external')
                    <div class="mt-4">
                    <x-card title="ขอขึ้นทะเบียนการฝึกอบรมภายนอก - FM-LDS-006">

                        <div class="grid md:grid-cols-4 gap-4">
                            <div class="md:col-span-4">
                                    <x-native-select
                                        label="ผู้เข้าอบรม"
                                        hint="Trainee"
                                        :options="Auth::user()->colleague()"
                                        option-label="name"
                                        option-value="id"
                                        wire:model="data.instructor"
                                    />

                            </div>
                            <div class="md:col-span-4">
                            <!-- camel{{ Illuminate\Support\Str::camel($data['title']??'') }}<br>
                            kebab{{ Illuminate\Support\Str::kebab($data['title']??'') }}<br>
                            replace{{ Illuminate\Support\Str::replace(' ','-',$data['title']??'') }}<br>
                            slug{{ Illuminate\Support\Str::slug($data['title']??'') }}<br>
                            snake{{ Illuminate\Support\Str::snake($data['title']??'') }}<br> -->
                                <x-input wire:model="data.title" label="หัวข้อเรื่อง" hint="Training Program/Seminar"/>
                            </div>
                            <div class="md:col-span-1">
                                <x-datetime-picker without-time
                                    label="วันที่เริ่มการอบรม"
                                    placeholder="วันที่เริ่มการอบรม"
                                    hint="Date Strat"
                                    display-format="D MMMM YYYY"
                                    wire:model="data.start_date"
                                />
                                <!-- x-input type="date" wire:model="data.start_date" label="วันที่เริ่มการอบรม" hint="Date Strat" /> -->
                            </div>
                            <div class="md:col-span-1">
                                <x-datetime-picker without-time
                                    label="วันสิ้นสุดการอบรม"
                                    placeholder="วันสิ้นสุดการอบรม"
                                    :min="$data['start_date']"
                                    hint="Date End"
                                    display-format="D MMMM YYYY"
                                    wire:model="data.end_date"
                                />
                                <!-- x-input type="date" wire:model="data.end_date" label="วันสิ้นสุดการอบรม" hint="Date End" /> -->
                            </div>
                            <div class="md:col-span-1">
                                <x-input type="number" min=1 wire:model="data.duration" label="ระยะเวลา (ชัวโมง)" hint="Training Duration (hrs.)" />
                            </div>
                            <div class="md:col-span-1">
                                <x-input label="สถานที่การอบรม" hint="Training Venue" wire:model="data.venue" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input label="วิทยากร" hint="Training Lecturer" wire:model="data.lecturer" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input label="สถาบัน" hint="Training Institution" wire:model="data.institution" />
                            </div>


                            <div class="md:col-span-4">
                                <x-textarea label="มีเนื้อหาโดยสังเขป" hint="Hightlihts of training program/seminar" wire:model="data.Hightlihts" />
                            </div>

                            <div class="md:col-span-4">
                                <x-textarea label="แนวทางการนำมาประยุกต์ในงาน" hint="Application of new learning on the job" wire:model="data.applic_action" />
                            </div>

                            @isset($data['title'])
                            <div class="md:col-span-2"
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                >
                                    <!-- File Input -->
                                    <x-input type="file" label="เอกสารประกอบ" hint="เอกสาร PDF"
                                        accept=".pdf"
                                        wire:model="data.filePDF"
                                        class="file:mr-2 file:py-2 file:px-4
                                                file:rounded-full file:border-0
                                                file:text-xs file:font-semibold
                                                file:bg-primary-500 file:text-white
                                                hover:file:bg-primary-700">

                                    <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </x-input>
                            </div>

                            <div class="md:col-span-2"
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                >
                                    <!-- File Input -->
                                    <x-input type="file" label="ใบประกาศ" hint="เอกสาร ใบประกาศ PDF"
                                        accept=".pdf"
                                        wire:model="data.filePDF-certificate"
                                        class="file:mr-2 file:py-2 file:px-4
                                                file:rounded-full file:border-0
                                                file:text-xs file:font-semibold
                                                file:bg-primary-500 file:text-white
                                                hover:file:bg-primary-700">

                                    <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </x-input>
                            </div>
                            @endisset

                        </div>

                        <x-slot name="footer">
                            <div class="flex justify-between items-center">
                                <x-button label="บันทึกฉบับร่าง" flat negative wire:click="savedraft" />
                                <x-button label="ยื่นส่งเอกสาร" primary wire:click="submit" />
                            </div>
                        </x-slot>
                        </x-card>
                    </div>
                @break

                @default


                @endswitch
        </div>
    </div>
</div>
