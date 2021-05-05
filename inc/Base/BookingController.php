<?php 
/**
 * @package Peak15Link
 */

 namespace Inc\Base;

 use \Inc\Base\BaseController;
 use Inc\Api\Callbacks\AdminCallbacks;

 class BookingController extends BaseController
 {
    public function register()
    {

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue') );

        add_action( 'wp_ajax_update_form', array( $this, 'update_form' ) );
        add_action( 'wp_ajax_nopriv_update_form', array( $this, 'update_form' ) );

        add_action( 'wp_ajax_submit_booking_form', array( $this, 'submit_booking_form' ) );
        add_action( 'wp_ajax_nopriv_submit_booking_form', array( $this, 'submit_booking_form' ) );

        add_shortcode( 'form-booking', array( $this, 'form_booking' ) );

    }

    public function update_form($x)
    {

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

        $x = "";
        // $tripGuid = "336D89E1-7843-EB11-80DE-00155D02B546";
        $tripGuid       = $x;
        $tripDuration   = 15;
        $trips          = $p15_tour_data['Trip'];

        $data           = array();
        $errors         = array();

        // foreach ($trips as $trip) {
        //     if ( isset($trip['Departures']['Departure'][0]) ) {
        //         $departures = $trip['Departures']['Departure'];
        //     // If the trip has ONLY ONE departure date...
        //     } elseif ( isset($trip['Departures']) ) {
        //         $departures = $trip['Departures'];
        //     // If the trip has NO departure dates we se the variable to an empty array. We do not want to display trips with no departures...
        //     } else {
        //         $departures = [];
        //     }
        //     if ( $trip['@attributes']['id'] === $tripGuid ) {
        //         if (is_array($departures))  {
        //             foreach ( $departures as $departure ) {
        //                 $data['departureDates'] = $departure;
        //             }
        //         }
        //     }
        // }
    }

    public function submit_booking_form()
    {

        function email_results( $api_response ) {
            $admin_email = get_option('admin_email');
            $to      = get_option('notify_email');
            $subject = 'API Notice: Failed form submission on ' . get_option('blogname');
            $message = '<html>
                            <body>
                                <table>
                                    <tr>
                                        <td><b>First Name: </b>' . $_POST['firstname'] . '<td/>
                                    </tr>
                                    <tr>
                                        <td><b>Last Name: </b>' . $_POST['lastname'] . '<td/>
                                    </tr>
                                    <tr>
                                        <td><b>Email Address: </b>' . $_POST['email'] . '<td/>
                                    </tr>
                                    <tr>
                                        <td><b>Number: </b>' . $_POST['telephone1'] . '<td/>
                                    </tr>
                                    <tr>
                                        <td><b>Message: </b>' . $_POST['p15_comment'] . '<td/>
                                    </tr>
                                    <tr>
                                        <td><b>Form Name: </b>' . $_POST['formname'] . '<td/>
                                    </tr>
                                    <tr>
                                        <td><b>Webpage: </b>' . $_POST['pagename'] . '<td/>
                                    </tr>
                                    <tr>
                                        <td><b>API Response: </b>' . $api_response . '<td/>
                                    </tr>
                                </table>
                            </body>
                        </html>';
            $headers = array(
                'From' => get_option('blogname') . ' - Admin' . '<' . $admin_email . '>',
                'Reply-To' => $admin_email,
                'MIME-Version' => '1.0',
                'Content-type' => 'text/html; charset=iso-8859-1',
                'X-Mailer' => 'PHP/' . phpversion()
            );

            mail($to, $subject, $message, $headers);

        }

        // Include security and spam filters!!!

        // Sanitize the data 

        // Store / process the data

        // send response

        
        // Place form processing script here.


        // My form processing script. Needs to be updated for WordPress:

        $errors         = array();      // array to hold validation errors
        $data           = array();      // array to pass back data

        // validate the variables ======================================================
        // if any of these variables don't exist, add an error to our $errors array

        // Form validation for the booking form
        if ( $_POST['formname'] == "Booking Form" ) {

            if (empty($_POST['firstname'])) {
                $errors['firstname'] = 'First name is required.';
            }
    
            if (empty($_POST['lastname'])) {
                $errors['lastname'] = 'Last name is required.';
            }
    
            if (empty($_POST['email'])) {
                $errors['email'] = 'Email address is required.';
            }

            if (empty($_POST['telephone1'])) {
                $errors['telephone1'] = 'Phone number is required.';
            }

            if (empty($_POST['rideexp_motorcyclelicensetype'])) {
                $errors['rideexp_motorcyclelicensetype'] = 'License type is required.';
            }

            if (empty($_POST['rideexp_licenseheldsince'])) {
                $errors['rideexp_licenseheldsince'] = 'License held since is required.';
            }

            if (empty($_POST['rideexp_roadridinglevel'])) {
                $errors['rideexp_roadridinglevel'] = 'Riding level is required.';
            }

            if (empty($_POST['rideexp_offroadridinglevel'])) {
                $errors['rideexp_offroadridinglevel'] = 'Riding level is required.';
            }

        }


        // return a response ===========================================================

        // if there are any errors in our errors array, return a success boolean of false
        if ( ! empty($errors) ) {

            // if there are items in our errors array, return those errors
            $data['success'] = false;
            $data['errors']  = $errors;

        } else {

            // if there are no errors process our form, then return a message
            
            $token = $this->api_token;
            $url = 'https://data.peak15systems.com/beacon/service.svc/insert/complex/contactinquiry';

            // Set the post data for the pre-booking form
            if ( $_POST['formname'] == "Pre-Booking Form" ) {

                $postData = array(
                    'token'                                         => $token,
                    // Hidden Values
                    'p15_inquiries.p15_name'                        => $_POST['pagename'],
                    'p15_inquiries.statuscode'                      => $_POST['statuscode'],
                    'contact.rule'                                  => $_POST['rule'],
                    'contact.p15_contacttype_contactid'             => $_POST['contacttype'],
                    // Contact entity fields
                    'contact.firstname'                             => $_POST['firstname'],
                    'contact.lastname'                              => $_POST['lastname'],
                    'contact.emailaddress1'                         => $_POST['email'],
                    'contact.telephone1'        		            => $_POST['telephone1'],
                    'contact.rideexp_motorcyclelicensetype'         => $_POST['rideexp_motorcyclelicensetype'],
                    'contact.rideexp_licenseheldsince'              => $_POST['rideexp_licenseheldsince'],
                    'contact.rideexp_roadridinglevel'               => $_POST['rideexp_roadridinglevel'],
                    'contact.rideexp_offroadridinglevel'            => $_POST['rideexp_offroadridinglevel'],
                    'contact.rideexp_motorcyclesowned'              => $_POST['rideexp_motorcyclesowned'],
                    'contact.rideexp_terrain_mountainroads'         => $_POST['rideexp_terrain_mountainroads'],
                    'contact.rideexp_terrain_graveldirtroads'       => $_POST['rideexp_terrain_graveldirtroads'],
                    'contact.rideexp_terrain_sandytracks'           => $_POST['rideexp_terrain_sandytracks'],
                    'contact.rideexp_terrain_sanddunes'             => $_POST['rideexp_terrain_sanddunes'],
                    'contact.rideexp_terrain_mud'                   => $_POST['rideexp_terrain_mud'],
                    'contact.rideexp_terrain_motorcrosstracks'      => $_POST['rideexp_terrain_motorcrosstracks'],
                    'contact.rideexp_terrain_bulldust'              => $_POST['rideexp_terrain_bulldust'],
                    'contact.rideexp_terrain_snow'                  => $_POST['rideexp_terrain_snow'],
                    'contact.rideexp_terrain_strongwinds'           => $_POST['rideexp_terrain_strongwinds'],
                    'contact.rideexp_terrain_noneoftheabove'        => $_POST['rideexp_terrain_noneoftheabove'],
                    'contact.rideexp_terrain_other'                 => $_POST['rideexp_terrain_other'],
                    'contact.rideexp_fitness'                       => $_POST['rideexp_fitness']
                );
            }

            $options = array(
                'http'=>array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($postData)
                )
            );

            $context  = stream_context_create($options);
            
            $response = file_get_contents($url, false, $context);

            // Using a built-in Wordpress function, we check if the response is a valid GUID. Returns true or false.
            $validateGUID = wp_is_uuid($response);

            // The API is incorrectly set up to send a 200 OK header with all requests, including error messages,
            // to combat this, we can validate the GUID response from the server on successful transmission.
            if ( $validateGUID === false ) {
                $data['success']    = false;
                $data['errors']['validation'] = 'Form Submission Failed.';
                $data['message']    = $response;
                
                // Send a failure notification email
                email_results($response);

            } else {
                // show a message of success and provide a true success variable
                $data['GUID']       = $validateGUID;
                $data['result']     = $response;
                $data['success']    = true;
                $data['message']    = 'Your form was submitted!';
            }
            
        }

        // return all our data to an AJAX call
        echo json_encode($data);

        wp_die();

    }

    // Enqueue our scripts and css files related to the Ajax Forms feature of the plugin.
    public function enqueue()
    {

        $plugin_data = get_plugin_data( $this->plugin_path . '/peak15-link.php' );
        $version = $plugin_data['Version'];

        // Enqueue our CSS files
        wp_enqueue_style( 'peak15link-booking-css', $this->plugin_url . 'dist/css/peak15link-booking.min.css', array(), $version );


        // Enqueue our script files
        wp_enqueue_script( 'ajax-booking-script', $this->plugin_url . 'dist/js/peak15link-ajax-bookings.min.js', array( 'ajax-form-script' ), $version, true );

        //wp_localize_script( 'ajax-form-script', 'my_ajax_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => $title_nonce, ) );

    }

    // This is where we create our form shortcodes and link to the template for the form in the '.../templates/' folder.
    public function form_booking()
    {
        ob_start();

        require_once( "$this->plugin_path/templates/form_booking.php" );

        return ob_get_clean();
    }

 }