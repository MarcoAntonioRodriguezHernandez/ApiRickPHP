<?php include 'templates/header.php'; ?>
<div class="buttonsContainer">
    <a href="organized.php" class="redirections">
        <button class="btn btn-warning">Organizar</button>
    </a><br>
    <a href="locations.php" class="redirections">
        <button class="btn btn-warning">Locaciones</button>
    </a><br>
    <a href="chapters.php" class="redirections">
        <button class="btn btn-warning">Capitulos</button>
    </a><br>
</div>
<table class="tableContainer">
    <thead>
    <tr>
        <td>
            <main>
                <?php
                printAllCharacters(getAllCharacters());
                ?>
            </main>
        </td>
        <td valign="top" align="center" class="charactersDay">
            <div>
                <h3 id="pD">Personajes del día</h3>
                <?php
                printRandomCharacters();
                ?>
            </div>
        </td>
    </tr>
    </thead>
</table><br>

<?php include 'templates/footer.php';

/**
 * Function that print character by character according to the data received
 * @param $data | This is the array that contains all the characters from the query
 * @return void Even though this function doesn't return anything, it prints all the characters with the echo's
 */
function printAllCharacters($data): void
{
    foreach ($data as $character) {
        echo '<article>';
        echo '<div class="card">';
        echo '<img src="' . $character['image'] . '" alt="Avatar" style="width:100%">';
        echo '<p><b>Nombre: </b>' . $character['name'] . '</p>';
        echo '<p><b>Estado: </b>' . $character['status'] . '</p>';
        echo '<p><b>Especie: </b>' . $character['species'] . '</p>';
        echo '<a href="showMoreCharacter.php?id=' . $character['id'] . '" type="button" class="btn btn-primary">Ver más</a>';
        echo '</div>';
        echo '</article>';
    }
}

/**
 * Function that print five random characters according to the data that this one gets from the API
 * @return void Even though this function doesn't return anything, it prints the random characters with the echo's
 */
function printRandomCharacters(): void
{
    for ($j = 0; $j < 5; $j++) {
        $randomCharacter = getSingleCharacter(rand(1, getNumberCharacters())); //This variable contains the data of a random character
        echo '<article>';
        echo '<div class="cardD">';
        echo '<img src="' . $randomCharacter['image'] . '" alt="Avatar" style="width:100%">';
        echo '<p><b>Nombre: </b>' . $randomCharacter['name'] . '</p>';
        echo '<p><b>Estado: </b>' . $randomCharacter['status'] . '</p>';
        echo '<p><b>Especie: </b>' . $randomCharacter['species'] . '</p>';
        echo '<a href="showMoreCharacter.php?id=' . $randomCharacter['id'] . '" type="button" class="btn btn-primary">Ver más</a>';
        echo '</div>';
        echo '</article>';
    }
}

/**
 * Function to get all the characters in only one query
 * @return array This array contains all the characters from the query
 */
function getAllCharacters(): array
{
    $max = getNumberCharacters(); //This variable contains the number of characters
    $j = '';
    for ($i = 1; $i < ($max + 1); $i++) {
        $j .= $i . ',';
    }
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/character/$j";
    return json_decode(setConectionAPI($url, $channel), true);
}

/**
 * Function to get the number of all the characters
 * @return int This variable contains the number of characters
 */
function getNumberCharacters(): int
{
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/character";
    $data = json_decode(setConectionAPI($url, $channel), true);
    return $data['info']['count'];
}

/**
 * Function to get only one character
 * @return array This array contains the data of only one character
 */
function getSingleCharacter($id): array
{
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/character/$id";
    return json_decode(setConectionAPI($url, $channel), true);
}

/**
 * Function to set the connection with the API
 * @return string This variable contains the response of the API
 */
function setConectionAPI($url, $channel): string
{
    curl_setopt($channel, CURLOPT_URL, $url);
    curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($channel);
    curl_close($channel);
    return $response;
}

?>
