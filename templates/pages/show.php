<?php $note = $params['note'] ?? null; ?>
    <?php if($note): ?>
        <div class="show-note" id="show-one-note">
            <p class="show-date"><?php echo $note['created'] ?><p>
            <span class="edit"><a href="/?action=edit&id=<?php echo $note['id']; ?>" class="edit">edit</a></span>
            <p><?php echo htmlentities($note['title']) ?></p>
            <hr>
            <p class="show-description"><?php echo $note['description'] ?></p>
            <a href="/" class="show-more"><p class="show-more">back</p></a>
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
