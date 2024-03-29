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

<style>
	.rider-form {
		margin: 15px 0;
		padding: 15px 15px;
		border: solid 2px lightgrey;
	}

	.pillion-form {
		margin: 15px 0;
		padding: 15px 15px;
		background-color: aliceblue;
		border: solid 2px lightgrey;
	}

	.extras-box {
		padding: 10px;
		background: white;
	}
</style>

<form id="bookingForm" name="form-booking" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

	<input type="hidden" name="formname" value="Tour Booking Form">
    <input type="hidden" name="pagename" value="">
    <input type="hidden" name="statuscode" value="">
    <input type="hidden" name="rule" value="Contacts with same First Name Email">
    <!-- TRIP, DESTINATION & ACTIVITY INTEREST -->
    <input type="hidden" name="p15_trips" value="">
    <input type="hidden" name="destination" value="">
    <input type="hidden" name="tripactivity" value="">
    <input type="hidden" name="p15_channel" value="Web">
    <!-- BOOKING FIELDS -->
	<!-- <input type="hidden" name="contact.p15_contacttype_contactid" value="client"> -->
	<!-- &p15_guests.contact.1.p15_vendorserviceitemres.1=Cabin A1
	&p15_guests.contact.2.p15_vendorserviceitemres.1=Cabin A1 -->
	<input type="hidden" name="departure_guid" value=""> <!-- Routes to: &p15_bookings.p15_tripdepartures_bookingsid=[departurename or departurecode or GUID] -->
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
			<div id="tournameGroup" class="p15-input-group">
				<select id="tourSelect" class="p15-input-control" name="tourname" oninput="clearError(this)">
					<option value="">Select Tour</option>
					<?php
						foreach ( $trips as $trip ) {
							echo '<option value="' . $trip['@attributes']['id'] . '">' . $trip['@attributes']['name'] . '</option>';
						}
					?>
				</select>
			</div>

			<div id="departureGroup" class="p15-input-group" style="display: none;">
				<select id="departureList" class="p15-input-control" name="p15_bookings.p15_tripdepartures_bookingsid" oninput="clearError(this)">
				</select>
			</div>
			<!-- errors will go here -->	
		</div>
		<div id="departureNotices"></div>
		<div id="departureInfo" class="form-section" style="display:none;">
			<h2>Departure Info:</h2>
			<!-- <p>Please select how many people there are in your group.</p> -->
			<!-- <p><b>Available Spaces:</b> <span id="availableSpaces">< ?php echo $group_size; ?></span></p> -->
			<p><b>Available Spaces:</b> <span id="availableSpaces"></span></p>
			<p><b>Pillion Friendly:</b> <span id="pillionFriendly"></span></p>
			<div id="tripPriceInfo">
			</div>
			<!-- <select id="group_size_list" class="p15-input-control" name="ridercount" oninput="clearError(this)">
			</select> -->
		</div>
	</div>

	<div class="p15-tab">
		<h2>Guest Infomation</h2>
		<hr>
		<div id="bookedGuestForms">
			<div class="mainguest-info guest-form rider-form" data-price="" data-price-name="" data-price-id="">
				<h4 class="guest-title">Main Guest / Group Organiser</h4>
				<input type="hidden" name="p15_guests.contact.1.isClient" value="true">
				<input type="hidden" id="bookedRiderPrice" name="p15_guests.contact.1.p15_tripprices.1" value="">
				<!-- FIRST NAME -->
				<div id="firstname-group" class="p15-input-group">
					<input type="text" class="p15-input-control" name="firstname" placeholder="First name..." oninput="clearError(this)">
					<!-- errors will go here -->
				</div>

				<!-- LAST NAME -->
				<div id="lastname-group" class="p15-input-group">
					<input type="text" class="p15-input-control" name="lastname" placeholder="Last name..." oninput="clearError(this)">
					<!-- errors will go here -->
				</div>

				<!-- EMAIL ADDRESS -->
				<div id="email-group" class="p15-input-group">
					<input type="text" class="p15-input-control" name="email" placeholder="Email address..." oninput="clearError(this)">
					<!-- errors will go here -->
				</div>

				<!-- PHONE NUMBER -->
				<div id="phone-group" class="p15-input-group">
					<input type="tel" class="p15-input-control"  placeholder="Phone number (Eg. +44 123 456 7891)" name="telephone1" oninput="clearError(this)">
				</div>
				<!-- errors will go here -->

				<!-- LICENSE -->
				<div id="licensetype-group" class="p15-input-group">
					<label for="rideexp_motorcyclelicensetype" style="display:none">Motorcycle License Type <span style="color:red">*</span></label>
					<select class="p15-input-control" name="rideexp_motorcyclelicensetype" oninput="clearError(this)">
						<option value="">License Type</option>
						<option value="No License">No License</option>
						<option value="Restricted">Restricted</option>
						<option value="Unrestricted">Unrestricted</option>
					</select>
				</div>
				<!-- errors will go here -->
				
				<!-- ROAD RIDING LEVEL -->
				<div id="levelroad-group" class="p15-input-group">
					<label for="rideexp_roadridinglevel" style="display:none">Road Riding Level <span style="color:red">*</span></label>
					<select class="p15-input-control" name="rideexp_roadridinglevel" oninput="clearError(this)">
						<option value="">Road Riding Level</option>
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
					<label for="rideexp_offroadridinglevel" style="display:none">Off-Road Riding Level <span style="color:red">*</span></label>
					<select class="p15-input-control" name="rideexp_offroadridinglevel" oninput="clearError(this)">
						<option value="">Off-Road Riding Level</option>
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
				<div id="mainGuestExtras" class="p15-checkbox-group">
				</div>
				<hr>
			</div>
			<div id="additionalGuests">
				
				<!-- <h4>Group Members Details</h4>
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
				</div> -->
			</div>
			<div id="guestFormNotices"></div>
			<div class="btn-group" id="addGuest">
			</div>
		</div>
		
	</div>

	<div class="p15-tab">
		<h2>Booking Total</h2>
		<hr>
		<p>Review your booking total below and proceed to payment.</p>

		<!-- <table class="table table-striped table-sm">
			<thead>
				<tr>
					<th style="width: 15%;" scope="col">Item</th>
					<th style="width: 60%; text-align: center;" scope="col">QTY</th>
					<th style="width: 25%; text-align: right;" scope="col">Amount</th>
				</tr>
			</thead>
			<tbody id="bookedItems">
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
		</table> -->
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
			<button class="p15-btn" type="button" id="formNextSubmit" style="display:none" onclick="formStep(1)">Next</button>
		</div>
	</div>

	<input type="hidden" name="action" value="submit_form">

