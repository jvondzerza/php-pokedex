<?php
$pokeId = 1;
$randomMoves = array_fill(0, 4, "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pokeId = $_POST["search"];
}

function fetchPokemonName($fetchId) {
    $data = file_get_contents("https://pokeapi.co/api/v2/pokemon/{$fetchId}");
    $pokedata = json_decode($data, true);
    $name = $pokedata["name"];
    return $name;
}

function fetchPokemonId($fetchId) {
    $data = file_get_contents("https://pokeapi.co/api/v2/pokemon/{$fetchId}");
    $pokedata = json_decode($data, true);
    $id = $pokedata["id"];
    return $id;
}

function fetchPokemonSprite($fetchId) {
    $data = file_get_contents("https://pokeapi.co/api/v2/pokemon/{$fetchId}");
    $pokedata = json_decode($data, true);
    $spriteList = $pokedata["sprites"];
    $sprite = $spriteList["front_default"];
    return $sprite;
}

function fetchMove($fetchId) {
    $data = file_get_contents("https://pokeapi.co/api/v2/pokemon/{$fetchId}");
    $pokedata = json_decode($data, true);
    $moves = $pokedata["moves"];
    global $randomMoves;
    for ($i = 0; $i < count($randomMoves); $i++) {
        $randomMove = $moves[rand(0, count($moves))]["move"]["name"];
        while (in_array($randomMove, $randomMoves)) {
            $randomMove = $moves[rand(0, count($moves))]["move"]["name"];
        }
        $randomMoves[$i] = $randomMove;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pokédex</title>
    <link href="https://fonts.cdnfonts.com/css/pokemon-solid" rel="stylesheet">
</head>
<body>
<img id="poke-logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/International_Pok%C3%A9mon_logo.svg/2560px-International_Pok%C3%A9mon_logo.svg.png" alt="Pokemon logo"/>
<button id="toggle-music"></button>
<div id="pokedex-page">
    <div id="poke-div">
        <div id="poke-info">
            <h1 id="id"><?php echo fetchPokemonId($pokeId); ?></h1>
            <h2 id="name"><?php echo fetchPokemonName($pokeId); ?></h2>
        </div>
        <figure id="poke-figure">
            <img id="poke-img" src="<?php echo fetchPokemonSprite($pokeId); ?>" alt="pokemon"/>
        </figure>
        <div id="moves-list">
            <h3>moves:</h3>
            <div id="moves">
                <p><?php fetchMove($pokeId);
                    echo $randomMoves[0]; ?></p>
                <p><?php fetchMove($pokeId);
                    echo $randomMoves[1]; ?></p>
                <p><?php fetchMove($pokeId);
                    echo $randomMoves[2]; ?></p>
                <p><?php fetchMove($pokeId);
                    echo $randomMoves[3]; ?></p>
            </div>
        </div>
    </div>
    <div id="evo-div"></div>
    <footer id="nav">
        <form method="post">
            <input name="search" type="text" placeholder="...">
            <input type="submit" value="search">
        </form>
    </footer>
</div>
</body>
</html>