<div class="w-full">
    <h2 class="text-2xl font-bold pt-2 my-2">{{ $info['title'] }}</h2>
    <div class="mb-4">
        <x-badge icon="user" label="{{$instructor->name}}" />
        <x-badge icon="calendar" label="{{ $info['start_date'] }} {{$info['start_date']==$info['end_date']?'':' - '.$info['end_date']}}" />
        <x-badge icon="clock" label="{{ $info['start_time'] }} - {{ $info['end_time'] }}" />
    </div>
    @isset($info['filePDF'])
    <object data="{{ asset($info['filePDF']) }}" type="application/pdf" width="100%" height="600px">
        <p>Unable to display PDF file. <a href="{{ asset($info['filePDF']) }}">Download</a> instead.</p>
    </object>
    @endisset
</div>
