<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Collect Vehicle Data
                </div>
                <div class="card-body">
                    <form id="collect-form">
                        <div class="form-group">
                            <label for="amount">Amount to collect</label>
                            <input type="number" value="1" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
                        </div>
                        <div class="form-group">
                            <label for="offset">Offset</label>
                            <input type="number" value="0" class="form-control" id="offset" name="offset" placeholder="Enter offset" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Collect</button>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div id="result" class="mt-0"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#collect-form').on('submit', function(event) {
            event.preventDefault();

            let amount = $('#amount').val();
            let offset = $('#offset').val();
            let apiUrl = '<?= $apiEndpoint ?>';
            let resultBlock = $('#result');

            resultBlock.html('<h5 class="text-info">Processing...</h5>');

            /// Parsing / checking ids by previous response data to run further car retrieval logic
            function sendToLocalServer(data) {
                $.ajax({
                    url: '/collectids', // Local endpoint
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(response) {

                        resultBlock.prepend('<p class="text-warning">Processing vehicle retrieval...</p>');

                        let carIds = JSON.parse(response).carIds;

                        // resultBlock.prepend('CARIDS:'+ JSON.stringify(carIds) + ' Count='+carIds.length );

                        let message = JSON.parse(response).message;

                        resultBlock.prepend(message);

                        if (carIds && carIds.length > 0) {
                            // Starting to recursively retrieve cars based on found and filtered ids.
                            retrieveAndSaveVehicles(carIds, 0);
                        } else {
                            resultBlock.prepend('<p class="text-warning">No ids to retrieve Vehicles.</p>');
                        }
                    },
                    error: function() {
                        resultBlock.html('<p class="text-danger">Error storing data locally.</p>');
                    }
                });
            }


            // recursive function to get data from remote url and store it locally
            function retrieveAndSaveVehicles(carIds, index) {
                if (index >= carIds.length) {
                    resultBlock.prepend('<h5 class="text-success">Done! '+ carIds.length +' items processed.</h5>');
                    return;
                }

                let carId = carIds[index];

                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    data: {
                        request_type: 'car',
                        auction_type: 'search',
                        lang:'en',
                        car_id: carId
                    },
                    beforeSend: function () {
                        resultBlock.prepend('<p>Retrieving item from api by id: <b>'+carId+'</b></p>');
                    },
                    success: function(carData) {
                        $.ajax({
                            url: '/savevehicle',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify(carData),
                            beforeSend: function () {
                                resultBlock.prepend('<p class="text-info">Saving vehicle with id: ' + carId+'</p>');
                            },
                            success: function(response) {

                                resultBlock.prepend(JSON.parse(response).message);
                                // resultBlock.prepend('<i>data:</i> ' + JSON.stringify(JSON.parse(response).data));

                                // sending next request recursively
                                retrieveAndSaveVehicles(carIds, index + 1);
                            },
                            error: function() {
                                resultBlock.prepend('<p class="text-danger">Error saving car data for car ID: ' + carId + '</p>');
                            }
                        });
                    },
                    error: function() {
                        resultBlock.prepend('<p class="text-danger">Error retrieving car data for car ID: ' + carId + '</p>');
                    }
                });
            }

            function sendRequest(amount, offset) {
                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    data: {
                        request_type: 'cars',
                        auction_type: 'search',
                        start: offset,
                        perpage: amount,
                        sort: 'time_left.asc'
                    },
                    success: function(response) {
                        sendToLocalServer(response);
                    },
                    error: function() {
                        resultBlock.html('<p class="text-danger">Error collecting data from remote API.</p>');
                    }
                });
            }

            sendRequest(amount, offset);
        });
    });
</script>
