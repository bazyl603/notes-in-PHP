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
</div>
<script>
    const el = document.querySelector(".message");
    setTimeout(function(){            
        el.style.display = "none";
    }, 800);
</script>