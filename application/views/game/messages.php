
<div class="container h-100 py-2">
    <ul class="m-tabs nav nav-tabs nav-fill border-0" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active border border-muted border-bottom-0" id="inbox-tab" data-toggle="tab" href="#inbox" role="tab" aria-controls="inbox" aria-selected="true">Inbox (<?= $msg_inbox_unread ?: '0' ?>)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border border-muted border-bottom-0" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="false">Sent Messages</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border border-muted border-bottom-0" id="compose-tab" data-toggle="tab" href="#compose" role="tab" aria-controls="compose" aria-selected="false">Compose</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border border-muted border-bottom-0" id="notices-tab" data-toggle="tab" href="#notices" role="tab" aria-controls="notices" aria-selected="false">Game Notices (<?= $notices_unread ?: '0' ?>)</a>
        </li>
    </ul>

    <div class="tab-content h-75">
        <div class="tab-pane active h-100 p-3 border border-muted" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
        	<?= $inbox ?>
        </div>
        <div class="tab-pane h-100 p-3 border border-muted" id="sent" role="tabpanel" aria-labelledby="sent-tab">
        	<?= $sent ?>
        </div>

        <div class="tab-pane h-100 p-3 border border-muted" id="compose" role="tabpanel" aria-labelledby="compose-tab">
        	<?= $compose ?>
        </div>
        <div class="tab-pane h-100 p-3 border border-muted" id="notices" role="tabpanel" aria-labelledby="notices-tab">
        	<?= $notices ?>
        </div>
    </div>

</div>