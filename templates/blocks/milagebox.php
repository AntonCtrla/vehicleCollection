<div class="card col-6">
  <div class="card-body">
    <h5 class="card-title">Average Mileage
    </h5>
    <h6 class="card-subtitle mb-2 text-muted">of the collected vehicles</h6>
    <h3 class="card-text text-primary">
        <?php
        if (isset($data) && is_iterable($data) && isset($data[0]['average_mileage'])) { ?>
            <?php
            echo $data[0]['average_mileage']??'Data N/A';
        }
        ?>
    </h3>
  </div>
</div>