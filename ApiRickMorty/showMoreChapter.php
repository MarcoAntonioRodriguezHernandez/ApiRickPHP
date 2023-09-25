<?php include 'templates/header.blade.php'; ?>

<?php episodeData(getEpisodes(1,0)) ?>
<div class="residents">
    <h3>Personajes del capítulo</h3>
    <table class="tableContainer">
        <thead>
        <tr>
            <td>
                <main>
                    <?php
                    if(charactersId(getEpisodes(2,0)) == "" ){
                        echo '<p>No hay personajes en este episodio</p>';
                    }else{
                        separateCharacterss(charactersId(getEpisodes(2,0)));
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

<?php include 'templates/footer.blade.php';

function getEpisodes($mode,$idChar)
{
    if ($mode === 1) {
        $channel = curl_init();
        $id = $_GET['id'];
        $url = "https://rickandmortyapi.com/api/episode/$id";
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
    }else if($mode === 2){
        $channel = curl_init();
        $id = $_GET['id'];
        $url = "https://rickandmortyapi.com/api/episode/$id";
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
        return $data['characters'];
    }else{
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

function charactersId($data)
{
    $characters = "";
    for ($i = 0; $i < count($data); $i++) {
        $cap = (int)filter_var($data[$i], FILTER_SANITIZE_NUMBER_INT);
        $characters .= $cap . ",";
    }
    return $characters;
}

function separateCharacterss($characters)
{
    $characters = getEpisodes(3,$characters);
    foreach ($characters as $character) {
        echo '<article>';
        echo '<div class="card">';
        echo '<img src="' . $character['image'] . '" alt="Avatar" style="width:100%">';
        echo '<p><b>Nombre: </b>' . $character['name'] . '</p>';
        echo '<p><b>Estado: </b>' . $character['status'] . '</p>';
        echo '<p><b>Especie: </b>' . $character['species'] . '</p>';
        echo '</div>';
        echo '</article>';
    }
}

function episodeData($data)
{
    echo '<article>';
    echo '<div class="card">';
    echo '<p><b>Nombre: </b>' . $data['name'] . '</p>';
    echo '<p><b>Fecha de salida: </b>' . $data['air_date'] . '</p>';
    echo '<p><b>Episodio: </b>' . $data['episode'] . '</p>';
    echo '</div>';
    echo '</article>';
}

?>

