<div class="container mt-5">
    <div class="jumbotron">
        <h2 class="display-8 text-secondary"><?= $title??'Vehicle Collection'; ?></h2>
        <p class="lead"><?= $message ?? ''; ?></p>
        <div class="row">
            <?= $gearbox ?? ''; ?>
            <?= $milagebox ?? ''; ?>
            <?= $powerbox ?? ''; ?>
            <?= $countrybox ?? ''; ?>

            <?= $content ?? '';?>
        </div>
        <hr class="my-4">
        <?= $ending ?? '<p>Use the navigation to <a href="/collect">start collecting data</a> or to <a href="/table">view the collected data</a> in a table format.
           Or make digit operations with <a href="/fibo">Fibonacci Retriever</a> and <a href="summ">Infinite sum operator</a> </p>';?>
    </div>
</div>
