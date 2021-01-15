<div id="deletePhoneDialog" class="modal fade" role="dialog">

    <form method="post" id="deletePhoneForm" action="{{ route('v1.administrator.contact-person.item.delete-phone') }}">

        @csrf

        <input type="hidden" id="targetDeletePhoneId" name="phone-id">

        <input type="hidden" id="fromContactPersonId" name="contact-person-id">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ 'Hapus ' }}<span id="phoneNumberLabel"></span>{{ '?' }}</h4>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;&nbsp;{{ 'Batal' }}</button>

                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;{{ 'Hapus' }}</button>

                </div>

            </div>

        </div>

    </form>

</div>