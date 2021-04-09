<div class="wrap">
    <h1><b>Peak15 Link Plugin (Beta)</b></h1>
    <p>The Peak15 Link plugin allows you to display your itineraries and departures from your Peak15 Travel CRM on your WordPress frontend as well as allowing your users to send inquiries, make bookings and update their profiles.</p>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1" class="active">Settings</a></li>
        <li><a href="#tab-2">Departure Dates</a></li>
        <!--<li><a href="#tab-3">Web Forms</a></li>-->
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <h2>Database Access</h2>
            <p>To access your Peak 15 Travel CRM database you will need to contact the support team at Peak 15 and request your API token and enter it below.</p>
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'peak15link_api_settings' );
                    do_settings_sections( 'peak15_link' );
                    submit_button();
                ?>
            </form>
        </div>

        <div id="tab-2" class="tab-pane">
            <h1>Departure Dates</h1>
            <hr>
            <p>Tours and their respective departure dates are displayed here. Thet are stored in the transient cache and are refreshed daily.
                <br>
                <b>Note:</b> Include a "Clear Cache" button to reset the cache when important updated are made to the CRM such as pricing or dates changes.
            </p>
            <hr> 

            <?php

                $url = 'https://data.peak15systems.com/beacon/service.svc/get/' . $this->orgname . '/complextext/downloadtransactions?token=' . $this->api_token . '&processexecutetoken=' . $this->process_token . '&outputFormat=xml';

                $start_time = microtime(true);

                if ( false === ( $p15_tour_data = get_transient('p15_tour_data') ) ) {
                    $p15_tour_data  = [];
                    $response       = wp_remote_get( $url );
                    $body           = wp_remote_retrieve_body( $response );
                    $xml            = simplexml_load_string($body);
                    $json           = json_encode($xml);
                    $array          = json_decode($json,TRUE);
                    $p15_tour_data  = $array;

                    set_transient('p15_tour_data', $array, DAY_IN_SECONDS );
                    
                }

                ?>
                <table style="text-align: left; width: 100%;">
                    <tbody>
                        <tr>
                            <td><b>Tour</b></td>
                            <td><b>Start Date</b></td>
                            <td><b>End Date</b></td>
                            <td><b>Spaces</b></td>
                            <td><b>Trip Manager</b></td>
                            <td><b>Rider Price</b></td>
                        </tr>
                    </tbody>
                    <tbody>
                        <?php
                            foreach ( $p15_tour_data['Trip'] as $trip ) {
                                
                                foreach ( $trip['Departures']['Departure'] as $departure ) {
                                    echo '<tr>';
                                    echo '<td>' .  $trip['@attributes']['name'] . '</td>';
                                    echo '<td>' . date_format(date_create($departure['@attributes']['startDate']), "Y/m/d") . '</td>';
                                    echo '<td>' . date_format(date_create($departure['@attributes']['endDate']), "Y/m/d") . '</td>';
                                    echo '<td>' . $departure['@attributes']['availableSpaces'] . '</td>';
                                    echo '<td>' . $departure['TripManagerName'] . '</td>';
                                    echo '<td>' . $departure['Prices']['Price'][0]['@attributes']['amount'] . '</td>';
                                    echo '</tr>';
                                }
                                
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                
                $end_time = microtime(true);

                echo $end_time - $start_time;

                // echo '<pre>';
                // print_r($p15_tour_data['Trip']);
                // echo '</pre>';


                // if (false === ($p15_tour_dates = get_transient('p15_tour_dates'))) {
                //     $departures = $array['Trip']['Departures'];

                //     foreach ($departures as $departure ) {

                //     }

                // }

                // $arr = $array;

                // echo '<pre>';
                // print_r($array['Trip']);
                // echo '</pre>';

                // foreach ( $arr as $key => $value ) {
                //     echo $value
                // }

                // foreach ( $arr as &$value ) {

                //     $tripname = $value['@attributes']['name'];

                //     print_r($tripname);
                    
                //     // foreach ( $value as &$trip ) {
                //     //     echo '<pre>';
                //     //     print_r($trip);
                //     //     echo '</pre>';
                //     // }
                // }

                // unset($trip);

                // echo '<pre>';
                // print_r($array['Trip']['@attributes']);
                // print_r($array['Trip']['Departures']);
                // echo '</pre>';
            
            ?>
            <!-- <table class="table table-striped table-inverse table-responsive" style="width:100%;">
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
            <button>Refresh Feed</button> -->
        </div>

        <div id="tab-3" class="tab-pane">
        <h1>Web Forms</h1>
        <hr>
        <p>Possibly add a list of available forms and include a Shortcode for each form so that they can be included anywhere on the page.
        <br>
        Post the form to Peak 15 and save the url in the query so that we can see where the user completed the form / enquiry.
        </p> 
        </div>
    </div>

</div>
