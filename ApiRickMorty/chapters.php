<?php include 'templates/header.blade.php';
?>
<a href="organized.php">
    <button class="btn btn-warning">Organizar</button>
</a><br>
<a href="locations.php">
    <button class="btn btn-warning">Locaciones</button>
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
                allEpisodes(initial4(2));
                ?>
            </main>
        </td>

    </tr>
    </thead>
</table><br>

<?php include 'templates/footer.blade.php'; ?>
<?php
//Function that print episode by episode according to the data received
function allEpisodes($data): void
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
//Function to get the number of all the episodes or all the episodes data
function initial4($mode)
{
    if ($mode === 1) {
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/episode";
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
        $max = initial4(1);
        $j = '';
        for ($i = 1; $i < ($max + 1); $i++) {
            $j .= $i . ',';
        }
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/episode/$j";
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
