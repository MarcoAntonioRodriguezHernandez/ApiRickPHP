<?php include 'templates/header.php'; ?>

<div class="card">
    <?php
    printCharacterData(getSingleCharacterById());
    ?>
    <br><a href="index.php">
        <button class="btn btn-primary">Regresar</button>
    </a>
</div><br>

<?php include 'templates/footer.php';

/**
 * Function that gets the data of a character by its id
 * @return array This array contains the data of the character
 */
function getSingleCharacterById(): array
{
    $channel = curl_init();
    $id = $_GET['id']; //This variable gets the id of the character from the URL
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

/**
 * Function that prints the data of a character
 * @param $data |This variable is an array that contains the data of the character
 * @return void This array contains the data of the character
 */
function printCharacterData($data): void
{
    echo '<article>';
    echo '<div class="card">';
    echo '<img src="' . $data['image'] . '" alt="Avatar" style="width:100%">';
    echo '<p><b>Nombre: </b>' . $data['name'] . '</p>';
    echo '<p><b>Estatus: </b>' . $data['status'] . '</p>';
    echo '<p><b>Especie: </b>' . $data['species'] . '</p>';
    echo '<p><b>Genero: </b>' . $data['gender'] . '</p>';
    echo '<p><b>Origen: </b>' . $data['origin']['name'] . '</p>';
    echo '</div>';
    echo '</article>';
}

?>
