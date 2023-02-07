<?php
$path_to_db = "fridge.db";
$db = new SQLite3($path_to_db);

if(isset($_POST['submit-new-food'])) {
    $db->exec("INSERT INTO food(name, count) values('" . $_POST['new-food-name'] . "'," . $_POST['new-food-count'] . ")");
}

if(isset($_POST['plus'])) {
    $new_count = $db->querySingle("SELECT count FROM food WHERE id = " . $_POST["plus"] . "");
    $new_count++;
    $db->exec("UPDATE food SET count = " . $new_count . " WHERE id = " . $_POST["plus"]);

}

if(isset($_POST['minus'])) {
    $new_count = $db->querySingle("SELECT count FROM food WHERE id = " . $_POST["minus"] . "");
    $new_count--;
    $db->exec("UPDATE food SET count = " . $new_count . " WHERE id = " . $_POST["minus"]);

}

if(isset($_POST['delete'])) {
    $db->exec("DELETE FROM food WHERE id = " . $_POST["delete"] . "");
}





$food = $db->query("SELECT * FROM food");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Max's Fridge Contents</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php

    while ($food_item = $food->fetchArray()) {
        echo '
        <form class="food-row f' . ($food_item['id'] % 2) . '" id="' . $food_item['id'] . '" action="index.php" method="post">
            <h1 class="food-name">' . $food_item['name'] . '</h1>

            <div class="counter-wrapper">
                <button class="counter-button" value="' . $food_item['id']  . '" name="plus">+</button>
                <h1 class="food-count">' . $food_item['count'] . '</h1>
                <button class="counter-button" value="' . $food_item['id']  . '" name="minus">-</button>
                <button class="delete-button" value="' . $food_item['id']  . '" name="delete">Delete</button>
            </div>
            
        
        </form>
        ';
    }

    ?>

    <form class="food-row" action="index.php" method="post">
        <input type="text" placeholder="Food Name" name="new-food-name">
        <input type="number" name="new-food-count" id="" placeholder="Count">
        <button class="counter-button" name="submit-new-food">Submit</button>
    </form>
</body>
</html>