</form>

<table class="table table-striped table-sm">
	<thead>
		<tr>
			<th style="width: 15%;" scope="col">Item</th>
			<th style="width: 60%; text-align: center;" scope="col">QTY</th>
			<th style="width: 25%; text-align: right;" scope="col">Amount</th>
		</tr>
	</thead>
	<tbody id="bookedItems">
		<tr>	
			<td class="bookingItem" style="width: 60%;">-</td>
			<td class="bookingQty" style="width: 15%; text-align: center;">-</td>
			<td class="bookingAmt" style="width: 25%; text-align: right;">-</td>
		</tr>
	</tbody>
	<tfoot style="border-top: double grey;">
		<tr>
			<td colspan="2" style="width: 75%; text-align: right;"><b>Total</b></td>
			<td id="bookingTotal" style="width: 25%; text-align: right;">£0.00</td>
		</tr>
		<!-- <tr>
			<td colspan="2" style="width: 75%; text-align: right;"><b>Deposit</b></td>
			<td style="width: 25%; text-align: right;">£2,500.00</td>
		</tr>
		<tr>
			<td colspan="2" style="width: 75%; text-align: right;"><b>Balance</b></td>
			<td style="width: 25%; text-align: right;">£9,480.00</td>
		</tr> -->
	</tfoot>
</table>

<?php
}
?>
<!-- FOR TESTING -->
<pre>
	<!-- < ?php 
		print_r($trips[0]);
	?> -->
</pre>
<!-- TESTING END -->

<!-- <form id="peak-15-form" name="form-booking" action="#" method="post" data-url="< ?php echo admin_url('admin-ajax.php'); ?>">

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
		document.getElementById("bookingForm").submit();
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

	function clearError(z) {
		z.classList.remove('invalid');
	}
</script>