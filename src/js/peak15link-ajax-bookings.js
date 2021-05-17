jQuery(document).ready(function() {

    var dataUrl 			= jQuery("#p15_booking_form").data("url");
	var tourSelect 			= jQuery("#tourSelect");
	var departureGroup 		= jQuery("#departureGroup");
	var depList				= jQuery("#departureList");
	var departureInfo 		= jQuery("#departureInfo");
	var departureNotices	= jQuery("#departureNotices");
	var depInfoPillion		= jQuery("#pillionFriendly");
	var tripPriceInfo		= jQuery("#tripPriceInfo");
	var mainGuestExtras		= jQuery("#mainGuestExtras");
	var guestForms			= jQuery("#additionalGuests");
	var guestFormNotices	= jQuery("#guestFormNotices");
	var addGuest			= jQuery("#addGuest");
	var currency			= { style: "currency", currency: "GBP" };

	var depPrices;
	var riderPrice;
	var riderPriceID;
	var spotsLeft;
	var addRider;
	var addPillion;

    tourSelect.change(function(){

		departureInfo.css("display", "none");
		departureGroup.css("display", "none");
		departureNotices.html("");

		var tripId = tourSelect.val();

        var tripData = {
            'tripId'  	: tripId,
			'action'	: 'update_form'
        }

        jQuery.ajax({
			type		: 'POST',
			url			: dataUrl,
			data   		: tripData
		})

		.done( function (data) {

			var obj = JSON.parse(data);
			var departures = obj['Departures']
			var pillionFriendly = obj.PillonFriendly;

			depList.html('<option value="">Select Departure Date...</option>');

			departures.forEach( item => {
				var startDate 		= new Date(item['@attributes'].startDate);
				var endDate 		= new Date(item['@attributes'].endDate);
				var depID			= item['@attributes'].id;
				if ( item['@attributes'].availableSpaces === "0" ) {
					spotsLeft = "SOLD OUT";
				} else {
					spotsLeft = item['@attributes'].availableSpaces;
				}
				depList.append(jQuery('<option>', {
					value: depID,
					text: startDate.toDateString() + ' to ' + endDate.toDateString() + ' - Spots Left: ' + spotsLeft,
				}));
			});

			if ( tripId === "" ) {
				departureGroup.css("display", "none");
			} else {
				departureGroup.css("display", "block");
			}

			depList.change( function() {

				// Remove all of our elements from the DOM if previously set.
				tripPriceInfo.html("");
				departureNotices.html("");
				mainGuestExtras.html("");
				guestForms.html("");
				guestFormNotices.html("");
				addGuest.html("");

				var selectedDepartId = depList.val();

				// Set the main departure GUID for the booking
				jQuery('input[name=departure_guid]').val(selectedDepartId);

				// Check the ID of the selected departure and iterate over the prices for the main guest.
				departures.forEach( item => {
					if ( item['@attributes'].id === selectedDepartId ) {
						spotsLeft = item['@attributes'].availableSpaces;
						jQuery("#availableSpaces").text(spotsLeft);

						if (spotsLeft === "0") {

							departureInfo.css("display", "none");

							departureNotices.html('<div class="p15-message p15-message-error">Sorry, this date is sold out. Please select another date or send us an email to enquire about cancellations for this date.</div>');

							return;
						}

						depPrices = item['Prices']['Price'];

						var c = 1;

						depPrices.forEach( i => {

							if ( i['@attributes'].category === "Rider Base Price" ) {
								riderPrice = new Number(i['@attributes'].amount).toLocaleString("en-GB", currency);
								riderPriceID = i['@attributes'].id;
								tripPriceInfo.append(
									'<p><b>Rider Price:</b> <span id="riderPrice">' + riderPrice + '</span></p>',
								);
								// Add the booked rider price to the hidden form input field for the main guest
								jQuery("#bookedRiderPrice").val(riderPriceID);
							}
							if ( i['@attributes'].category === "Pillion Base Price" ) {
								var pillionPrice = new Number(i['@attributes'].amount).toLocaleString("en-GB", currency);
								tripPriceInfo.append(
									'<p><b>Pillion Price:</b> <span id="pillionPrice">' + pillionPrice + '</span></p>',
								);
							}

							if ( i['@attributes'].category != "Pillion Base Price" && i['@attributes'].category != "Rider Base Price" && i['@attributes'].name != "SRS - Pillion" ) {
								
								console.log(  i['@attributes'].category + ': ' + i['@attributes'].name + ' - ' + i['@attributes'].amount );
								// Build the extras fields for the main guest
								mainGuestExtras.append(
									'<div class="extras-box">' +
										'<input type="hidden" name="p15_guests.contact.1.p15_vendorserviceitemres.' + c +'" value="BMW R1250 GS">' +
										'<input class="" type="checkbox" value="' + i['@attributes'].id + '" name="' + c +'"> ' + i['@attributes'].name + ': ' + new Number(i['@attributes'].amount).toLocaleString("en-GB", currency) +
									'</div>'
								);
								c++
							}
						});

					}
				});

				depInfoPillion.text(pillionFriendly);

				// This function iterates over the prices for the selected departure and appends the extras to additional guests.
				function setPriceFields(n, t) {

					// NOTE: Consider using a JS Switch statement to switch between
					// Rider pricing and Pillion pricing options on click of the "Add Rider" / "Add Pillion" buttons

					n;
					t;

					switch(t) {

						case "pillion":
							// Code to run if case is "Pillion"
							console.log("This is a pillion!");
							break;

						case "rider":
							// Code to run of case is "Rider"
							console.log("This is a rider!");
							break;

						default:
							console.log("Only riders allowed!")
					}

					departures.forEach( item => {
						if ( item['@attributes'].id === selectedDepartId ) {

							depPrices = item['Prices']['Price'];

							var c = 2;

							depPrices.forEach( i => {


								if ( i['@attributes'].category != "Pillion Base Price" && i['@attributes'].category != "Rider Base Price" && i['@attributes'].name != "SRS - Pillion" ) {
											
									console.log(  i['@attributes'].category + ': ' + i['@attributes'].name + ' - ' + i['@attributes'].amount );
									// Build the extras fields for the main guest
									jQuery('#guestExtras' + n + '').append(
										'<div class="extras-box">' +
											'<input type="hidden" name="p15_guests.contact.' + n + '.p15_vendorserviceitemres.' + c +'" value="BMW R1250 GS">' +
											'<input class="" type="checkbox" value="' + i['@attributes'].id + '" name="' + c +'"> ' + i['@attributes'].name + ': ' + new Number(i['@attributes'].amount).toLocaleString("en-GB", currency) +
										'</div>'
									);
									c++
								}
							});
						}
					});

					// jQuery('#guestExtras' + n + '').append(
					// 	'Extras for Guest: ' + n +
					// 	'<div class="extras-box">' +
					// 		'<input type="hidden" name="p15_guests.contact.' + n + '.p15_vendorserviceitemres." value="BMW R1250 GS">' +
					// 		'<input class="" type="checkbox" value=" i[@attributes].id " name=""> [@attributes].name + :  + new Number(i[@attributes].amount).toLocaleString("en-GB", currency)' +
					// 	'</div>'
					// 	);
				}

				// If there are more than ONE available spaces on the selected departure,
				// check if the tour is Pillion Friendly and append the "Add Rider" and or "Add Pillion" buttons ot the form.
				if ( pillionFriendly === "Yes" && spotsLeft > 1 ) {
					// Display the "Add Rider" AND "Add Pillion" Buttons.
					addGuest.html(
						'<button class="p15-btn" type="button" id="addRider"><i class="fas fa-plus-square" style="margin-right:0.25rem;"></i> Add Rider</button>' +
						'<button class="p15-btn" type="button" id="addPillion"><i class="fas fa-plus-square" style="margin-right:0.25rem;"></i> Add Pillon</button>'
					);
					addRider 	= jQuery("#addRider");
					addPillion 	= jQuery("#addPillion");

					var n = 2;
					
					// Display the "Add Rider" button
					addRider.click( function() {

						if ( n <= spotsLeft ) {

							console.log('Counter: ' + n + '. Spots Left: ' + spotsLeft);
							
							// Append the Rider guest form fields
							guestForms.append(
								'<div id="guest' + n + '" class="rider-form">' + 
									'<h4>Guest ' + n + ' (Rider)</h4>' +
									'<input type="hidden" name="p15_guests.contact.' + n + '.isClient" value="true">' +
									'<input type="hidden" id="bookedRiderPrice' + n + '" name="p15_guests.contact.' + n + '.p15_tripprices.1" value="">' +
									// Set samehousehold to FALSE:
									'<input type="hidden" name="p15_guests.contact.' + n + '.samehousehold" value="false">' +
									'<!-- FIRST NAME -->' +
									'<div id="firstname-group" class="p15-input-group">' +
										'<input type="text" class="p15-input-control" name="firstname" placeholder="First name..." oninput="clearError(this)">' +
										'<!-- errors will go here -->' +
									'</div>' +
		
									'<!-- LAST NAME -->' +
									'<div id="lastname-group" class="p15-input-group">' +
										'<input type="text" class="p15-input-control" name="lastname" placeholder="Last name..." oninput="clearError(this)">' +
										'<!-- errors will go here -->' +
									'</div>' +

									'<div id="rider-fields' + n + '">' +
										'<!-- LICENSE -->' +
										'<div id="licensetype-group" class="p15-input-group">' +
											'<label for="rideexp_motorcyclelicensetype" style="display:none">Motorcycle License Type <span style="color:red">*</span></label>' +
											'<select class="p15-input-control" name="rideexp_motorcyclelicensetype" oninput="clearError(this)">' +
												'<option value="">License Type</option>' +
												'<option value="No License">No License</option>' +
												'<option value="Restricted">Restricted</option>' +
												'<option value="Unrestricted">Unrestricted</option>' +
											'</select>' +
										'</div>' +
										'<!-- errors will go here -->' +
		
										'<!-- ROAD RIDING LEVEL -->' +
										'<div id="levelroad-group" class="p15-input-group">' +
											'<label for="rideexp_roadridinglevel" style="display:none">Road Riding Level <span style="color:red">*</span></label>' +
											'<select class="p15-input-control" name="rideexp_roadridinglevel" oninput="clearError(this)">' +
												'<option value="">Road Riding Level</option>' +
												'<option value="Beginner">Beginner</option>' +
												'<option value="Novice">Novice</option>' +
												'<option value="Competent">Competent</option>' +
												'<option value="Advanced">Advanced</option>' +
												'<option value="Valentino Rossi">Valentino Rossi</option>' +
											'</select>' +
										'</div>' +
										'<!-- errors will go here -->' +
										
										'<!-- OFFROAD RIDING LEVEL -->' +
										'<div id="leveloffroad-group" class="p15-input-group">' +
											'<label for="rideexp_offroadridinglevel" style="display:none">Off-Road Riding Level <span style="color:red">*</span></label>' +
											'<select class="p15-input-control" name="rideexp_offroadridinglevel" oninput="clearError(this)">' +
												'<option value="">Off-Road Riding Level</option>' +
												'<option value="Beginner">Beginner</option>' +
												'<option value="Novice">Novice</option>' +
												'<option value="Competent">Competent</option>' +
												'<option value="Advanced">Advanced</option>' +
												'<option value="Graham Jarvis">Graham Jarvis</option>' +
											'</select>' +
										'</div>' +
										'<!-- errors will go here -->' +
										
										'<!-- EXTRAS -->' +
										'<h4>Extras:</h4>' +
										'<div id="guestExtras' + n + '" class="p15-checkbox-group extras-area">' +
											// setPriceFields
										'</div>' +
									'</div>' +
								'</div>' +
								'<hr>'
							);
							setPriceFields(n, "rider");
							n++
						}
						if ( n > spotsLeft ) {
							guestFormNotices.html('<div class="p15-message p15-message-error"><small>Max number of guests reached for this tour.</small></div>');
						}
					});

					// Display the "Add Pillion" button
					addPillion.click( function() {

						if ( n <= spotsLeft ) {

							console.log('Counter: ' + n + '. Spots Left: ' + spotsLeft);
							
							// Append the Rider guest form fields
							guestForms.append(
								'<div id="guest' + n + '" class="pillion-form">' + 
									'<h4>Guest ' + n + ' (Pillion)</h4>' +
									'<input type="hidden" name="p15_guests.contact.' + n + '.isClient" value="true">' +
									'<input type="hidden" id="bookedPillionPrice' + n + '" name="p15_guests.contact.' + n + '.p15_tripprices.1" value="">' +
									// Set samehousehold to FALSE:
									'<input type="hidden" name="p15_guests.contact.' + n + '.samehousehold" value="false">' +
									'<!-- FIRST NAME -->' +
									'<div id="firstname-group" class="p15-input-group">' +
										'<input type="text" class="p15-input-control" name="firstname" placeholder="First name..." oninput="clearError(this)">' +
										'<!-- errors will go here -->' +
									'</div>' +
		
									'<!-- LAST NAME -->' +
									'<div id="lastname-group" class="p15-input-group">' +
										'<input type="text" class="p15-input-control" name="lastname" placeholder="Last name..." oninput="clearError(this)">' +
										'<!-- errors will go here -->' +
									'</div>' +
										
									'<!-- EXTRAS -->' +
									'<h4>Extras:</h4>' +
									'<div id="guestExtras' + n + '" class="p15-checkbox-group extras-area">' +
										// setPriceFields
									'</div>' +

								'</div>' +
								'<hr>'
							);
							setPriceFields(n, "pillion");
							n++
						}
						if ( n > spotsLeft ) {
							guestFormNotices.html('<div class="p15-message p15-message-error"><small>Max number of guests reached for this tour.</small></div>');
						}
					});

				} else if ( pillionFriendly === "No" && spotsLeft > 1 ) {
					// Just display the "Add Rider" button.
					addGuest.html(
						'<button class="p15-btn" type="button" id="addRider"><i class="fas fa-plus-square" style="margin-right:0.25rem;"></i> Add Rider</button>'
					);
					addRider = jQuery("#addRider");

					var n = 2;

					addRider.click( function() {

						if ( n <= spotsLeft ) {

							console.log('Counter: ' + n + '. Spots Left: ' + spotsLeft);

							// Append the Rider guest form fields
							guestForms.append(
								'<div id="guest' + n + '" class="rider-form">' + 
									'<h4>Guest ' + n + ' (Rider)</h4>' +
									'<input type="hidden" name="p15_guests.contact.' + n + '.isClient" value="true">' +
									// Set samehousehold to FALSE:
									'<input type="hidden" name="p15_guests.contact.' + n + '.samehousehold" value="false">' +
									'<!-- FIRST NAME -->' +
									'<div id="firstname-group" class="p15-input-group">' +
										'<input type="text" class="p15-input-control" name="firstname" placeholder="First name..." oninput="clearError(this)">' +
										'<!-- errors will go here -->' +
									'</div>' +
		
									'<!-- LAST NAME -->' +
									'<div id="lastname-group" class="p15-input-group">' +
										'<input type="text" class="p15-input-control" name="lastname" placeholder="Last name..." oninput="clearError(this)">' +
										'<!-- errors will go here -->' +
									'</div>' +

									'<div id="rider-fields' + n + '">' +
										'<!-- LICENSE -->' +
										'<div id="licensetype-group" class="p15-input-group">' +
											'<label for="rideexp_motorcyclelicensetype" style="display:none">Motorcycle License Type <span style="color:red">*</span></label>' +
											'<select class="p15-input-control" name="rideexp_motorcyclelicensetype" oninput="clearError(this)">' +
												'<option value="">License Type</option>' +
												'<option value="No License">No License</option>' +
												'<option value="Restricted">Restricted</option>' +
												'<option value="Unrestricted">Unrestricted</option>' +
											'</select>' +
										'</div>' +
										'<!-- errors will go here -->' +
		
										'<!-- ROAD RIDING LEVEL -->' +
										'<div id="levelroad-group" class="p15-input-group">' +
											'<label for="rideexp_roadridinglevel" style="display:none">Road Riding Level <span style="color:red">*</span></label>' +
											'<select class="p15-input-control" name="rideexp_roadridinglevel" oninput="clearError(this)">' +
												'<option value="">Road Riding Level</option>' +
												'<option value="Beginner">Beginner</option>' +
												'<option value="Novice">Novice</option>' +
												'<option value="Competent">Competent</option>' +
												'<option value="Advanced">Advanced</option>' +
												'<option value="Valentino Rossi">Valentino Rossi</option>' +
											'</select>' +
										'</div>' +
										'<!-- errors will go here -->' +
										
										'<!-- OFFROAD RIDING LEVEL -->' +
										'<div id="leveloffroad-group" class="p15-input-group">' +
											'<label for="rideexp_offroadridinglevel" style="display:none">Off-Road Riding Level <span style="color:red">*</span></label>' +
											'<select class="p15-input-control" name="rideexp_offroadridinglevel" oninput="clearError(this)">' +
												'<option value="">Off-Road Riding Level</option>' +
												'<option value="Beginner">Beginner</option>' +
												'<option value="Novice">Novice</option>' +
												'<option value="Competent">Competent</option>' +
												'<option value="Advanced">Advanced</option>' +
												'<option value="Graham Jarvis">Graham Jarvis</option>' +
											'</select>' +
										'</div>' +
										'<!-- errors will go here -->' +
										
										'<!-- EXTRAS -->' +
										'<h4>Extras:</h4>' +
										'<div id="guestExtras' + n + '" class="p15-checkbox-group extras-area">' +
											// setPriceFields
										'</div>' +
									'</div>' +
								'</div>' +
								'<hr>'
							);
							setPriceFields(n);
							n++
						}
						if ( n > spotsLeft ) {
							guestFormNotices.html('<div class="p15-message p15-message-error"><small>Max number of guests reached for this tour.</small></div>');
						}
					});
					
				} else {
					guestFormNotices.html(
						'<div class="p15-message p15-message-warn"><small><b>Please Note:</b> This is the last spot available for this date.</small></div>'
					);
				}

				if ( depList === "" ) {
					departureInfo.css("display", "none");
				} else {
					departureInfo.css("display", "block");
				}

			});


			// Build the forms on the following tab
			function buildGuestForms() {

				console.log(jQuery( 'input[name=departure_guid]').val() );

				var maxGuests	= groupList.val();
				

				guestForms.html("");

				var i = 2;
				var n = 2;

				if ( pillionFriendly === "Yes" ) {

					console.log("This is a Pillion Friendly Trip.");
					
					while ( i <= guestCount ) {
						guestForms.append(
							'<hr>' +
							'<div id="guest' + n + '">' + 
								'<h4>Guest ' + n + '</h4>' +
								'<input type="hidden" name="p15_guests.contact.' + n + '.isClient" value="true">' +
								'<input type="hidden" name="p15_guests.contact.' + n + '.samehousehold" value="true">' +
								'<!-- FIRST NAME -->' +
								'<div id="firstname-group" class="p15-input-group">' +
									'<input type="text" class="p15-input-control" name="firstname" placeholder="First name..." oninput="clearError(this)">' +
									'<!-- errors will go here -->' +
								'</div>' +
	
								'<!-- LAST NAME -->' +
								'<div id="lastname-group" class="p15-input-group">' +
									'<input type="text" class="p15-input-control" name="lastname" placeholder="Last name..." oninput="clearError(this)">' +
									'<!-- errors will go here -->' +
								'</div>' +
	
								'<div class="p15-input-group" data-guestnum="' + n + '">' +
									'<select id="guestType' + n + '" class="p15-input-control guest-type-select">' +
										'<option value"">Guest Type</option>' +
										'<option value"Rider">Rider</option>' +
										'<option value"Pillion">Pillion</option>' +
									'</select>' +
								'</div>' +
							'</div>' 
						);
	
						// guestForms.append(
						// 		'<div id="rider-fields' + n + '">' +
						// 			'<!-- LICENSE -->' +
						// 			'<div id="licensetype-group" class="p15-input-group">' +
						// 				'<label for="rideexp_motorcyclelicensetype" style="display:none">Motorcycle License Type <span style="color:red">*</span></label>' +
						// 				'<select class="p15-input-control" name="rideexp_motorcyclelicensetype" oninput="clearError(this)">' +
						// 					'<option value="">License Type</option>' +
						// 					'<option value="No License">No License</option>' +
						// 					'<option value="Restricted">Restricted</option>' +
						// 					'<option value="Unrestricted">Unrestricted</option>' +
						// 				'</select>' +
						// 			'</div>' +
						// 			'<!-- errors will go here -->' +
	
						// 			'<!-- ROAD RIDING LEVEL -->' +
						// 			'<div id="levelroad-group" class="p15-input-group">' +
						// 				'<label for="rideexp_roadridinglevel" style="display:none">Road Riding Level <span style="color:red">*</span></label>' +
						// 				'<select class="p15-input-control" name="rideexp_roadridinglevel" oninput="clearError(this)">' +
						// 					'<option value="">Road Riding Level</option>' +
						// 					'<option value="Beginner">Beginner</option>' +
						// 					'<option value="Novice">Novice</option>' +
						// 					'<option value="Competent">Competent</option>' +
						// 					'<option value="Advanced">Advanced</option>' +
						// 					'<option value="Valentino Rossi">Valentino Rossi</option>' +
						// 				'</select>' +
						// 			'</div>' +
						// 			'<!-- errors will go here -->' +
									
						// 			'<!-- OFFROAD RIDING LEVEL -->' +
						// 			'<div id="leveloffroad-group" class="p15-input-group">' +
						// 				'<label for="rideexp_offroadridinglevel" style="display:none">Off-Road Riding Level <span style="color:red">*</span></label>' +
						// 				'<select class="p15-input-control" name="rideexp_offroadridinglevel" oninput="clearError(this)">' +
						// 					'<option value="">Off-Road Riding Level</option>' +
						// 					'<option value="Beginner">Beginner</option>' +
						// 					'<option value="Novice">Novice</option>' +
						// 					'<option value="Competent">Competent</option>' +
						// 					'<option value="Advanced">Advanced</option>' +
						// 					'<option value="Graham Jarvis">Graham Jarvis</option>' +
						// 				'</select>' +
						// 			'</div>' +
						// 			'<!-- errors will go here -->' +
									
						// 			'<!-- EXTRAS -->' +
						// 			'<h4>Extras:</h4>' +
						// 			'<div class="p15-checkbox-group extras-area">' +
	
						// 			'</div>' +
						// 		'</div>' +
						// 	'</div>'
						// );
	
						i++;
						n++;
					}

				} else {

					console.log("This is NOT a Pillion Friendly Trip.");
					
					while ( i <= guestCount ) {
						guestForms.append(
							'<hr>' +
							'<div id="guest' + n + '">' + 
								'<h4>Guest ' + n + '</h4>' +
								'<input type="hidden" name="p15_guests.contact.' + n + '.isClient" value="true">' +
								// Set samehousehold to FALSE:
								'<input type="hidden" name="p15_guests.contact.' + n + '.samehousehold" value="false">' +
								'<!-- FIRST NAME -->' +
								'<div id="firstname-group" class="p15-input-group">' +
									'<input type="text" class="p15-input-control" name="firstname" placeholder="First name..." oninput="clearError(this)">' +
									'<!-- errors will go here -->' +
								'</div>' +
	
								'<!-- LAST NAME -->' +
								'<div id="lastname-group" class="p15-input-group">' +
									'<input type="text" class="p15-input-control" name="lastname" placeholder="Last name..." oninput="clearError(this)">' +
									'<!-- errors will go here -->' +
								'</div>' +

								'<div id="rider-fields' + n + '">' +
									'<!-- LICENSE -->' +
									'<div id="licensetype-group" class="p15-input-group">' +
										'<label for="rideexp_motorcyclelicensetype" style="display:none">Motorcycle License Type <span style="color:red">*</span></label>' +
										'<select class="p15-input-control" name="rideexp_motorcyclelicensetype" oninput="clearError(this)">' +
											'<option value="">License Type</option>' +
											'<option value="No License">No License</option>' +
											'<option value="Restricted">Restricted</option>' +
											'<option value="Unrestricted">Unrestricted</option>' +
										'</select>' +
									'</div>' +
									'<!-- errors will go here -->' +
	
									'<!-- ROAD RIDING LEVEL -->' +
									'<div id="levelroad-group" class="p15-input-group">' +
										'<label for="rideexp_roadridinglevel" style="display:none">Road Riding Level <span style="color:red">*</span></label>' +
										'<select class="p15-input-control" name="rideexp_roadridinglevel" oninput="clearError(this)">' +
											'<option value="">Road Riding Level</option>' +
											'<option value="Beginner">Beginner</option>' +
											'<option value="Novice">Novice</option>' +
											'<option value="Competent">Competent</option>' +
											'<option value="Advanced">Advanced</option>' +
											'<option value="Valentino Rossi">Valentino Rossi</option>' +
										'</select>' +
									'</div>' +
									'<!-- errors will go here -->' +
									
									'<!-- OFFROAD RIDING LEVEL -->' +
									'<div id="leveloffroad-group" class="p15-input-group">' +
										'<label for="rideexp_offroadridinglevel" style="display:none">Off-Road Riding Level <span style="color:red">*</span></label>' +
										'<select class="p15-input-control" name="rideexp_offroadridinglevel" oninput="clearError(this)">' +
											'<option value="">Off-Road Riding Level</option>' +
											'<option value="Beginner">Beginner</option>' +
											'<option value="Novice">Novice</option>' +
											'<option value="Competent">Competent</option>' +
											'<option value="Advanced">Advanced</option>' +
											'<option value="Graham Jarvis">Graham Jarvis</option>' +
										'</select>' +
									'</div>' +
									'<!-- errors will go here -->' +
									
									'<!-- EXTRAS -->' +
									'<h4>Extras:</h4>' +
									'<div class="p15-checkbox-group extras-area">' +
	
									'</div>' +
								'</div>' +
							'</div>'
						);

						// // Load the pricng and extras fields here for the current / selected departure.
						// var selectedDepartId = depList.val();
						// departures.forEach( item => {
						// 	if ( item['@attributes'].id === selectedDepartId ) {
						// 		var depPrices = item['Prices']['Price'];
						// 	}
						// });
						// console.log(depPrices);
	
						i++;
						n++;
					}
				}

				// Place a callback here function after the change event has completed
				getGuestFields();

			};

			/**
		 	* 1. Add an on change event on the Guest Type dropdown list,
			* 2. Get the value of the data attribute for the parent element (the main form div),
			* 3. Pass the value of the parent element data attribute to the function as a parameter,
			* 4. Use the parameter value to set unique identifier in the form inputs.
			*/

			// var guestTypeSelect = document.getElementsByClassName('guest-type-select');
			// console.log(guestTypeSelect);
			// for ( var i = 0; i < guestTypeSelect.lenght; i++ ) {
			// 	console.log()

			// }

		})
		
		.fail( function(data) {
			console.log("Error");
		});

    })


    // process the form
    jQuery('#peak-15-form').submit(function(event) {

		jQuery('#formNextSubmit').attr("disabled","disabled");

        jQuery('.form-group').removeClass('p15-error'); // remove the error class
        jQuery('.p15-input-notif').remove(); // remove the error text

        // get the form data

        // Check which form is being submitted by checking the ID of the form
        // Then set the formData Varibable to the inputs contained in the form
    
        console.log('Booking Form submitted.')
        
        // Attach the form data to a variable as an array.
        var formData = {
            // Hidden Values
            'formname'    				        : jQuery('input[name=formname]').val(),
            'pagename'    				        : jQuery('input[name=pagename]').val(),
            'statuscode'    		            : jQuery('input[name=statuscode]').val(),
            'rule' 					            : jQuery('input[name=rule]').val(),
            'ruletype' 					        : jQuery('input[name=ruletype]').val(),
            'contacttype'    			        : jQuery('input[name=contacttype]').val(),
            'action'       			            : jQuery('input[name=action]').val(),
            
            // User Inputs
            // Contact Record Fields
            'firstname'    				        : jQuery('input[name=firstname]').val(),
            'lastname'     				        : jQuery('input[name=lastname]').val(),
            'email'        				        : jQuery('input[name=email]').val(),
            'telephone1'        		        : jQuery('input[name=telephone1]').val(),
            'rideexp_motorcyclelicensetype'     : jQuery('select[name=rideexp_motorcyclelicensetype]').val(),
            'rideexp_licenseheldsince'          : jQuery('input[name=rideexp_licenseheldsince]').val(),
            'rideexp_roadridinglevel'           : jQuery('select[name=rideexp_roadridinglevel]').val(),
            'rideexp_offroadridinglevel'        : jQuery('select[name=rideexp_offroadridinglevel]').val()
        }

        console.log(formData);

        // process the form
        jQuery.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : dataUrl, // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data);

                // here we will handle errors and validation messages
                if ( ! data.success) {

					jQuery('#formNextSubmit').removeAttr("disabled","disabled");

                    // handle validation errors ---------------
                    if (data.errors.validation) {
                        jQuery('#peak-15-form').html('<div class="p15-message p15-message-error"><b>' + data.errors.validation + '</b><br>' + data.message + '</div>');
                    }

                    // handle errors for firstname ---------------
                    if (data.errors.firstname) {
                        jQuery('#firstname-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#firstname-group').append('<div class="p15-input-notif"><small>' + data.errors.firstname + '</small></div>'); // add the actual error message under our input
                    }

                    // handle errors for last name ---------------
                    if (data.errors.lastname) {
                        jQuery('#lastname-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#lastname-group').append('<div class="p15-input-notif"><small>' + data.errors.lastname + '</small></div>'); // add the actual error message under our input
                    }
        
                    // handle errors for email ---------------
                    if (data.errors.email) {
                        jQuery('#email-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#email-group').append('<div class="p15-input-notif"><small>' + data.errors.email + '</small></div>'); // add the actual error message under our input
                    }

                    // handle errors for telephone1 ---------------
                    if (data.errors.telephone1) {
                        jQuery('#phone-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#phone-group').append('<div class="p15-input-notif"><small>' + data.errors.telephone1 + '</small></div>'); // add the actual error message under our input
                    }

                    // handle errors for group size ---------------
                    if (data.errors.p15_groupsize) {
                        jQuery('#groupsize-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#groupsize-group').append('<div class="p15-input-notif"><small>' + data.errors.p15_groupsize + '</small></div>'); // add the actual error message under our input
                    }

                    // handle errors for rideexp_motorcyclelicensetype ---------------
                    if (data.errors.rideexp_motorcyclelicensetype) {
                        jQuery('#licensetype-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#licensetype-group').append('<div class="p15-input-notif"><small>' + data.errors.rideexp_motorcyclelicensetype + '</small></div>'); // add the actual error message under our input
                    }

                    // handle errors for rideexp_licenseheldsince ---------------
                    if (data.errors.rideexp_licenseheldsince) {
                        jQuery('#licensesince-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#licensesince-group').append('<div class="p15-input-notif"><small>' + data.errors.rideexp_licenseheldsince + '</small></div>'); // add the actual error message under our input
                    }

                    // handle errors for rideexp_roadridinglevel ---------------
                    if (data.errors.rideexp_roadridinglevel) {
                        jQuery('#levelroad-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#levelroad-group').append('<div class="p15-input-notif"><small>' + data.errors.rideexp_roadridinglevel + '</small></div>'); // add the actual error message under our input
                    }

                    // handle errors for rideexp_offroadridinglevel ---------------
                    if (data.errors.rideexp_offroadridinglevel) {
                        jQuery('#leveloffroad-group').addClass('p15-error'); // add the error class to show red input
                        jQuery('#leveloffroad-group').append('<div class="p15-input-notif"><small>' + data.errors.rideexp_offroadridinglevel + '</small></div>'); // add the actual error message under our input
                    }                

                } else {
                    // ALL GOOD! just show the success message!
                    jQuery('#peak-15-form').html('<div class="p15-message p15-message-success">' + data.message + '</div>');
                }
            
            })

            // using the fail promise callback
            .fail(function(data) {
                // Server failed to respond - Show an error message
                jQuery('#peak-15-form').html('<div class="p15-message p15-message-error">Sorry, your form was not sent, please try again later.</div>');
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });

});  