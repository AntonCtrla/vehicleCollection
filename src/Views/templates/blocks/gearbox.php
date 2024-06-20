<div class="card col-6">
  <div class="card-body">
    <h5 class="card-title">Gearbox</h5>
    <h6 class="card-subtitle mb-2 text-muted">and Fuel</h6>
      <div class="row">
          <div class="col-6"><?php
            if (isset($gear) && is_iterable($gear)) {
                echo '<ul class="list-group"">';
                foreach ($gear as $gearItem) {
                    echo '<li class="list-group-item">'.($gearItem['name']??'-').'</li>';
                }
                echo '</ul>';
            } else {
                print_r($gear ?? []);
            }?>
          </div>
          <div class="col-6"><?php
              if (isset($fuel) && is_iterable($fuel)) {
                  echo '<ul class="list-group"">';
                  foreach ($fuel as $fuelItem) {
                      echo '<li class="list-group-item">'.($fuelItem['name']??'-').'</li>';
                  }
                  echo '</ul>';
              } else {
                  print_r($fuel ?? []);
              }
              ?>
          </div>
      </div>
  </div>
</div>