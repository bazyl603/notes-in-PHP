<?php $note = $params['note'] ?? null; ?>
    <?php if($note): ?>
        <div class="show-note" id="show-one-note">
            <p class="show-date"><?php echo htmlentities($note['created']) ?><p>
            <p><?php echo htmlentities($note['title']) ?></p>
            <hr>
            <p class="show-description"><?php echo htmlentities($note['description']) ?></p>
            <p class="show-more"><a href="/" class="show-more">back</a></p>
        </div>

    <?php else : ?>
        <div class="show-note" id="show-one-note">
            <p class="show-date"><?php echo date('Y-m-d H:i:s') ?><p>
            <p>No note to display!</p>
            <hr>
            <p class="show-description"></p>
            <p class="show-more"><a href="/" class="show-more">back</a></p>
        </div>
    <?php endif; ?>     