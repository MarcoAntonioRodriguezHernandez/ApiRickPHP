<?php include 'templates/header.blade.php';
$max = initial3(1, 0);
?>
<a href="organized.php">
    <button class="btn btn-warning">Organizar</button>
</a><br>
<a href="chapters.php">
    <button class="btn btn-warning">Capitulos</button>
</a><br>
<a href="index.php">
    <button class="btn btn-warning">Regresar</button>
</a><br>
<table class="tableContainer">
    <thead>
    <tr>
        <td>
            <main>
                <?php
                allLocations(initial3(2, $max));
                ?>
            </main>
        </td>

    </tr>
    </thead>
</table><br>

<?php include 'templates/footer.blade.php'; ?>

<?php
//Function that print location by location according to the data received
function allLocations($data)
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

//Function to get the number of all the locations or all the locations data
function initial3($mode, $max)
{
    if ($mode === 1) {
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/location";
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
        return $data['info']['count'];
    } else {
        $j = '';
        for ($i = 1; $i < ($max + 1); $i++) {
            $j .= $i . ',';
        }
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/location/$j";
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

?>
