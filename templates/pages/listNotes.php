<div>    
    <h4>List of notes</h4>  
    <div class="message">

        <?php
        if (!empty($params['before'])){
            switch ($params['before']){
                case 'created':
                    echo 'Note has been created!';
                break;
            }
        } 
        ?>

    </div>

    <div>
        <?php foreach ($params['notes'] as $note) : ?>
            <div class="show-note">
                <p class="show-date"><?php echo $note['created'] ?><p>
                <p><?php echo $note['title'] ?></p>
                <p class="show-more">more</p>
            </div>
            <?php endforeach; ?>
    </div>
</div>

<script>
    const el = document.querySelector(".message");
    setTimeout(function(){            
        el.style.color = "transparent";
    }, 800);
</script>