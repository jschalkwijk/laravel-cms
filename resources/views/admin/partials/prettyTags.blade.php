{{--Selectize.js for adding tags on the fly --}}
{{--Script doesn't work properly when added via @push, then you will get the error that .selectize is not a function in your console --}}
<script type="text/javascript" src="{{ asset("/js/selectize/dist/js/standalone/selectize.js") }}"></script>
@push('scripts')
    <script type="text/javascript" src="{{ asset("/js/prettyTags.js") }}"></script>
@endpush
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("/js/selectize/dist/css/selectize.css") }}" />
@endpush