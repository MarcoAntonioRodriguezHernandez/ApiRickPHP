<?php include 'templates/header.php'; ?>
<div class="buttonsContainer">
    <a href="locations.php" class="redirections">
        <button class="btn btn-warning">Locaciones</button>
    </a><br>
    <a href="index.php" class="redirections">
        <button class="btn btn-warning">Inicio</button>
    </a><br>
</div>
<table class="tableContainer">
    <thead>
    <tr>
        <td>
            <main>
                <?php
                printAllEpisodes(getAllEpisodes());
                ?>
            </main>
        </td>

    </tr>
    </thead>
</table><br>

<?php include 'templates/footer.php'; ?>
<?php
/**
 * Function to print all the episodes
 * @param $data | This variable contains all the data of the episodes
 * @return void Even though this function doesn't return anything, it prints the episodes with the echo's
 */
function printAllEpisodes($data): void
{
    foreach ($data as $episode) {
        echo '<article>';
        echo '<div class="card">';
        echo '<p><b>Nombre: </b>' . $episode['name'] . '</p>';
        echo '<p><b>Fecha de salida: </b>' . $episode['air_date'] . '</p>';
        echo '<p><b>Episodio: </b>' . $episode['episode'] . '</p>';
        echo '<a href="showMoreChapter.php?id=' . $episode['id'] . '" type="button" class="btn btn-primary">Ver más</a>';
        echo '</div>';
        echo '</article>';

    }
}

/**
 * Function to get the number of all the episodes
 * @return int This variable contains the total number of episodes
 */
function getNumberEpisodes(): int
{
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/episode";
    $data = json_decode(setConectionAPI($url, $channel), true);
    return $data['info']['count'];
}

/**
 * Function to get all the episodes in only one query
 * @return array This array contains all the data of the episodes from the query
 */
function getAllEpisodes(): array
{
    $max = getNumberEpisodes() + 1; //This variable contains the number of episodes
    $j = '';
    for ($i = 1; $i < $max; $i++) {
        $j .= $i . ',';
    }
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/episode/$j";
    return json_decode(setConectionAPI($url, $channel), true);
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
