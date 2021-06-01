jQuery(document).ready(function() {

    var bookingForm 		= jQuery("#bookingForm");
    var dataUrl 			= jQuery("#bookingForm").data("url");
	var tourSelect 			= jQuery("#tourSelect");
	var departureGroup 		= jQuery("#departureGroup");
	var depList				= jQuery("#departureList");
	var departureInfo 		= jQuery("#departureInfo");
	var departureNotices	= jQuery("#departureNotices");
	var depInfoPillion		= jQuery("#pillionFriendly");
	var tripPriceInfo		= jQuery("#tripPriceInfo");
	var mainGuestExtras		= jQuery("#mainGuestExtras");
	var guestFormContainer	= jQuery("#additionalGuests");
	var guestFormNotices	= jQuery("#guestFormNotices");
	var addGuest			= jQuery("#addGuest");
	var formNextBtn			= jQuery("#formNextSubmit");
	var currency			= { style: "currency", currency: "GBP" };

	var bookedItems 		= jQuery("#bookedItems");
	// var bookingItem;
	// var bookingQty;
	// var bookingAmt;

	var depPrices;
	var riderPrice;
	var riderPriceName;
	var riderPriceID;
	var spotsLeft;
	var addRider;
	var addPillion;

	var checkbox;

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
				guestFormContainer.html("");
				guestFormNotices.html("");
				addGuest.html("");
				departureInfo.css("display", "none");
				formNextBtn.css("display", "inline");
				bookedItems.html("");

				var selectedDepartId = depList.val();

				// Set the main departure GUID for the booking
				jQuery('input[name=departure_guid]').val(selectedDepartId);

				// Check the ID of the selected departure and iterate over the prices for the main guest.
				departures.forEach( item => {
					if ( item['@attributes'].id === selectedDepartId ) {
						spotsLeft = parseInt(item['@attributes'].availableSpaces);
						jQuery("#availableSpaces").text(spotsLeft);

						if (spotsLeft === 0) {

							departureInfo.css("display", "none");
							formNextBtn.css("display", "none");

							departureNotices.html('<div class="p15-message p15-message-error">Sorry, this date is sold out. Please select another date or send us an email to enquire about cancellations for this date.</div>');

							return;
						}

						depPrices = item['Prices']['Price'];

						var c = 1;

						depPrices.forEach( i => {

							if ( i['@attributes'].category === "Rider Base Price" ) {
								// riderPrice = new Number(i['@attributes'].amount).toLocaleString("en-GB", currency);
								riderPrice 		= i['@attributes'].amount;
								riderPriceName 	= i['@attributes'].name;
								riderPriceID 	= i['@attributes'].id;
								tripPriceInfo.append(
									'<p><b>Rider Price:</b> <span id="riderPrice">' + new Number(riderPrice).toLocaleString("en-GB", currency) + '</span></p>',
								);
								// Add the booked rider price to the hidden form input field for the main guest
								jQuery("#bookedRiderPrice").val(riderPriceID);
								jQuery(".rider-form").attr("data-price", riderPrice);
								jQuery(".rider-form").attr("data-price-name", riderPriceName);
								jQuery(".rider-form").attr("data-price-id", riderPriceID);

								// Add the rider price item to the price totals
								// bookedItems.append(
								// 	'<tr>' +
								// 		'<td id="bookingItem" style="width: 60%;"></td>' +
								// 		'<td id="bookingQty" style="width: 15%; text-align: center;"></td>' +
								// 		'<td id="bookingAmt" style="width: 25%; text-align: right;"></td>' +
								// 	'</tr>'
								// );
								// bookingItem = jQuery("#bookingItem");
								// bookingQty 	= jQuery("#bookingQty");
								// bookingAmt 	= jQuery("#bookingAmt");
								// bookingItem.text(i['@attributes'].name);
								// bookingQty.text(1);
								// bookingAmt.text( riderPrice * parseInt(bookingQty.text()) );
							}
							if ( i['@attributes'].category === "Pillion Base Price" ) {
								var pillionPrice = i['@attributes'].amount;
								tripPriceInfo.append(
									'<p><b>Pillion Price:</b> <span id="pillionPrice">' + new Number(pillionPrice).toLocaleString("en-GB", currency) + '</span></p>',
								);
							}

							if ( i['@attributes'].category != "Pillion Base Price" && i['@attributes'].category != "Rider Base Price" && i['@attributes'].name != "SRS - Pillion" ) {
								
								console.log(  i['@attributes'].category + ': ' + i['@attributes'].name + ' - ' + i['@attributes'].amount );
								// Build the extras fields for the main guest
								mainGuestExtras.append(
									'<div class="extras-box">' +
										'<input type="hidden" name="p15_guests.contact.1.p15_vendorserviceitemres.' + c +'" value="' + i['@attributes'].id + '">' +
										'<input class="booking-extra" type="checkbox" value="' + i['@attributes'].id + '" name="' + c +'" data-price="' + i['@attributes'].amount + '" data-price-name="' + i['@attributes'].name + '" data-price-id="' + i['@attributes'].id + '"> ' + i['@attributes'].name + ': ' + new Number(i['@attributes'].amount).toLocaleString("en-GB", currency) +
									'</div>'
								);
								c++
							}
						});
						updateTotals();
					}
				});

				depInfoPillion.text(pillionFriendly);

				// This function iterates over the prices for the selected departure and appends the extras to additional guests.
				function setExtrasFields(n, t) {

					n;
					t;

					switch(t) {

						case "pillion":
							// Code to run if case is "Pillion"
							console.log("This is a pillion!");

							departures.forEach( item => {
								if ( item['@attributes'].id === selectedDepartId ) {

									depPrices = item['Prices']['Price'];
		
									var c = 1;

									depPrices.forEach( i => {
		
										if ( i['@attributes'].category != "Pillion Base Price" && i['@attributes'].category != "Rider Base Price" && i['@attributes'].category != "Motorcycle Upgrade" && i['@attributes'].category != "Damage Excess Insurance" && i['@attributes'].name != "SRS - Rider" ) {
													
											console.log(  i['@attributes'].category + ': ' + i['@attributes'].name + ' - ' + i['@attributes'].amount );
											// Build the extras fields for the main guest
											jQuery('#guestExtras' + n + '').append(
												'<div class="extras-box">' +
													'<input type="hidden" name="p15_guests.contact.' + n + '.p15_vendorserviceitemres.' + c +'" value="' + i['@attributes'].id + '">' +
													'<input class="booking-extra" type="checkbox" name="p15_guests.contact.' + n + '.p15_tripprices.' + c +'" value="' + i['@attributes'].id + '" data-price="' + i['@attributes'].amount + '" data-price-name="' + i['@attributes'].name + '" data-price-id="' + i['@attributes'].id + '"> ' + i['@attributes'].name + ': ' + new Number(i['@attributes'].amount).toLocaleString("en-GB", currency) +
												'</div>'
											);
											c++
										}
										if (i['@attributes'].category === "Pillion Base Price") {
											jQuery('.rider-form').attr('data-price-id', '' + i['@attributes'].id + '');
											jQuery('.pillion-form').attr('data-price-name', '' + i['@attributes'].name + '');
											jQuery('.pillion-form').attr('data-price', '' + i['@attributes'].amount + '');
										}
									});
								}
							});
							
							break;

						case "rider":
							// Code to run of case is "Rider"
							console.log("This is a rider!");

							departures.forEach( item => {
								if ( item['@attributes'].id === selectedDepartId ) {
		
									depPrices = item['Prices']['Price'];
		
									var c = 1;
		
									depPrices.forEach( i => {
		
										if ( i['@attributes'].category != "Pillion Base Price" && i['@attributes'].category != "Rider Base Price" && i['@attributes'].name != "SRS - Pillion" ) {
													
											console.log(  i['@attributes'].category + ': ' + i['@attributes'].name + ' - ' + i['@attributes'].amount );
											// Build the extras fields for the main guest
											jQuery('#guestExtras' + n + '').append(
												'<div class="extras-box">' +
												'<input type="hidden" name="p15_guests.contact.' + n + '.p15_vendorserviceitemres.' + c +'" value="' + i['@attributes'].id + '">' +
												'<input class="booking-extra" type="checkbox" name="p15_guests.contact.' + n + '.p15_tripprices.' + c +'" value="' + i['@attributes'].id + '" data-price="' + i['@attributes'].amount + '" data-price-name="' + i['@attributes'].name + '" data-price-id="' + i['@attributes'].id + '"> ' + i['@attributes'].name + ': ' + new Number(i['@attributes'].amount).toLocaleString("en-GB", currency) +
											'</div>'
											);
											c++
										}

										if (i['@attributes'].category === "Rider Base Price") {
											jQuery('.rider-form').attr('data-price-id', '' + i['@attributes'].id + '');
											jQuery('.rider-form').attr('data-price-name', '' + i['@attributes'].name + '');
											jQuery('.rider-form').attr('data-price', '' + i['@attributes'].amount + '');
										}
									});
								}
							});

							break;

					}

				}

				function updateTotals() {
					
					// OLD START //
					var rider			= jQuery(".rider-form");
					var pillion			= jQuery(".pillion-form");
					var bookingExtra	= jQuery(".booking-extra");

					var bookedItems 	= jQuery("#bookedItems");
					var bookingTotal 	= jQuery("#bookingTotal");
					var currentTotal	= 0;

					bookedItems.html("");

					// rider.each(function() {
						// console.log(jQuery(this).attr("data-price-id"));
						var rcount 	= rider.length;
						var rname 	= rider.attr("data-price-name");
						var rprice 	= parseInt(rider.attr("data-price"));
						var rtotal	= rprice * rcount;
						console.log(rcount + ' Riders')
						bookedItems.append(
							`<tr>	
								<td class="bookingItem" style="width: 60%;">${rname}</td>
								<td class="bookingQty" style="width: 15%; text-align: center;">${rcount}</td>
								<td class="bookingAmt" style="width: 25%; text-align: right;">${new Number(rtotal).toLocaleString("en-GB", currency)}</td>
							</tr>`
						);

					// });

					// pillion.each(function() {
						// console.log(jQuery(this).attr("data-price-id"));
						var pcount 	= pillion.length;
						var pname 	= pillion.attr("data-price-name");
						var pprice 	= parseInt(pillion.attr("data-price"));
						var ptotal	= pprice * pcount;
						console.log(pcount + ' Pillions')
						bookedItems.append(
							`<tr>	
								<td class="bookingItem" style="width: 60%;">${pname}</td>
								<td class="bookingQty" style="width: 15%; text-align: center;">${pcount}</td>
								<td class="bookingAmt" style="width: 25%; text-align: right;">${new Number(ptotal).toLocaleString("en-GB", currency)}</td>
							</tr>`
						);
					// });

					bookingExtra.each(function() {
						// console.log(jQuery(this).attr("data-price-id"));
						var qty = bookingExtra.length;
						console.log(qty + ' Extras')
					});

					checkbox = jQuery('input[type="checkbox"]');
					checkbox.click(function() {
						var checked	= jQuery('input[type="checkbox"]:checked');
						var price 	= parseInt(jQuery(this).attr("data-price"));
						var name 	= jQuery(this).attr("data-price-name");

						console.log(checked.val());

						// if ( jQuery(this).prop("checked") == true ) {
						// 	console.log(jQuery(this).attr("data-price-id"));
							
						// } else {
						// 	console.log("Unchecked")
						// }

						// console.log(checked);

						// bookedItems.append(
						// 	`<tr>	
						// 		<td class="bookingItem" style="width: 60%;">${name}</td>
						// 		<td class="bookingQty" style="width: 15%; text-align: center;">1</td>
						// 		<td class="bookingAmt" style="width: 25%; text-align: right;">${new Number(price).toLocaleString("en-GB", currency)}</td>
						// 	</tr>`
					});


					function addItem(item) {
						if (item.length > 0) {
							var count 	= item.length;
							var price 	= parseInt(item.attr("data-price"));
							var name 	= item.attr("data-price-name");
							var total	= price * count;

							bookedItems.append(
								`<tr>	
									<td class="bookingItem" style="width: 60%;">${name}</td>
									<td class="bookingQty" style="width: 15%; text-align: center;">${count}</td>
									<td class="bookingAmt" style="width: 25%; text-align: right;">${new Number(total).toLocaleString("en-GB", currency)}</td>
								</tr>`
							);
							currentTotal = (currentTotal + total);
							bookingTotal.text(new Number(currentTotal).toLocaleString("en-GB", currency));
						}
					}

					addItem(rider);
					addItem(pillion);

					checkbox = jQuery('input[type="checkbox"]');

					checkbox.click(function() {
						var price 	= parseInt(jQuery(this).attr("data-price"));
						var name 	= jQuery(this).attr("data-price-name");

						if ( jQuery(this).prop("checked") == true ) {
							console.log(jQuery(this).attr("data-price-id"));
							
						} else {
							console.log("Unchecked")
						}

						// console.log(checked);

						// bookedItems.append(
						// 	`<tr>	
						// 		<td class="bookingItem" style="width: 60%;">${name}</td>
						// 		<td class="bookingQty" style="width: 15%; text-align: center;">1</td>
						// 		<td class="bookingAmt" style="width: 25%; text-align: right;">${new Number(price).toLocaleString("en-GB", currency)}</td>
						// 	</tr>`
						// );

					});
					// OLD END //

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
							guestFormContainer.append(
								'<div id="guest' + n + '" class="guest-form rider-form" data-price="" data-price-name="">' + 
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
											// setExtrasFields
										'</div>' +
									'</div>' +
								'</div>'
							);
							setExtrasFields(n, "rider");
							updateTotals();
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
							guestFormContainer.append(
								'<div id="guest' + n + '" class="guest-form pillion-form" data-price="" data-price-name="">' + 
									'<h4>Guest ' + n + ' (Pillion)</h4>' +
									'<input type="hidden" name="p15_guests.contact.' + n + '.isClient" value="true">' +
									'<input type="hidden" id="bookedPillionPrice' + n + '" class="cost-item-pillion" name="p15_guests.contact.' + n + '.p15_tripprices.1" value="">' +
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
										// setExtrasFields
									'</div>' +

								'</div>'
							);
							setExtrasFields(n, "pillion");
							updateTotals();
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
							guestFormContainer.append(
								'<div id="guest' + n + '" class="guest-form rider-form" data-price="" data-price-name="">' + 
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
											// setExtrasFields
										'</div>' +
									'</div>' +
								'</div>'
							);
							setExtrasFields(n, "rider");
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

				// Add a function here to add all guest items and prices to the totals section.
				// var bookedItems = jQuery("#bookedItems");

				// var item		= "Riders";
				// var amount 		= 7295.00;
				// var quantity	= 3;

				// bookedItems.append(
				// 	'<tr>' +
				// 		'<td style="width: 60%;">' + item + '</td>' +
				// 		'<td style="width: 15%; text-align: center;">' + quantity + '</td>' +
				// 		'<td style="width: 25%; text-align: right;">' + new Number(amount * quantity).toLocaleString("en-GB", currency) + '</td>' +
				// 	'</tr>'
				// );

			});

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