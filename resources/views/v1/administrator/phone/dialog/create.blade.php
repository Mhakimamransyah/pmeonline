@php
$phoneTypes = \App\PhoneType::all();
@endphp


<div id="createPhoneDialog" class="modal fade" role="dialog">

    <form method="post" id="createPhone" action="{{ route('v1.administrator.contact-person.item.append-phone') }}">

        @csrf

        <input type="hidden" name="contact-person-id" id="contactPersonId"/>

        <input type="hidden" name="phone-id" id="phoneId"/>

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="createPhoneDialogTitle">{{ 'Tambah Nomor Telepon' }}</h4>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phoneType">{{ 'Tipe' }}</label>
                                <select class="form-control select2" id="phoneType" name="phone-type" style="width: 100%;" required>
                                    <option></option>
                                    @foreach($phoneTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="phoneNumber">{{ 'Nomor' }}</label>
                                <input class="form-control" type="text" id="phoneNumber" name="phone-number" placeholder="{{ 'Masukkan nomor telepon' }}" required>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;&nbsp;{{ 'Batal' }}</button>

                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ 'Simpan' }}</button>

                </div>

            </div>

        </div>

    </form>

</div>