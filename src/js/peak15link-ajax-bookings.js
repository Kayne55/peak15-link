jQuery(document).ready(function() {

    jQuery("#tourSelect").change(function(){

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

        jQuery.ajax({
            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
            url         : dataUrl, // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true
        })

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