<div class="card col-5">
    <div class="card-body ">
        <h5 class="card-title">Set A,B</h5>
        <h6 class="card-subtitle mb-2 text-muted"> and get the F-summ</h6>
        <p class="card-text">
        <form action="/summ" method="POST">
            <div class="row">

                <div class="col-12">
                    <input name="a" type="number" min="0" class="form-control" placeholder="A" value="<?=$a??0;?>" />
                </div>
                <div class="col">
                    <h3 class="text-center">+</h3>
                </div>
                <div class="col-12">
                    <input name="b" type="number" min="0" class="form-control" placeholder="B" value="<?=$b??0;?>" />
                </div>

                <div class="col">
                    <input class="btn btn-primary" type="submit" value="Summ"/>
                </div>
            </div>
        </form>
        </p>
    </div>
</div>
<div class="card col-4">
    <h5 class="card-title text-center text-primary pt-4">Your summ is:</h5>
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