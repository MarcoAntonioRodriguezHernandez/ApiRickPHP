<?php include 'templates/header.php'; ?>

<?php printEpisodeData(getSingleEpisode()) ?>
<div class="residents">
    <h3>Personajes del capítulo</h3>
    <table class="tableContainer">
        <thead>
        <tr>
            <td>
                <main>
                    <?php
                    if (getCharactersId(getSingleEpisode(2, 0)) == "") {
                        echo '<p>No hay personajes en este episodio</p>';
                    } else {
                        printAllCharacters(getCharactersId(getCharacterOfEpisode(2, 0)));
                    }
                    ?>
                </main>
            </td>
        </tr>
        </thead>
    </table>
</div>
<br><a href="chapters.php">
    <button class="btn btn-primary">Regresar</button>
</a><br>

<?php include 'templates/footer.php';
/**
 * Function to get the data of one single episode
 * @return array This array contains all the data of the episode from the query
 */
function getSingleEpisode(): array
{
    $channel = curl_init();
    $id = $_GET['id'];
    $url = "https://rickandmortyapi.com/api/episode/$id";
    return json_decode(setConectionAPI($url, $channel), true);
}

/**
 * Function to get the characters of the episode
 * @return array This array contains all the characters of the episode from the query
 */
function getCharacterOfEpisode(): array
{
    $channel = curl_init();
    $id = $_GET['id'];
    $url = "https://rickandmortyapi.com/api/episode/$id";
    $data = json_decode(setConectionAPI($url, $channel), true);
    return $data['characters'];
}

/**
 * Function to get all the characters of the episode in only one query
 * @param $id | This variable contains the id of the character
 * @return array This array contains all the data characters from the query
 */
function getCharacters($id): array
{
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/character/$id";
    return json_decode(setConectionAPI($url, $channel), true);
}

/**
 * Function to get all the id's of the characters in one string
 * @param $data | This variable contains all the data of the characters
 * @return string This string contains all the id's of the characters
 */
function getCharactersId($data): string
{
    $characters = "";
    for ($i = 0; $i < count($data); $i++) {
        $cap = (int)filter_var($data[$i], FILTER_SANITIZE_NUMBER_INT);
        $characters .= $cap . ",";
    }
    return $characters;
}

/**
 * Function to print all the characters of the episode
 * @param $characters | This variable contains all the characters of the episode
 * @return void Even though this function doesn't return anything, it prints the characters of the episode with the echo's
 */
function printAllCharacters($characters): void
{
    $characters = getCharacters($characters);
    foreach ($characters as $character) {
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
 * Function to print the data of the episode
 * @param $data | This variable contains all the data of the episode
 * @return void Even though this function doesn't return anything, it prints the data of the episode with the echo's
 */
function printEpisodeData($data): void
{
    echo '<article>';
    echo '<div class="card">';
    echo '<p><b>Nombre: </b>' . $data['name'] . '</p>';
    echo '<p><b>Fecha de salida: </b>' . $data['air_date'] . '</p>';
    echo '<p><b>Episodio: </b>' . $data['episode'] . '</p>';
    echo '</div>';
    echo '</article>';
}

/**
 * Function to set the connection with the API
 * @param $url | This variable contains the url of the API
 * @param $channel | This variable contains the channel of the API
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

