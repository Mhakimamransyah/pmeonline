@if ($errors->any())
    <script>
        toastr.options = {
            'positionClass': 'toast-bottom-right',
        };
    </script>
    @if ($errors->count() == 1)
        <script>
            toastr.error('{{ $errors->first() }}');
        </script>
    @else
        <script>
            toastr.error('{{ __('Terdapat ') . $errors->count() . __(' kesalahan. Mohon perbaiki isian.') }}');
        </script>
    @endif
@endif