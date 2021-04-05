jQuery(document).ready(function() {

    // Add the jQuery Datepicker to the form
    jQuery("#datepicker").datepicker();


    // Get the URL from the form to POST the data to.
     var dataUrl = jQuery('#peak-15-form').data("url");

	// Grab the page info and set hidden fields
	jQuery('input[name=pagename]').val(document.title);

    // process the form
    jQuery('form').submit(function(event) {

		jQuery('#formSubmit').attr("disabled","disabled");

        jQuery('.form-group').removeClass('p15-error'); // remove the error class
        jQuery('.p15-input-notif').remove(); // remove the error text

        // get the form data
        var formData = {
			// Hidden Values
            'pagename'    				: jQuery('input[name=pagename]').val(),
            'statuscode'    		    : jQuery('input[name=statuscode]').val(),
            'catalogrequest' 			: jQuery('input[name=catalogrequest]').val(),
			'ruletype' 					: jQuery('input[name=ruletype]').val(),
            'bulkemail'      			: jQuery('input[name=bulkemail]').val(),
			'donotsendmm' 				: jQuery('input[name=donotsendmm]').val(),
			'p15_listid'				: jQuery('input[name=p15_listid]').val(),
			'contacttype'    			: jQuery('input[name=contacttype]').val(),
			'action'       			    : jQuery('input[name=action]').val(),
			// User Inputs
            'firstname'    				: jQuery('input[name=firstname]').val(),
            'lastname'     				: jQuery('input[name=lastname]').val(),
            'email'        				: jQuery('input[name=email]').val()
        };

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

					jQuery('#formSubmit').removeAttr("disabled","disabled");

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
        
                } else {
                    // ALL GOOD! just show the success message!
                    jQuery('#peak-15-form').html('<div class="p15-message p15-message-success">' + data.message + '</div>');
                }
            
            })

            // using the fail promise callback
            .fail(function(data) {
                // Server failed to respond - Show an error message
                jQuery('#peak-15-form').html('<div class="p15-message p15-message-error">Could not reach server, please try again later.</div>');
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });

});  