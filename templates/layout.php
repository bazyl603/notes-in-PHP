<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/public/style.css" rel="stylesheet">
    <title>Notes</title>
</head>

<body>

    <article>
        <nav>
            <ul>
                <li><a href="/">List</a></li>
                <li><a href="/?action=create">Add</a></li>
            </ul>
        </nav>

        <section>
            <?php require_once("templates/pages/$page.php"); ?>
        </section>
    </article>

    <footer>
        Who create? Łukasz Pietrowski!
    </footer>
    
</body>

</html>