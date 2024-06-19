<div class="card col-6">
  <div class="card-body">
    <h5 class="card-title">Maximum and minimum power</h5>
    <h6 class="card-subtitle mb-2 text-muted">kW / HP</h6>
    <p class="card-text">
        <?php
        if (isset($data) && is_iterable($data)) {
            echo '<ul class="list-group"">';

            echo '<li class="list-group-item">
                    <h4 class="text-primary">Max: '. ($data[0]['max_power_kw']??'').'&nbsp;kW / '.($data[0]['max_power_hp']??'').'&nbsp;HP</h4>
                </li>';
            echo '<li class="list-group-item">
                    <h5 class="text-danger ">Min: '. ($data[0]['min_power_kw']??'').'&nbsp;kW / '.($data[0]['min_power_hp']??'').'&nbsp;HP</h5>
                </li>';

            echo '</ul>';
        } else {
            print_r($data ?? []);
        }
        ?>
    </p>
  </div>
</div>