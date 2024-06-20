<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Vehicle Data Table
                </div>
                <div class="card-body">
                    <table id="vehicle-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Brand</th>
                            <th>Country</th>
                            <th>Fuel</th>
                            <th>Gearbox</th>
                            <th>Power</th>
                            <th>Mileage</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($vehicles) && is_array($vehicles) && count($vehicles)) {
                                foreach ($vehicles as $vehicle) {?>
                                    <tr>
                                        <td><?php echo $vehicle['id']; ?></td>
                                        <td><?php echo $vehicle['brand']; ?></td>
                                        <td><?php echo $vehicle['country']; ?></td>
                                        <td><?php echo $vehicle['fuel']; ?></td>
                                        <td><?php echo $vehicle['gearbox']; ?></td>
                                        <td><?php echo $vehicle['power']; ?></td>
                                        <td><?php echo $vehicle['mileage']; ?></td>
                                    </tr>
                                <?php }
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#vehicle-table').DataTable({
            "paging": true,
            "searching": true,
            "pageLength": 10,
        });
    });
</script>

