<?php include 'templates/header.blade.php'; ?>

<div class="card">
    <?php
    characterData(getCharacters(1, 0));
    ?>
    <br><a href="index.php">
        <button class="btn btn-primary">Regresar</button>
    </a>
</div><br>

<?php include 'templates/footer.blade.php';
?>
<?php
function getCharacters($mode, $idChar)
{
    if ($mode === 1) {
        $channel = curl_init();
        $id = $_GET['id'];
        $url = "https://rickandmortyapi.com/api/character/$id";
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

function characterData($data)
{
    echo '<article>';
    echo '<div class="card">';
    echo '<img src="' . $data['image'] . '" alt="Avatar" style="width:100%">';
    echo '<p><b>Nombre: </b>' . $data['name'] . '</p>';
    echo '<p><b>Estatus: </b>' . $data['status'] . '</p>';
    echo '<p><b>Especie: </b>' . $data['species'] . '</p>';
    echo '<p><b>Tipo: </b>' . $data['type'] . '</p>';
    echo '<p><b>Genero: </b>' . $data['gender'] . '</p>';
    echo '<p><b>Origen: </b>' . $data['origin']['name'] . '</p>';
    echo '</div>';
    echo '</article>';
}

?>
