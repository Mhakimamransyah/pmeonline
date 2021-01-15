@if(session()->has('success'))

    <script>
        toastr.options = {
            'positionClass': 'toast-bottom-right',
        };
        toastr.success('{{ session()->get('success') }}', '{{ __('Berhasil') }}');
    </script>

@endif