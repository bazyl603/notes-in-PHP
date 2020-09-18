<div>
<button id="btn-filter" class="add-btn sort-btn filter-btn">filter</button>     
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

    <?php
        $sort = $params['sort'] ?? [];
        $by = $sort['by'] ?? 'title';
        $order = $sort['order'] ?? 'desc';
    ?>
        <div>
            <form class="sort-form" action="/" method="GET">
                <p>Sort by: <br>
                <label><span class="form-d">title: </span><input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?> /></label>
                <label><span class="form-d">date: </span><input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked' : '' ?> /></label>
                </p>
                <p>Direction: <br>
                <label><span class="form-d">up: </span><input name="sortorder" type="radio" value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?> /></label>
                <label><span class="form-d">down: </span><input name="sortorder" type="radio" value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?> /></label>
                </p>
                <input type="submit" value="Sort" class="add-btn sort-btn" />
            </form>
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

    const filter = document.getElementById("btn-filter");
    const form = document.querySelector(".sort-form");
    let flag = false;
    filter.addEventListener('click', () =>{
        if (!flag){
            form.style.display = "block";
            flag = true;
        }else{
            form.style.display = "none";
            flag = false;
        }
    })
    
</script>