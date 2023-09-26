<?php include 'templates/header.php'; ?>
<div class="buttonsContainer">
    <a href="index.php" class="redirections">
        <button class="btn btn-warning">Regresar</button>
    </a><br>
</div>
<table class="tableContainer">
    <thead>
    <tr>
        <td>
            <main>
                <?php
                printCharacters(organizer(getAllCharacters(), 'species'));
                ?>
            </main>
        </td>
    </tr>
    </thead>
</table><br>
<?php include 'templates/footer.php';
/**
 * Function that gets the number of characters
 * @return int This variable contains the total number of characters
 */
function getNumberCharacters(): int
{
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/character";
    $data = json_decode(setConectionAPI($url, $channel), true);
    return $data['info']['count'];
}

/**
 * Function that gets all the characters in only one query
 * @return array This variable contains all the data of the characters from the query
 */
function getAllCharacters(): array
{
    $max = getNumberCharacters() + 1; //This variable contains the number of characters
    $j = '';
    for ($i = 1; $i < $max; $i++) {
        $j .= $i . ',';
    }
    $channel = curl_init();
    $url = "https://rickandmortyapi.com/api/character/$j";
    return json_decode(setConectionAPI($url, $channel), true);
}

/**
 * Function that gets the number of characters
 * @return void Even though this function doesn't return anything, it prints the characters with the echo's
 */
function printCharacters($data): void
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
 * Function that oraganiizes the characters by species
 * @return array This variable contains all the data of the characters organized by species
 */
function organizer($characters, $species): array
{
    $temp = [];
    foreach ($characters as $key => $value)
        $temp[$value[$species] . "oldkey" . $key] = $value;
    ksort($temp);
    $array = array_values($temp);
    unset($temp);
    return $array;
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

