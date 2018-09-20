{{--Selectize.js for adding tags on the fly --}}
@push('scripts')
<script type="text/javascript" src="{{ asset("/js/selectize/dist/js/standalone/selectize.js") }}"></script>
<script type="text/javascript" src="{{ asset("/js/prettyTags.js") }}"></script>
@endpush
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("/js/selectize/dist/css/selectize.css") }}" />
@endpush