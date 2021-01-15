<div class="ui clearing segment">
    <div class="ui icon message">
        <i class="pencil alternate icon"></i>
        <div class="content">
            <div class="header">
                {{ __('Belum Ada Isian Uji PME!') }}
            </div>
            <span>{{ __('Isian pengujian PME belum tersedia. Silakan lakukan pendaftaran pengujian PME atau cek jadwal pengisian.') }}</span>
            <br/>
        </div>
    </div>
    <a class="ui right floated primary button" href="{{ route('participant.invoice.show-create-form') }}">
        <i class="ui shopping cart icon"></i>
        {{ __('Daftar Uji PME') }}
    </a>

    <a class="ui right floated green button" href="{{ route('participant.submit.schedule') }}">
        <i class="ui calendar icon"></i>
        {{ __('Cek Jadwal Pengisian') }}
    </a>
</div>