<div class="ui divider"></div>

<div class="ui error message">
    <h4>Sebagai Administrator, Anda dapat :</h4>
    <ul>
        <li>memeriksa jawaban peserta, </li>
        <li>mengedit jawaban peserta,</li>
        <li>mengembalikan jawaban peserta agar peserta dapat mengedit jawaban kembali,</li>
        <li>mengirim jawaban peserta agar instalasi dapat melakukan evaluasi terhadap jawaban peserta.</li>
    </ul>
    <p><strong>Sangat disarankan untuk menyimpan lembaran hasil pemeriksaan dalam bentuk <i>soft copy</i>.</strong></p>
    <br/>
    <a class="ui right floated button" href="{{ route('administrator.submit.preview', ['order_id' => request('order_id')]) }}" target="_blank">
        <i class="search icon"></i>
        Preview Tersimpan
    </a>
    <button class="ui right floated primary button" type="submit" form="submit-form" name="save" style="margin-right: 4px">
        <i class="save icon"></i>
        Simpan
    </button>
    @if($submit->sent)
        <button class="ui right floated button" style="margin-right: 4px" type="submit" form="submit-form" name="sent" value="0">
            <i class="reply icon"></i>
            Kembalikan
        </button>
    @else
        <button class="ui right floated green button" style="margin-right: 4px" type="submit" form="submit-form" name="sent" value="1">
            <i class="send icon"></i>
            Kirim
        </button>
    @endif

    @if($submit->verified)
        <button class="ui right floated button" style="margin-right: 4px" type="submit" form="submit-form" name="verified" value="0">
            <i class="reply all icon"></i>
            Batalkan Verifikasi
        </button>
    @else
        <button class="ui right floated purple button" style="margin-right: 4px" type="submit" form="submit-form" name="verified" value="1">
            <i class="check icon"></i>
            Verifikasi
        </button>
    @endif

    <br/>
    <br/>
</div>