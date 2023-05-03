<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{-- {{ config('app.name') }} --}}
<img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680058120/app/logo/DEXTER3_gdvvc9.png" alt="{{config('app.name')}} " style="height:100px; width:100px;"> 

</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{-- {{ $slot }} --}}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
