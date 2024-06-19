<div class="container mt-5">
    <div class="jumbotron">
        <h2 class="display-8">Vehicle Collection</h2>
        <p class="lead"><?= $message ?? ''; ?></p>
        <div class="row">
            <?= $gearbox ?? ''; ?>
            <?= $milagebox ?? ''; ?>
            <?= $powerbox ?? ''; ?>
            <?= $countrybox ?? ''; ?>
        </div>
        <hr class="my-4">
        <p>Use the navigation to <a href="/collect">start collecting data</a> or to <a href="/table">view the collected data</a> in a table format.</p>
    </div>
</div>
