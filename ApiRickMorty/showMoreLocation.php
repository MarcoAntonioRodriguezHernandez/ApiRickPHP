<?php include 'templates/header.php';
printLocationData(getSingleLocation())//Function that prints the data of the location
?>
<div class="residents">
    <h3>Residentes</h3>
    <table class="tableContainer">
        <thead>
        <tr>
            <td>
                <main>

                    <?php
                    if (getResidentsIds(getAllResidents()) == "") {
                        echo '<p>No hay residentes en esta locación</p>';
                    } else {
                        printResidents(getResidentsIds(getAllResidents()));
                    }
                    ?>
                </main>
            </td>
        </tr>
        </thead>
    </table>
</div>
<br><a href="locations.php">
    <button class="btn btn-primary">Regresar</button>
</a><br>

<?php include 'templates/footer.php'; ?>

<?php
/**
 * Function to get the data of one single location
 * @return array This array contains all the data of the location from the query
 */
function getSingleLocation(): array
{
    $channel = curl_init();
    $id = $_GET['id'];
    $url = "https://rickandmortyapi.com/api/location/$id";
    return json_decode(setConectionAPI($url, $channel), true);
}

/**
 * Function to get all the residents of the location
 * @return array This array contains all the data of the residents from the location
 */
function getAllResidents(): array
{
    $channel = curl_init();
    $id = $_GET['id'];
    $url = "https://rickandmortyapi.com/api/location/$id";
    $data = json_decode(setConectionAPI($url, $channel), true);
    return $data['residents'];
}

/**
 * Function to get all the characters of the location in only one query
 * @return array This array contains all the data of the characters from the location
 */
function getAllCharacters($id): array
{
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/character/$id";
    return json_decode(setConectionAPI($url, $channel), true);
}

/**
 * Function to get the ids of all the residents of the location in one string
 * @param $data | This variable contains all the data of the residents of the location
 * @return string This string contains all the ids of the residents of the location
 */
function getResidentsIds($data): string
{
    $residents = "";
    for ($i = 0; $i < count($data); $i++) {
        $cap = (int)filter_var($data[$i], FILTER_SANITIZE_NUMBER_INT);
        $residents .= $cap . ",";
    }
    return $residents;
}

/**
 * Function to print all the residents of the location
 * @param $characters | This variable contains all the data of the characters from the location
 * @return void Even though this function doesn't return anything, it prints the residents with the echo's
 */
function printResidents($characters): void
{
    $residents = getAllCharacters($characters);
    foreach ($residents as $resident) {
        echo '<article>';
        echo '<div class="card">';
        echo '<img src="' . $resident['image'] . '" alt="Avatar" style="width:100%">';
        echo '<p><b>Nombre: </b>' . $resident['name'] . '</p>';
        echo '<p><b>Estado: </b>' . $resident['status'] . '</p>';
        echo '<p><b>Especie: </b>' . $resident['species'] . '</p>';
        echo '<a href="showMoreCharacter.php?id=' . $resident['id'] . '" type="button" class="btn btn-primary">Ver más</a>';
        echo '</div>';
        echo '</article>';
    }
}

/**
 * Function to print the data of the location
 * @param $data | This variable contains all the data of the location
 * @return void Even though this function doesn't return anything, it prints the data of the location with the echo's
 */
function printLocationData($data): void
{
    echo '<article>';
    echo '<div class="card">';
    echo '<p><b>Nombre: </b>' . $data['name'] . '</p>';
    echo '<p><b>Tipo: </b>' . $data['type'] . '</p>';
    echo '<p><b>Dimension: </b>' . $data['dimension'] . '</p>';
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

