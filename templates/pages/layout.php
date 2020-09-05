<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note</title>
</head>
<body>
    <nav>
        Navigation to creat
    </nav>

    <section>
        <div class="menu">
            <ul>
                <li><a href="/">List of notes</a></li>
                <li><a href="/?action=create">Create note</a></li>
            </ul>
        </div>
    <?php
        require_once("templates/pages/$page.php");
    ?>    
    </section>

    <footer>
        Who create? You create!
    </footer>
</body>
</html>