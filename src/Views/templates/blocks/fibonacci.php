<div class="card col-4">
    <div class="card-body ">
        <h5 class="card-title">Set position</h5>
        <h6 class="card-subtitle mb-2 text-muted"> and get the F-number</h6>
        <p class="card-text">
            <form action="/fibo" method="POST">
                <div class="row">
                    <div class="col">
                        <input name="position" type="number" min="0" class="form-control" placeholder="Position" value="<?=$position??0;?>" />
                    </div>
                    <div class="col">
                        <input class="btn btn-primary" type="submit" value="Get"/>
                    </div>
                </div>
            </form>
        </p>
    </div>
</div>
<div class="card col-3">
    <h5 class="card-title text-center text-primary pt-4">Your number is:</h5>
    <div class="card-body ">
        <?php
        $tag = 'h1';
        $class = 'text-success';
        if (str_contains($result??'','Error')) {
            $tag = 'h3';
            $class = 'text-warning text-small';
        }
        ?>
        <<?=$tag;?> class="<?=$class;?> text-center"><?= $result ?? '-'; ?></<?=$tag;?>>
    </div>
</div>