<div id="resetPasswordContactPersonDialog" class="modal fade" role="dialog">

    <form method="post" id="resetPasswordContactPersonForm" action="{{ route('v1.administrator.contact-person.reset-password') }}">

        @csrf

        <input name="user-id" type="hidden" id="inputUserId">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ 'Reset Password ' }}<span id="userNameLabel"></span>{{ '?' }}</h4>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;&nbsp;{{ 'Batal' }}</button>

                    <button type="submit" class="btn btn-danger"><i class="fa fa-lock"></i>&nbsp;&nbsp;{{ 'Reset Password' }}</button>

                </div>

            </div>

        </div>

    </form>

</div>