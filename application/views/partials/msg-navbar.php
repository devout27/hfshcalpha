<div class="container h-100 py-2">
    <ul class="nav nav-tabs nav-fill border-0" id="" role="">
        <li class="nav-item">
            <a class="nav-link  border border-muted border-bottom-0"  href="/game/messages" role="tab" aria-controls="inbox" aria-selected="true">Inbox (<?= $msg_inbox_unread ?: '0' ?>)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border border-muted border-bottom-0"  href="/game/messages#sent" role="tab" aria-controls="sent" aria-selected="false">Sent Messages</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border border-muted border-bottom-0"  href="/game/messages#compose" role="tab" aria-controls="compose" aria-selected="false">Compose</a>
        </li>
        <li class="nav-item">
            <a class="nav-link border border-muted border-bottom-0"  href="/game/messages#notices" role="tab" aria-controls="notices" aria-selected="false">Game Notices (0)</a>
        </li>
    </ul>
</div>
