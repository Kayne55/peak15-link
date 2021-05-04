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
            <!-- <hr>
            <h3>Plugin Cache</h3>
            <p>If you have made any important updates to the the CRM, clear the plugin cache to update the API data.</p>
            <form action="< ?php echo admin_url('admin-post.php'); ?>" method="post">
                <input type="hidden" name="action" value="p15_plugin_delete_transients">
                < ?php submit_button( 'Clear Plugin cache', 'delete', '', false ); ?>
            </form> -->
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
                    $responseCode   = wp_remote_retrieve_response_code($response);
                    $bodyXML        = wp_remote_retrieve_body( $response );
                    $bodyArray      = simplexml_load_string($bodyXML);
                    $json           = json_encode($bodyArray);
                    $array          = json_decode($json,TRUE);
                    $p15_tour_data  = $array;

                    set_transient('p15_tour_data', $array, HOUR_IN_SECONDS );
                }

                // Handle Errors Here
                if ( ! isset($p15_tour_data['Trip']) ) {
                    echo '<div class="p15-message p15-message-error" style="margin: 15px 0;">';
                    echo '<h3>' . $responseCode . ': ' . $bodyXML . '</h3>';
                    if ( $p15_tour_data[0] == "Invalid Token Value" ) {
                        echo '<p>Please check your API Settings and refresh the plugin.</p>';
                    }
                    if ( $p15_tour_data[0] == "Passed processExecuteToken does not exist or is invalid" ) {
                        echo '<p>Please check your API Settings and refresh the plugin.</p>';
                    }
                    echo '</div>';
                } else {
                    ?>
                    <div class="p15-admin-tables">
                        <table>
                            <thead>
                                <tr>
                                    <th  width="30%"><h3>Tour</h3></th>
                                    <th  width="10%"><h3>Start Date</h3></th>
                                    <th  width="10%"><h3>End Date</h3></th>
                                    <th  width="10%"><h3>Spaces</h3></th>
                                    <th  width="10%"><h3>Trip Manager</h3></th>
                                    <th  width="30%"><h3>Prices</h3></th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php
                                // If there are no errors, fetch the data.
                                foreach ( $p15_tour_data['Trip'] as $trip ) {
                                    // If the trip has MORE THAN ONE departure date...
                                    if ( isset($trip['Departures']['Departure'][0]) ) {
                                        $departures = $trip['Departures']['Departure'];
                                    // If the trip has ONLY ONE departure date...
                                    } elseif ( isset($trip['Departures']) ) {
                                        $departures = $trip['Departures'];
                                    // If the trip has NO departure dates we se the variable to an empty array. We do not want to display trips with no departures...
                                    } else {
                                        $departures = [];
                                    }
                                    if ( is_array($departures) ) {
                                        foreach ( $departures as $departure ) {
                                            if ( isset($departure['Prices']['Price']) ) {
                                                $prices = $departure['Prices']['Price'];
                                            }
                                            echo '<tr>';
                                            echo '<td><h3>' . $trip['@attributes']['name'] . '</h3><p><small>' . $trip['@attributes']['id'] . '</small></p></td>';
                                            echo '<td>' . date_format(date_create($departure['@attributes']['startDate']), "Y/m/d") . '</td>';
                                            echo '<td>' . date_format(date_create($departure['@attributes']['endDate']), "Y/m/d") . '</td>';
                                            echo '<td>' . $departure['@attributes']['availableSpaces'] . '</td>';
                                            echo '<td>' . $departure['TripManagerName'] . '</td>';
                                            echo '<td>';
                                            if (is_array($prices)) {
                                                foreach ( $prices as $price ) {
                                                    echo '<div><span><b>' . $price['@attributes']['name'] . ': </b>' . number_format($price['@attributes']['amount'], 2, ".", ",") .' GBP</span></div>';
                                                }
                                            }
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        return;
                                    }
                                }
                                // If there are no errors, fetch the data.
                                // foreach ( $p15_tour_data['Trip'] as $trip ) {
                                //     // If there is more than one departure run the following
                                //     if ( isset($trip['Departures']['Departure'][0]) ) {
                                //         foreach ( $trip['Departures']['Departure'] as $departure ) {
                                //             if ( isset($departure['Prices']['Price']) ) {
                                //                 $prices = $departure['Prices']['Price'];
                                //             }
                                //             echo '<tr>';
                                //             echo '<td><h3>' . $trip['@attributes']['name'] . '</h3><p><small>' . $trip['@attributes']['id'] . '</small></p></td>';
                                //             echo '<td>' . date_format(date_create($departure['@attributes']['startDate']), "Y/m/d") . '</td>';
                                //             echo '<td>' . date_format(date_create($departure['@attributes']['endDate']), "Y/m/d") . '</td>';
                                //             echo '<td>' . $departure['@attributes']['availableSpaces'] . '</td>';
                                //             echo '<td>' . $departure['TripManagerName'] . '</td>';
                                //             echo '<td>';
                                //             if (is_array($prices)) {
                                //                 foreach ( $prices as $price ) {
                                //                     echo '<div><span><b>' . $price['@attributes']['name'] . ': </b>' . number_format($price['@attributes']['amount'], 2, ".", ",") .' GBP</span></div>';
                                //                 }
                                //             }
                                //             echo '</td>';
                                //             echo '</tr>';
                                //         }
                                //         // Or else if there is only one departure run the following
                                //         } else {
                                //             foreach ( $trip['Departures'] as $departure ) {
                                //                 if ( isset($departure['Prices']['Price']) ) {
                                //                     $prices = $departure['Prices']['Price'];
                                //                 }
                                //                 echo '<tr>';
                                //                 echo '<td><h3>' . $trip['@attributes']['name'] . '</h3></td>';
                                //                 echo '<td>' . date_format(date_create($departure['@attributes']['startDate']), "Y/m/d") . '</td>';
                                //                 echo '<td>' . date_format(date_create($departure['@attributes']['endDate']), "Y/m/d") . '</td>';
                                //                 echo '<td>' . $departure['@attributes']['availableSpaces'] . '</td>';
                                //                 echo '<td>' . $departure['TripManagerName'] . '</td>';
                                //                 echo '<td>';
                                //                 if (is_array($prices)) {
                                //                     foreach ( $prices as $price ) {
                                //                         echo '<div><span><b>' . $price['@attributes']['name'] . ': </b>' . number_format($price['@attributes']['amount'], 2, ".", ",") .' GBP</span></div>';
                                //                     }
                                //                 }
                                //                 echo '</td>';
                                //                 echo '</tr>';
                                //             }
                                //         }
                                //     }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                }
                
                $end_time = microtime(true);
                echo $end_time - $start_time;

                // For Debugging
                // echo '<pre>';
                // print_r($p15_tour_data['Trip']);
                // echo '</pre>';


            
            ?>
        </div>

        <!-- <div id="tab-3" class="tab-pane">
        <h1>Web Forms</h1>
        <hr>
        <p>Possibly add a list of available forms and include a Shortcode for each form so that they can be included anywhere on the page.
        <br>
        Post the form to Peak 15 and save the url in the query so that we can see where the user completed the form / enquiry.
        </p> 
        </div> -->
    </div>

</div>
