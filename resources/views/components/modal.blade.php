<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id . 'Title' }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="{{ $id . 'Title' }}">{{ $title }}</h4>
            </div>
            <div class="modal-body">
                {{ $prompt }}
            </div>
            <div class="modal-footer">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>