<?php

    $url = 'https://data.peak15systems.com/beacon/service.svc/get/' . $this->orgname . '/complextext/downloadtransactions?token=' . $this->api_token . '&processexecutetoken=' . $this->process_token . '&outputFormat=xml';

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

	$trips = $p15_tour_data['Trip'];

	// Manually set the variable for testing. Change this to fetch the "Available Spaces" for the selected departure in the "Trip" array.
	$group_size = 15;

	// Handle Errors Here
	if ( ! isset($p15_tour_data['Trip']) ) {
		echo '<div class="p15-message p15-message-error" style="margin: 15px 0;">';
		echo '<h3>Error ' . $responseCode . ': ' . $bodyXML . '</h3>';
		if ( $p15_tour_data[0] == "Invalid Token Value" ) {
			echo '<p>Please check your API Settings and refresh the plugin.</p>';
		}
		if ( $p15_tour_data[0] == "Passed processExecuteToken does not exist or is invalid" ) {
			echo '<p>Please check your API Settings and refresh the plugin.</p>';
		}
		echo '</div>';
	} else {

?>

<!-- BOOKING FIELDS REQUIRED -- >

	BOOKING FIELDS FOR MAIN TRAVELLER:
	https://data.peak15systems.com/beacon/service.svc/insert/complex/contactbooking?
	?token=yourtokenhere
	&contact.firstname=[firstname]
	&contact.lastname=[lastname]
	&contact.emailaddress1=[email]
	&contact.p15_contacttype_contactid=client
	&p15_bookings.p15_tripdepartures_bookingsid=[departurename or departurecode or GUID]
	&p15_guests.contact.1.isClient=true

	BOOKING FIELDS FOR ADDITIONAL GUESTS IN SAME HOUSEHOLD:
	&p15_guests.contact.2.firstname=[firstname1]
	&p15_guests.contact.2.lastname=[lastname1]
	&p15_guests.contact.2.p15_contacttype_contactid=client
	&p15_guests.contact.2.samehousehold=true

	BOOKING FIELDS FOR OPTIONAL EXTRAS / UPGRADES:
	FOR MAIN CONTACT:
	&p15_guests.contact.1.p15_tripprices.1=[price1name or GUID]
	FOR EACH ADDITIONAL CONTACT:
	&p15_guests.contact.2.p15_tripprices.2=[price2name or GUID]

	BOOKING FIELDS - COST ITEM RESERVATIONS:
	&p15_guests.contact.1.p15_vendorserviceitemres.1=Cabin A1
	&p15_guests.contact.2.p15_vendorserviceitemres.1=Cabin A1

	INVOICE FIELDS:
	&p15_invoices.p15_paymentscheduleid=[paymentschedulename or GUID]

	STRIP PAYMENT FIELDS:
	TO CAPTURE CARD DETAILS
	&amount=0
	&currency=[currencycode e.g. USD]
	&SuccessPage=https://data.peak15systems.com/stripe/index.aspx?invoiceid
	&satransactiontype=create_payment_token
	&success_url=http://domain.com/pg1.html
	&cancel_url=http://domain.com/pg1.html

	STRIPE NOTES;
	If you wish to test Stripe using a dummy card number, use Visa 4242-4242-4242-4242 and change the Mode attribute on the Merchant Account record for Stripe in PEAK 15 from "true" to "false".  Additional test cards are provided at https://stripe.com/docs/testing#cards. 
-->

<form id="p15_booking_form" action="#" name="form-booking" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

	<input type="hidden" name="formname" value="Tour Booking Form">
    <input type="hidden" name="pagename" value="">
    <input type="hidden" name="statuscode" value="">
    <input type="hidden" name="rule" value="Contacts with same First Name Email">
    <input type="hidden" name="contacttype" value="Prospect">
    <input type="hidden" name="contacttype" value="Prospect">
    <!-- TRIP, DESTINATION & ACTIVITY INTEREST -->
    <input type="hidden" name="p15_trips" value="">
    <input type="hidden" name="destination" value="">
    <input type="hidden" name="tripactivity" value="">
    <input type="hidden" name="p15_channel" value="Web">
    <!-- BOOKING FIELDS -->
	<input type="hidden" name="contact.p15_contacttype_contactid" value="client">
    <!-- GOOGLE ANALYTICS FIELDS -->
    <input type="hidden" id='source' name='p15_unresolved_campaign'>
    <input type="hidden" id='medium' name='p15_gamedium'>
    <input type="hidden" id='term' name='p15_searchkeywords'>
    <input type="hidden" id='content' name='p15_gacontent'>
    <input type="hidden" id='campaign' name='p15_gacampaign'>

	<div style="text-align: right;">
		<span class="p15-bookstep"></span>
		<span class="p15-bookstep"></span>
		<span class="p15-bookstep"></span>
	</div>

	<div class="p15-tab">
		<div class="form-section">
		<h2>Tour Booking</h2>
			<!-- BOOKING INFO -->
			<div id="tourname-group" class="p15-input-group">
				<select id="tourSelect" class="p15-input-control" name="tourname">
				<!-- <select id="tourSelect" class="p15-input-control" name="tourname"> -->
					<option value="">Select Tour</option>
					<?php 
						foreach ( $trips as $trip ) {
							echo '<option value="' . $trip['@attributes']['id'] . '">' . $trip['@attributes']['name'] . '</option>';
						}
					?>
				</select>
			</div>
			<!-- <script>
				function showDepartures() {
					var tourSelect = document.getElementById("tourSelect");
					var tourGUID = tourSelect.value;
					var departureGroup = document.getElementById("departureGroup");

					if ( tourSelect.value === "" ) {
						departureGroup.style.display = 'none';
						document.getElementById("testJsValue").innerHTML = "";
					} else {
						departureGroup.style.display = 'block';
						document.getElementById("testJsValue").innerHTML = tourGUID;
					}
				}
			</script> -->
			<!-- errors will go here -->

			<span id="testJsValue"></span>

			<div id="departureGroup" class="p15-input-group" style="display: none;">
				<select class="p15-input-control" name="p15_bookings.p15_tripdepartures_bookingsid">
					<option value="[departurename or departurecode or GUID]">Departure 1</option>
					<option value="01-02-2022">01-02-2022</option>
					<script>
						// Need to use an ajax function here to send the GUID of the selected tour to the server and get the relative departures.
						// var tripID = document.getElementById("tourSelect").value;
						// jQuery.ajax({
						// 	method: "POST",
						// 	url
						// })


					</script>
					<?php
						//$departures = $trip;
						// foreach ( $trips['Departures']['Departure'] as $departure ) {
						// 	echo '<select value="' . $departure['@attributes']['id'] . '">' . $departure['@attributes']['startDate'] . ' to ' . $departure['@attributes']['endDate'] . '</select>';
						// }
					?>
				</select>
			</div>
			<!-- errors will go here -->	
		</div>
		<div class="form-section">
			<h2>Group Size</h2>
			<p>Please select how many people there are in your group.</p>
			<p><b>Available Spaces:</b> <span id="available_spaces"><?php echo $group_size; ?></span></p>
			<select id="group_size_list" class="p15-input-control" name="ridercount" oninput="this.classList.remove('invalid')">
				<option value="Just Myself">Just Myself</option>
				<?php 
					// $group_size = 8;
					$value = 2;
					for ( $i = 0; $i <= ($group_size - 2); $i++ ) {
						echo '<option value="'. $value .'">'. $value .' Guests</option>';
						$value++;
					}
				?>
				<!-- <option value=""></option>
				<option value="Just Myself">Just Myself</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="10+">10+</option> -->
			</select>
		</div>
	</div>

	<div class="p15-tab">
		<h2>Guest Infomation</h2>
		<hr>
		<div class="mainguest-info">
			<input type="hidden" name="p15_guests.contact.1.isClient" value="true">
			<h4>Main Guest / Group Organiser</h4>
			<!-- FIRST NAME -->
			<div id="firstname-group" class="p15-input-group">
				<input type="text" class="p15-input-control" name="firstname" placeholder="First name..." oninput="this.classList.remove('invalid')">
				<!-- errors will go here -->
			</div>

			<!-- LAST NAME -->
			<div id="lastname-group" class="p15-input-group">
				<input type="text" class="p15-input-control" name="lastname" placeholder="Last name..." oninput="this.classList.remove('invalid')">
				<!-- errors will go here -->
			</div>

			<!-- EMAIL ADDRESS -->
			<div id="email-group" class="p15-input-group">
				<input type="text" class="p15-input-control" name="email" placeholder="Email address..." oninput="this.classList.remove('invalid')">
				<!-- errors will go here -->
			</div>

			<!-- PHONE NUMBER -->
			<div id="phone-group" class="p15-input-group">
				<input type="tel" class="p15-input-control"  placeholder="Phone number (Eg. +44 123 456 7891)" notrequired="" name="telephone1" oninput="this.classList.remove('invalid')">
			</div>
			<!-- errors will go here -->
									<!-- LICENSE -->
			<div id="licensetype-group" class="p15-input-group">			
				<!-- <label for="rideexp_motorcyclelicensetype">Motorcycle License Type <span style="color:red">*</span></label> -->
				License Type
				<select class="p15-input-control" name="rideexp_motorcyclelicensetype" oninput="this.classList.remove('invalid')">
					<option value=""></option>
					<option value="No License">No License</option>
					<option value="Restricted">Restricted</option>
					<option value="Unrestricted">Unrestricted</option>
				</select>
			</div>
			<!-- errors will go here -->
			<!-- ROAD RIDING LEVEL -->
			<div id="levelroad-group" class="p15-input-group">			
				<!-- <label for="rideexp_roadridinglevel">Road Riding Level <span style="color:red">*</span></label> -->
				Road Riding Level
				<select class="p15-input-control" name="rideexp_roadridinglevel" oninput="this.classList.remove('invalid')">
					<option value=""></option>
					<option value="Beginner">Beginner</option>
					<option value="Novice">Novice</option>
					<option value="Competent">Competent</option>
					<option value="Advanced">Advanced</option>
					<option value="Valentino Rossi">Valentino Rossi</option>
				</select>
			</div>
			<!-- errors will go here -->
			<!-- OFFROAD RIDING LEVEL -->
			<div id="leveloffroad-group" class="p15-input-group">			
				<!-- <label for="rideexp_offroadridinglevel">Off-Road Riding Level <span style="color:red">*</span></label> -->
				Offroad Riding Level
				<select class="p15-input-control" name="rideexp_offroadridinglevel" oninput="this.classList.remove('invalid')">
					<option value=""></option>
					<option value="Beginner">Beginner</option>
					<option value="Novice">Novice</option>
					<option value="Competent">Competent</option>
					<option value="Advanced">Advanced</option>
					<option value="Graham Jarvis">Graham Jarvis</option>
				</select>
			</div>
			<!-- errors will go here -->

			<!-- EXTRAS -->
			<h4>Extras:</h4>
			<div class="p15-checkbox-group">
				<div class="extras-box">
					<input class="" type="checkbox" value="" name=""> BMW R1250 GS: 700.00 GBP
				</div>
				<div class="extras-box">
					<input class="" type="checkbox" value="" name=""> BMW F800 GS: 160.00 GBP
				</div>
				<div class="extras-box">
					<input class="" type="checkbox" value="" name=""> Motorcycle Damage Excess Reduction: 390.00 GBP
				</div>
				<div class="extras-box">
					<input class="" type="checkbox" value="" name=""> SRS - Rider: 1,685.00 GBP	
				</div>
			</div>
		</div>
		<!-- <div id="additionalGuests">
			<h4>Group Members Details</h4>
			<hr>
			<div class="guest">
				
				<div class="guest-rider">
					<h4>Rider Information</h4>
					Form to show if the guest is a rider.
				</div>
				<div class="guest-pillion">
					<h4>Pillion Information</h4>
					Form to show if the guest is a pillion.
				</div>
			</div>
		</div> -->
	</div>

	<div class="p15-tab">
		<h2>Booking Total</h2>
		<hr>
		<p>Review your booking total below and proceed to payment.</p>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th style="width: 15%;" scope="col">Item</th>
					<th style="width: 60%; text-align: center;" scope="col">QTY</th>
					<th style="width: 25%; text-align: right;" scope="col">Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="width: 60%;">Riders</td>
					<td style="width: 15%; text-align: center;">3</td>
					<td style="width: 25%; text-align: right;">7,500.00</td>
				</tr>
				<tr>
					<td style="width: 60%;">Pillions</td>
					<td style="width: 15%; text-align: center;">2</td>
					<td style="width: 25%; text-align: right;">3,000.00</td>
				</tr>
				<tr>
					<td style="width: 60%;">Motorcycle Upgrade - BMW1250GS</td>
					<td style="width: 15%; text-align: center;">1</td>
					<td style="width: 25%; text-align: right;">700.00</td>
				</tr>
				<tr>
					<td style="width: 60%;">Motorcycle Upgrade - BMW800GS</td>
					<td style="width: 15%; text-align: center;">1</td>
					<td style="width: 25%; text-align: right;">180.00</td>
				</tr>
				<tr>
					<td style="width: 60%;">Motorcycle Upgrade Insurance</td>
					<td style="width: 15%; text-align: center;">1</td>
					<td style="width: 25%; text-align: right;">300.00</td>
				</tr>
				<tr>
					<td style="width: 60%;">Single Room Suppliment - Rider</td>
					<td style="width: 15%; text-align: center;">1</td>
					<td style="width: 25%; text-align: right;">300.00</td>
				</tr>
			</tbody>
			<tfoot style="border-top: double grey;">
				<tr>
					<td colspan="2" style="width: 75%; text-align: right;"><b>Total</b></td>
					<td style="width: 25%; text-align: right;">£11,980.00</td>
				</tr>
				<tr>
					<td colspan="2" style="width: 75%; text-align: right;"><b>Deposit</b></td>
					<td style="width: 25%; text-align: right;">£2,500.00</td>
				</tr>
				<tr>
					<td colspan="2" style="width: 75%; text-align: right;"><b>Balance</b></td>
					<td style="width: 25%; text-align: right;">£9,480.00</td>
				</tr>
			</tfoot>
		</table>
		<!-- <hr>
		<h4>Payment Information:</h4>
		<div id="lastname-group" class="p15-input-group">
			<label for="amount">Deposit Amount:</label>
			<input class="p15-input-control" name="amount" type="text" placeholder="£2,500.00" disabled>
		</div>
		<div id="lastname-group" class="p15-input-group">
			<input class="p15-input-control" name="cardname" type="text" placeholder="Name on card...">
		</div>
		<div id="lastname-group" class="p15-input-group">
			<input class="p15-input-control" name="cardnumber" type="number" placeholder="Card Number: 4242-4242-4242-4242">
		</div> -->

		<hr>
		<h4>Cancellation Policy</h4>
		<p>If you cancel your booking before departure, cancellation charges will be applied as follows:</p>
		<ul>
			<li>61 days or more before tour start date: retention of deposit</li>
			<li>42-60 days before tour start date: retention of 50% of tour price</li>
			<li>28-41 days before tour start date: retention of 70% of tour price</li>
			<li>0-27 days before tour start date: retention of 100% tour price</li>
		</ul>

		<p>Please refer to our Terms & Conditions for further info regarding cancellations, changes or transferring your trip to a friend.</p>

	</div>


	<div style="overflow:auto;">
		<div style="float:right;">
			<button class="p15-btn" type="button" id="formPrev" onclick="formStep(-1)">Previous</button>
			<button class="p15-btn" type="button" id="formNextSubmit" onclick="formStep(1)">Next</button>
		</div>
	</div>

	<input type="hidden" name="action" value="submit_form">

</form>
<?php
}
?>
<!-- FOR TESTING -->
<pre>
	<?php 
		print_r($p15_tour_data);
	?>
