<?php include 'templates/header.php'; ?>
<div class="buttonsContainer">

    <a href="chapters.php" class="redirections">
        <button class="btn btn-warning">Capitulos</button>
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
                printAllLocations(getAllLocations());
                ?>
            </main>
        </td>

    </tr>
    </thead>
</table><br>

<?php include 'templates/footer.php';
/**
 * Function to set the connection with the API
 * @return void Even though this function doesn't return anything, it prints the locations with the echo's
 */
function printAllLocations($data): void
{
    foreach ($data as $location) {
        echo '<article>';
        echo '<div class="card">';
        echo '<p><b>Nombre: </b>' . $location['name'] . '</p>';
        echo '<p><b>Estado: </b>' . $location['type'] . '</p>';
        echo '<p><b>Especie: </b>' . $location['dimension'] . '</p>';
        echo '<a href="showMoreLocation.php?id=' . $location['id'] . '" type="button" class="btn btn-primary">Ver más</a>';
        echo '</div>';
        echo '</article>';
    }
}

/**
 * Function to get the number of all the locations
 * @return int This variable contains the total number of locations
 */
function getNumberOfLocations(): int
{
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/location";
    $data = json_decode(setConectionAPI($url, $channel), true);
    return $data['info']['count'];
}

/**
 * Function to get all the locations in only one query
 * @return array This array contains all the data of the locations from the query
 */
function getAllLocations(): array
{
    $max = getNumberOfLocations() + 1; //This variable contains the number of locations
    $j = '';
    for ($i = 1; $i < ($max + 1); $i++) {
        $j .= $i . ',';
    }
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/location/$j";
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
