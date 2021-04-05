<div class="wrap">
    <h1><b>Peak15 Link Plugin (Beta)</b></h1>
    <p>The Peak15 Link plugin allows you to display your itineraries and departures from your Peak15 Travel CRM on your WordPress frontend as well as allowing your users to send inquiries, make bookings and update their profiles.</p>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1" class="active">Settings</a></li>
        <li><a href="#tab-2">Itinerary Feed</a></li>
        <li><a href="#tab-3">Web Forms</a></li>
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
        <h1>Web Forms</h1>
        <hr>
        <p>Possibly add a list of available forms and include a Shortcode for each form so that they can be included anywhere on the page.
        <br>
        Post the form to Peak 15 and save the url in the query so that we can see where the user completed the form / enquiry.
        </p> 
        </div>
    </div>

</div>
