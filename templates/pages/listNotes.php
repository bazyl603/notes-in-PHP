<div>    
    <h4>List of notes</h4>  
    <div class="message">

        <?php
        if (!empty($params['before'])){
            switch ($params['before']){
                case 'created':
                    echo 'Note has been created!';
                    break;
                case 'edited':
                    echo 'Note has been edited!';
                    break;
                case 'deleted':
                    echo 'Note has been deleted!';
                break;
            }
        } 
        ?>

    </div>
    <div class="message error">

        <?php
        if (!empty($params['error'])){
            switch ($params['error']){
                case 'noteNotFound':
                    echo 'Trouble with the note!';
                    break;
                case 'missingNote':
                    echo 'Missing note!';
                    break;
            }
        } 
        ?>

    </div>

    <div class="notes">
        <?php foreach ($params['notes'] ?? [] as $note) : ?>
            <div class="show-note">
                <p class="show-date"><?php echo $note['created'] ?><p>
                <p class="delete-note"><a href="/?action=delete&id=<?php echo $note['id'] ?>" class="delete-note">delete</a></p>
                <p><?php echo $note['title'] ?></p>
                <p class="show-more"><a href="/?action=show&id=<?php echo $note['id'] ?>" class="show-more">show</a></p>                
            </div>
            <?php endforeach; ?>
    </div>
</div>

<script>
    const el = document.querySelectorAll(".message");
    setTimeout(function(){         
            el.forEach(function(el) {el.style.color = "transparent";});
    }, 800);
</script>