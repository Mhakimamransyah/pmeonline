<form method="post" action="{{ route('v1.administrator.contact-person.item.update', ['id' => $data->id]) }}">

    @csrf

    <div class="box box-success">
        <div class="box-header with-border">
            <div class="box-title">{{ 'Personil Penghubung' }}</div>
        </div>
        <div class="box-body">
            <div class="row">

                <div class="col-xs-12 form-group">
                    <label for="contact-person-name">{{ 'Nama Lengkap' }}</label>
                    <input type="text" class="form-control" id="contact-person-name" name="contact-person-name" required value="{{ $data->user->name }}"/>
                </div>

                <div class="col-xs-6 form-group">
                    <label for="contact-person-email">{{ 'Email' }}</label>
                    <input type="email" class="form-control" id="contact-person-email" name="contact-person-email" required value="{{ $data->user->email }}"/>
                </div>

                <div class="col-xs-6 form-group">
                    <label for="contact-person-position">{{ 'Jabatan' }}</label>
                    <input type="text" class="form-control" id="contact-person-position" name="contact-person-position" required value="{{ $data->position }}"/>
                </div>

            </div>
        </div>
        <div class="box-footer text-right">
            <button type="submit" class="btn btn-info"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ 'Simpan' }}</button>
        </div>
    </div>

</form>