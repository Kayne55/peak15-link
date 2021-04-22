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

<form id="peak-15-form" name="form-booking" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

    <!-- https://data.peak15systems.com/beacon/service.svc/insert/complex/contactbooking
    ?token=yourtokenhere
    &contact.firstname=[firstname]
    &contact.lastname=[lastname]
    &contact.emailaddress1=[email]
    &contact.p15_contacttype_contactid=client
    &p15_bookings.p15_tripdepartures_bookingsid=[departurename or departurecode or GUID]
    &p15_guests.contact.1.isClient=true -->
    
    <input type="hidden" name="formname" value="Tour Booking Form">
    <input type="hidden" name="pagename" value="">
    <input type="hidden" name="statuscode" value="">
    <input type="hidden" name="rule" value="Contacts with same First Name Email">
    <!-- <input type="hidden" name="ruletype" value="retainexistingvalues"> -->    <!-- <input type="hidden" name="p15_listid" value="" /> -->
    <input type="hidden" name="contacttype" value="Prospect">
    <input type="hidden" name="contacttype" value="Prospect">
    <!-- TRIP, DESTINATION & ACTIVITY INTEREST -->
    <input type="hidden" name="p15_trips" value="">
    <input type="hidden" name="destination" value="">
    <input type="hidden" name="tripactivity" value="">
    <input type="hidden" name="p15_channel" value="Web">
    <!-- BOOKING FIELDS -->
    <input type="hidden" name="" value="Client">
    <!-- GOOGLE ANALYTICS FIELDS -->
    <input type="hidden" id='source' name='p15_unresolved_campaign'>
    <input type="hidden" id='medium' name='p15_gamedium'>
    <input type="hidden" id='term' name='p15_searchkeywords'>
    <input type="hidden" id='content' name='p15_gacontent'>
    <input type="hidden" id='campaign' name='p15_gacampaign'>


    <!-- FIRST NAME -->
    <div id="firstname-group" class="p15-input-group">
        <label for="firstname">First Name <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="firstname" placeholder="Enter your first name...">
        <!-- errors will go here -->
    </div>

    <!-- LAST NAME -->
    <div id="lastname-group" class="p15-input-group">
        <label for="lastname">Last Name <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="lastname" placeholder="Enter your last name...">
        <!-- errors will go here -->
    </div>

    <!-- EMAIL ADDRESS -->
    <div id="email-group" class="p15-input-group">
        <label for="email">Email Address <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="email" placeholder="Enter your email address...">
        <!-- errors will go here -->
    </div>

    <!-- PHONE NUMBER -->
	<div id="phone-group" class="p15-input-group">		
		<label for="telephone1">Phone Number <span style="color:red">*</span></label>
		<input type="tel" class="p15-input-control"  placeholder="Type your phone number (Eg. +44 123 456 7891)" notrequired="" name="telephone1">
	</div>
    <!-- errors will go here -->
    
    <!-- BOOKING INFO -->
    <div id="tourname-group" class="p15-input-group">		
		<label for="tourname">Tour Name<span style="color:red">*</span></label>
        <select name="tourname">
            <?php 
                foreach ( $trips as $trip ) {
                    echo '<select value="' . $trip['@attributes']['id'] . '">' . $trip['@attributes']['name'] . '</select>';
                }
            ?>
        </select>
    </div>
    <!-- errors will go here -->

    <div id="departure-group" class="p15-input-group">		
		<label for="departure">Tour Name<span style="color:red">*</span></label>
        <select name="departure">
            <?php 
                foreach ( $trips['Departures']['Departure'] as $departure ) {
                    echo '<select value="' . $departure['@attributes']['id'] . '">' . $departure['@attributes']['startDate'] . ' to ' . $departure['@attributes']['endDate'] . '</select>';
                }
            ?>
        </select>
    </div>
    <!-- errors will go here -->


    <button id="formSubmit" type="submit" class="p15-btn">Submit <span class="fa fa-arrow-right"></span></button>

    <input type="hidden" name="action" value="submit_form">

</form>