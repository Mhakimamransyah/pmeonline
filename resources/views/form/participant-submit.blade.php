<div class="ui divider"></div>

<div class="ui error message">
    <h4>Pastikan Sebelum Mengirim</h4>
    <p>Sebelum mengirim hasil pemeriksaan, pastikan Anda telah melaksanakan pemeriksaan sesuai dengan petunjuk teknis dan mengisi formulir dengan benar.</p>
    <p>Hindari kesalahan-kesalahan umum, seperti :</p>
    <ul>
        <li>salah menggunakan koma desimal (harap gunakan tanda titik (.) sebagai pemisah desimal, dan jangan gunakan pemisah ribuan), </li>
        <li>salah mengeja nama spesies,</li>
        <li>salah menggunakan satuan hitung,</li>
        <li>atau kesalahan lain yang menyebabkan berkurangnya penilaian terhadap hasil pemeriksaan laboratorium Saudara/i.</li>
    </ul>
    <p><strong>Sangat disarankan untuk menyimpan lembaran hasil pemeriksaan dalam bentuk <i>soft copy</i>.</strong></p>
    <a class="ui right floated button" href="{{ route('participant.submit.preview', ['order_id' => request('order_id')]) }}" target="_blank">
        <i class="search icon"></i>
        Preview Tersimpan
    </a>
    <button class="ui right floated secondary button" type="submit" form="submit-form" name="save" style="margin-right: 4px">
        <i class="save icon"></i>
        Simpan
    </button>
    <a class="ui right floated secondary button" href="{{ route('participant.submit.download', ['order_id' => request()->get('order_id')]) }}" style="margin-right: 4px">
        <i class="download icon"></i>
        Unduh
    </a>
    <a class="ui right floated secondary button" target="_blank" href="{{ route('participant.submit.print', ['order_id' => request()->get('order_id')]) }}" style="margin-right: 4px">
        <i class="print icon"></i>
        Cetak
    </a>
    <button class="ui right floated primary button" style="margin-right: 4px" type="submit" form="submit-form" name="send">
        <i class="send icon"></i>
        Kirim
    </button>

    <br/>
    <br/>
</div>