</pre>
<!-- TESTING END -->

<!-- <form id="peak-15-form" name="form-booking" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

    <button id="formSubmit" type="submit" class="p15-btn">Submit <span class="fa fa-arrow-right"></span></button>

</form> -->

<script>
	var currentTab = 0; // Current tab is set to be the first tab (0)
	showTab(currentTab); // Display the current tab

	function showTab(n) {
	// This function will display the specified tab of the form ...
	var x = document.getElementsByClassName("p15-tab");
	x[n].style.display = "block";
	// ... and fix the Previous/Next buttons:
	if (n == 0) {
		document.getElementById("formPrev").style.display = "none";
	} else {
		document.getElementById("formPrev").style.display = "inline";
	}
	if (n == (x.length - 1)) {
		document.getElementById("formNextSubmit").innerHTML = "Proceed to Payment";
	} else {
		document.getElementById("formNextSubmit").innerHTML = "Next";
	}
	// ... and run a function that displays the correct step indicator:
	fixStepIndicator(n)
	}

	function formStep(n) {
	// This function will figure out which tab to display
	var x = document.getElementsByClassName("p15-tab");
	// Exit the function if any field in the current tab is invalid:
	if (n == 1 && !validateForm()) return false;
	// Hide the current tab:
	x[currentTab].style.display = "none";
	// Increase or decrease the current tab by 1:
	currentTab = currentTab + n;
	// if you have reached the end of the form... :
	if (currentTab >= x.length) {
		//...the form gets submitted:
		document.getElementById("p15_booking_form").submit();
		return false;
	}
	// Otherwise, display the correct tab:
	showTab(currentTab);
	}

	function validateForm() {
	// This function deals with validation of the form fields
	var x, y, i, valid = true;
	x = document.getElementsByClassName("p15-tab");
	y = x[currentTab].getElementsByClassName("p15-input-control");
	//   y = x[currentTab].getElementsByTagName("input");
	// A loop that checks every input field in the current tab:
	for (i = 0; i < y.length; i++) {
		// If a field is empty...
		if (y[i].value == "") {
		// add an "invalid" class to the field:
		y[i].className += " invalid";
		// and set the current valid status to false:
		valid = false;
		}
	}
	// If the valid status is true, mark the step as finished and valid:
	if (valid) {
		document.getElementsByClassName("p15-bookstep")[currentTab].className += " finish";
	}
	return valid; // return the valid status
	}

	function fixStepIndicator(n) {
	// This function removes the "active" class of all steps...
	var i, x = document.getElementsByClassName("p15-bookstep");
	for (i = 0; i < x.length; i++) {
		x[i].className = x[i].className.replace(" active", "");
	}
	//... and adds the "active" class to the current step:
	x[n].className += " active";
	}
</script>