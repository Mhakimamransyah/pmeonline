<div id="createContactPersonDialog" class="modal fade" role="dialog">

    <form method="post" id="createContactPersonForm" action="{{ route('v1.administrator.contact-person.create') }}">

        @csrf

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ 'Tambah Personil Penghubung' }}</h4>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="createContactPersonName">{{ 'Nama Lengkap' }}</label>
                                <input class="form-control" type="text" id="createContactPersonName" name="contact-person-name" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="createContactPersonEmail">{{ 'Email' }}</label>
                                <input class="form-control" type="text" id="createContactPersonEmail" name="contact-person-email" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="createContactPersonPhone">{{ 'Nomor Telepon' }}</label>
                                <input class="form-control" type="text" id="createContactPersonPhone" name="contact-person-phone" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="createContactPersonPosition">{{ 'Jabatan' }}</label>
                                <input class="form-control" type="text" id="createContactPersonPosition" name="contact-person-position" required>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;&nbsp;{{ 'Batal' }}</button>

                    <button type="submit" class="btn btn-warning"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ 'Simpan' }}</button>

                </div>

            </div>

        </div>

    </form>

</div>