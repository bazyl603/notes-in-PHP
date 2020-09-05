<?php

declare(strict_types=1);

namespace App;

require_once("src/Utils/debug.php");

$test = 'hola';

dump($test);

?>

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

        <div>
            notes
        </div>
    </section>

    <footer>
        How create?
    </footer>
</body>
</html>