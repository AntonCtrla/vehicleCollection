<div class="card col-6">
  <div class="card-body ">
    <h5 class="card-title">TOP-3 Countries of origin</h5>
    <h6 class="card-subtitle mb-2 text-muted">based on collected Vehicles</h6>
    <p class="card-text">
        <?php
        if (isset($data) && is_iterable($data)) {
            echo '<ul class="list-group"">';
            foreach ($data as $pair) {
                echo '<li class="list-group-item capitalize">'.$pair['country'].' : '.$pair['vehicle_count'].'</li>';
            }
            echo '</ul>';
        } else {
            print_r($data ?? []);
        }
        ?>
    </p>
  </div>
</div>