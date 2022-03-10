<div class="wrap">
    <h1><b>Tour Feed</b></h1>
    <p>The Tour Feed will display a list of all the trips and departures from the Peak 15 CRM. Here, you can set trips and departures to display on the front-end of the website and assign galleries.</p>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1" class="active">Trips</a></li>
        <li><a href="#tab-2">Departures</a></li>
        <li><a href="#tab-3">API Settings</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <h2>Trips</h2>
            <p>List of Trips</p>

        </div>

        <div id="tab-2" class="tab-pane">
            <h1>Itinerary Feed Template</h1>
            <hr>
            <p>Possibly add the feed of inquiries made on the front-end here so there
                <br>
                May need to set up a workflow and include the workflow token here - Speak to Arron about this.
            </p>
            <hr> 
            <table class="table table-striped table-inverse table-responsive" style="width:100%;">
                <thead class="thead-inverse">
                    <tr style="text-align: left;">
                        <th>Tour Name</th>
                        <th>Tour Date</th>
                        <th>Published</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">The World's End - Patagonia</td>
                            <td>1 April 2021 to 14 April 2021</td>
                            <td><input type="checkbox" name="" id=""></td>
                        </tr>
                        <tr>
                            <td scope="row"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
            </table>
            <hr>
            <h2>Feed Sync</h2>
            <h3>Auto Update Frequncy:</h3>
            <button>Refresh Feed</button>
        </div>

        <div id="tab-3" class="tab-pane">
            <h1>API Settings</h1>
            <p>Set the update frequency of the API for the various values in the CRM. Higher priority values such as Pricing and Dates should be set to update immediately on change. Lower priority values such as Descriptions or Images can be set to update daily. The API will check for changes before requesting the data. You can, however, manually refresh the API Using the Master Refresh button.</p>
            <hr>

            <form method="post" action="options.php">
                <?php
                    // settings_fields( 'peak15link_api_settings' );
                    // do_settings_sections( 'peak15_link' );
                    // submit_button();
                ?>
                <label for="update-immediately">
                    <input type="radio" name="update-immediately" id="update-immediately"> Immediately
                </label>
                <label for="update-hourly">
                    <input type="radio" name="update-hourly" id="update-hourly"> Hourly
                </label>
                <label for="update-daily">
                    <input type="radio" name="update-daily" id="update-daily"> Daily
                </label>
                <label for="update-weekly">
                    <input type="radio" name="update-weekly" id="update-weekly"> Weekly
                </label>
                
            </form>
        </div>
    </div>

</div>
