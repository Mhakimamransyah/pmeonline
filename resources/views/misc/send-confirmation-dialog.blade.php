<div class="modal fade" tabindex="-1" role="dialog" id="{{ 'save-confirmation-dialog' }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title" style="color: red">Pastikan Sebelum Mengirim</h1>
            </div>
            <div class="modal-body">
                <p>Sebelum mengirim hasil pemeriksaan, pastikan Anda telah melaksanakan pemeriksaan sesuai dengan petunjuk teknis dan mengisi formulir dengan benar.</p>
                <p>Hindari kesalahan-kesalahan umum, seperti :</p>
                    <ul>
                        <li>salah menggunakan koma desimal (harap gunakan tanda titik (.) sebagai pemisah desimal, dan jangan gunakan pemisah ribuan), </li>
                        <li>salah mengeja nama spesies,</li>
                        <li>salah menggunakan satuan hitung,</li>
                        <li>atau kesalahan lain yang menyebabkan berkurangnya penilaian terhadap hasil pemeriksaan laboratorium Saudara/i.</li>
                    </ul>
                <p><strong>Sangat disarankan untuk menyimpan lembaran hasil pemeriksaan dalam bentuk <i>soft copy</i>.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Periksa Kembali</button>
                <button type="submit" name="save_and_preview" value="1" class="btn btn-default">Tinjau Cetak (<i>soft copy</i>)</button>
                <button type="submit" class="btn btn-primary" value="1" name="sent">Kirim</button>
            </div>
        </div>
    </div>
</div>
