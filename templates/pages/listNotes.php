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

        $page = $params['page'] ?? [];
        $size = $page['size'] ?? 10;
        $current = $page['number'] ?? 1;
        $pages = $page['pages'] ?? 1;

        $phrase = $params['phrase'] ?? null;
    ?>
        <div>
            <form class="sort-form" action="/" method="GET">
            <p>
                <input type="text" name="phrase" class="field-long field-title search" <?php echo $phrase ?> />
                <input type="submit" value="Search" class="add-btn sort-btn" />
            </p>
                <p>Sort by: <br>
                <label><span class="form-d">title: </span><input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?> /></label>
                <label><span class="form-d">date: </span><input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked' : '' ?> /></label>
                </p>
                <p>Direction: <br>
                <label><span class="form-d">up: </span><input name="sortorder" type="radio" value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?> /></label>
                <label><span class="form-d">down: </span><input name="sortorder" type="radio" value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?> /></label>
                </p>
                <p>Show size: <br>
                <select name="pagesize">
                    <option value="10" <?php echo $size === 10 ? 'checked' : '' ?>>10</option>
                    <option value="1" <?php echo $size === 1 ? 'checked' : '' ?>>1</option>
                    <option value="5" <?php echo $size === 5 ? 'checked' : '' ?>>5</option>
                    <option value="25" <?php echo $size === 25 ? 'checked' : '' ?>>25</option>
                </select></p>    
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

    <?php
        $paginationUrl = "&phrase=$phrase&pagesize=$size?sortby=$by&sortorder=$order";
    ?>

    <div class="pagination">
    <?php if ($current !== 1) : ?>
    <a href="/?page=<?php echo $current - 1 . $paginationUrl ?>">
        <button class="pag-btn"><</button>
    </a> 
    <?php endif; ?>   
    <?php for ($i = 1; $i <= $pages; $i++) : ?>
        <a href="/?page=<?php echo $i . $paginationUrl ?>">
            <button class="pag-btn"><?php echo $i; ?></button>
        </a>
    <?php endfor; ?> 
    <?php if ($current < $pages) : ?>   
    <a href="/?page=<?php echo $current + 1 . $paginationUrl ?>">
        <button class="pag-btn">></button>
    </a>
    <?php endif; ?>
    </div>    
</div>
<!-- js -->
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