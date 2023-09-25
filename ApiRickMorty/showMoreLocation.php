<?php include 'templates/header.blade.php'; ?>

<?php locationData(getLocations(1, 0)) ?>
<div class="residents">
    <h3>Residentes</h3>
    <table class="tableContainer">
        <thead>
        <tr>
            <td>
                <main>

                    <?php
                    if (residentsId(getLocations(2, 0)) == "") {
                        echo '<p>No hay residentes en esta locación</p>';
                    } else {
                        separateResidents(residentsId(getLocations(2, 0)));
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

<?php include 'templates/footer.blade.php'; ?>

<?php
//Function that gets the data of the location or the residents of the location
function getLocations($mode, $idChar)
{
    if ($mode === 1) {
        $channel = curl_init();
        $id = $_GET['id'];
        $url = "https://rickandmortyapi.com/api/location/$id";
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($channel);
        if (curl_errno($channel)) {
            $msg = curl_error($channel);
            echo 'Error al conectarse: ' . curl_error($channel);
        } else {
            curl_close($channel);
            $data = json_decode($response, true);
        }
        return $data;
    } else if ($mode === 2) {
        $channel = curl_init();
        $id = $_GET['id'];
        $url = "https://rickandmortyapi.com/api/location/$id";
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($channel);
        if (curl_errno($channel)) {
            $msg = curl_error($channel);
            echo 'Error al conectarse: ' . curl_error($channel);
        } else {
            curl_close($channel);
            $data = json_decode($response, true);
        }
        return $data['residents'];
    } else {
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/character/$idChar";
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($channel);
        if (curl_errno($channel)) {
            $msg = curl_error($channel);
            echo 'Error al conectarse: ' . curl_error($channel);
        } else {
            curl_close($channel);
            $data = json_decode($response, true);
        }
        return $data;
    }
}
//Function that gets the id of the residents of the location
function residentsId($data): string
{
    $residents = "";
    for ($i = 0; $i < count($data); $i++) {
        $cap = (int)filter_var($data[$i], FILTER_SANITIZE_NUMBER_INT);
        $residents .= $cap . ",";
    }
    return $residents;
}
//Function that prints the residents of the location
function separateResidents($residents)
{
    $residents = getLocations(3, $residents);
    foreach ($residents as $resident) {
        echo '<article>';
        echo '<div class="card">';
        echo '<img src="' . $resident['image'] . '" alt="Avatar" style="width:100%">';
        echo '<p><b>Nombre: </b>' . $resident['name'] . '</p>';
        echo '<p><b>Estado: </b>' . $resident['status'] . '</p>';
        echo '<p><b>Especie: </b>' . $resident['species'] . '</p>';
        echo '</div>';
        echo '</article>';
    }
}
//Function that prints the data of the location
function locationData($data)
{
    echo '<article>';
    echo '<div class="card">';
    echo '<p><b>Nombre: </b>' . $data['name'] . '</p>';
    echo '<p><b>Tipo: </b>' . $data['type'] . '</p>';
    echo '<p><b>Dimension: </b>' . $data['dimension'] . '</p>';
    echo '</div>';
    echo '</article>';
}

?>

