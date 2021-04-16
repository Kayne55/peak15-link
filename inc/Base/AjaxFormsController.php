<?php 
/**
 * @package Peak15Link
 */

 namespace Inc\Base;

 use \Inc\Base\BaseController;
 use Inc\Api\Callbacks\AdminCallbacks;

 class AjaxFormsController extends BaseController
 {
    public function register()
    {
        //add_action( 'init', array( $this, 'activate' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue') );

        add_action( 'wp_ajax_submit_form', array( $this, 'submit_form' ) );
        
        add_action( 'wp_ajax_nopriv_submit_form', array( $this, 'submit_form' ) );

        // Register our form shortcodes
        add_shortcode( 'signup-form-general', array( $this, 'signup_form_general' ) );
        add_shortcode( 'form-win-free-tour-2021', array( $this, 'form_win_free_tour_2021' ) );
        add_shortcode( 'form-inquiry-tour', array( $this, 'form_inquiry_tour' ) );
        add_shortcode( 'form-inquiry-general', array( $this, 'form_inquiry_general' ) );
        add_shortcode( 'form-prebooking', array( $this, 'form_prebooking' ) );

    
    }

    public function submit_form()

    {

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

        // Form validation for the sign-up form
        if ( $_POST['formname'] == "Sign-Up Form" ) {

            if (empty($_POST['firstname'])) {
                $errors['firstname'] = 'First name is required.';
            }
    
            if (empty($_POST['lastname'])) {
                $errors['lastname'] = 'Last name is required.';
            }
    
            if (empty($_POST['email'])) {
                $errors['email'] = 'Email address is required.';
            }

        }

        // Form validation for the Win a FREE Tour 2021 form
        if ( $_POST['formname'] == "Win a FREE Tour 2021" ) {

            if (empty($_POST['firstname'])) {
                $errors['firstname'] = 'First name is required.';
            }
    
            if (empty($_POST['lastname'])) {
                $errors['lastname'] = 'Last name is required.';
            }
    
            if (empty($_POST['email'])) {
                $errors['email'] = 'Email address is required.';
            }

        }

        // Form validation for the tour inquiry form
        if ( $_POST['formname'] == "Tour Inquiry Form" ) {

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

            if (empty($_POST['p15_groupsize'])) {
                $errors['p15_groupsize'] = 'Group size is required.';
            }

        }

        // Form validation for the general inquiry form
        if ( $_POST['formname'] == "General Inquiry Form" ) {

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

        }

        // Form validation for the pre-booking form
        if ( $_POST['formname'] == "Pre-Booking Form" ) {

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

            if (empty($_POST['rideexp_motorcyclesowned'])) {
                $errors['rideexp_motorcyclesowned'] = 'Motorcycles owned is required.';
            }

            if (empty($_POST['rideexp_fitness'])) {
                $errors['rideexp_fitness'] = 'Fitness level is required.';
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
            // $url = 'https://data.peak15systems.com/beacon/service.svc/insert/entity/contact';

            // // Set the post data for the sign-up form
            if ( $_POST['formname'] == "Sign-Up Form" ) {
    
                $postData = array(
                    'token'                                         => $token,
                    // Hidden Values
                    'p15_inquiries.p15_name'                        => $_POST['pagename'],
                    'p15_inquiries.statuscode'                      => $_POST['statuscode'],
                    'contact.rule'                                  => $_POST['rule'],
                    // 'contact.ruletype'                              => $_POST['ruletype'],
                    'contact.donotbulkemail'                        => $_POST['bulkemail'],
                    'contact.donotsendmm'                           => $_POST['donotsendmm'],
                    'p15_inquiries.p15_listid'                      => $_POST['p15_listid'],
                    'contact.p15_contacttype_contactid'             => $_POST['contacttype'],
                    'contact.p15_catalogrequested'                  => $_POST['catalogrequest'],
                    'p15_inquiries.p15_channel'                     => $_POST['p15_channel'],
                    'p15_inquiries.p15_unresolved_campaign'         => $_POST['p15_unresolved_campaign'],
                    'p15_inquiries.p15_gamedium'                    => $_POST['p15_gamedium'],
                    'p15_inquiries.p15_searchkeywords'              => $_POST['p15_searchkeywords'],
                    'p15_inquiries.p15_gacontent'                   => $_POST['p15_gacontent'],
                    'p15_inquiries.p15_gacampaign'                  => $_POST['p15_gacampaign'],

                    // Contact entity fields
                    'contact.firstname'                             => $_POST['firstname'],
                    'contact.lastname'                              => $_POST['lastname'],
                    'contact.emailaddress1'                         => $_POST['email']
                );
            }

            // Set the post data  for the Win a FREE Tour 2021 form
            if ( $_POST['formname'] == "Win a FREE Tour 2021" ) {
    
                $postData = array(
                    'token'                                         => $token,
                    // Hidden Values
                    'p15_inquiries.p15_name'                        => $_POST['pagename'],
                    'p15_inquiries.statuscode'                      => $_POST['statuscode'],
                    'contact.rule'                                  => $_POST['rule'],
                    // 'contact.ruletype'                              => $_POST['ruletype'],
                    'contact.donotbulkemail'                        => $_POST['bulkemail'],
                    'contact.donotsendmm'                           => $_POST['donotsendmm'],
                    'p15_inquiries.p15_listid'                      => $_POST['p15_listid'],
                    'contact.p15_contacttype_contactid'             => $_POST['contacttype'],
                    'contact.p15_catalogrequested'                  => $_POST['catalogrequest'],
                    'p15_inquiries.p15_channel'                     => $_POST['p15_channel'],
                    'p15_inquiries.p15_unresolved_campaign'         => $_POST['p15_unresolved_campaign'],
                    'p15_inquiries.p15_gamedium'                    => $_POST['p15_gamedium'],
                    'p15_inquiries.p15_searchkeywords'              => $_POST['p15_searchkeywords'],
                    'p15_inquiries.p15_gacontent'                   => $_POST['p15_gacontent'],
                    'p15_inquiries.p15_gacampaign'                  => $_POST['p15_gacampaign'],

                    // Contact entity fields
                    'contact.firstname'                             => $_POST['firstname'],
                    'contact.lastname'                              => $_POST['lastname'],
                    'contact.emailaddress1'                         => $_POST['email']
                );
            }

            // Set the post data  for the tour inquiry form
            if ( $_POST['formname'] == "Tour Inquiry Form" ) {
    
                $postData = array(
                    'token'                                         => $token,
                    // Hidden Values
                    'p15_inquiries.p15_name'                        => $_POST['pagename'],
                    'p15_inquiries.statuscode'                      => $_POST['statuscode'],
                    'contact.rule'                                  => $_POST['rule'],
                    // 'contact.ruletype'                              => $_POST['ruletype'],
                    'p15_trips.1'                                   => $_POST['p15_trips'],
                    'p15_destinations.1'                            => $_POST['destination'],
                    'p15_tripactivities.1'                          => $_POST['tripactivity'],
                    'contact.p15_contacttype_contactid'             => $_POST['contacttype'],
                    'p15_inquiries.p15_channel'                     => $_POST['p15_channel'],
                    'p15_inquiries.p15_unresolved_campaign'         => $_POST['p15_unresolved_campaign'],
                    'p15_inquiries.p15_gamedium'                    => $_POST['p15_gamedium'],
                    'p15_inquiries.p15_searchkeywords'              => $_POST['p15_searchkeywords'],
                    'p15_inquiries.p15_gacontent'                   => $_POST['p15_gacontent'],
                    'p15_inquiries.p15_gacampaign'                  => $_POST['p15_gacampaign'],
                    // Contact entity fields
                    'contact.firstname'                             => $_POST['firstname'],
                    'contact.lastname'                              => $_POST['lastname'],
                    'contact.emailaddress1'                         => $_POST['email'],
                    'contact.telephone1'        		            => $_POST['telephone1'],
                    'p15_inquiries.p15_groupsize'                   => $_POST['p15_groupsize'],
                    'p15_inquiries.p15_comment'                     => $_POST['p15_comment'],
                    'contact.donotbulkemail'                        => $_POST['bulkemail']
                );
            }

            // Set the post data  for the general inquiry form
            if ( $_POST['formname'] == "General Inquiry Form" ) {
    
                $postData = array(
                    'token'                                         => $token,
                    // Hidden Values
                    'p15_inquiries.p15_name'                        => $_POST['pagename'],
                    'contact.rule'                                  => $_POST['rule'],
                    // 'contact.ruletype'                              => $_POST['ruletype'],
                    'contact.p15_contacttype_contactid'             => $_POST['contacttype'],
                    'p15_inquiries.p15_channel'                     => $_POST['p15_channel'],
                    'p15_inquiries.p15_unresolved_campaign'         => $_POST['p15_unresolved_campaign'],
                    'p15_inquiries.p15_gamedium'                    => $_POST['p15_gamedium'],
                    'p15_inquiries.p15_searchkeywords'              => $_POST['p15_searchkeywords'],
                    'p15_inquiries.p15_gacontent'                   => $_POST['p15_gacontent'],
                    'p15_inquiries.p15_gacampaign'                  => $_POST['p15_gacampaign'],
                    // Contact entity fields
                    'contact.firstname'                             => $_POST['firstname'],
                    'contact.lastname'                              => $_POST['lastname'],
                    'contact.emailaddress1'                         => $_POST['email'],
                    'contact.telephone1'        		            => $_POST['telephone1'],
                    'p15_inquiries.p15_comment'                     => $_POST['p15_comment'],
                    'contact.donotbulkemail'                        => $_POST['bulkemail']
                );
            }

            // Set the post data for the pre-booking form
            if ( $_POST['formname'] == "Pre-Booking Form" ) {

                $postData = array(
                    'token'                                         => $token,
                    // Hidden Values
                    'p15_inquiries.p15_name'                        => $_POST['pagename'],
                    'p15_inquiries.statuscode'                      => $_POST['statuscode'],
                    'contact.rule'                                  => $_POST['rule'],
                    //'contact.ruletype'                              => $_POST['ruletype'],
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
        wp_enqueue_style( 'peak15link-forms-css', $this->plugin_url . 'dist/css/peak15link-forms.min.css', array(), $version );

        // Enqueue our script files
        wp_enqueue_script( 'ajax-form-script', $this->plugin_url . 'dist/js/peak15link-ajaxforms.min.js', array( 'jquery' ), $version, true );

        // Load jQuery UI Script
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );  


        //wp_localize_script( 'ajax-form-script', 'my_ajax_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => $title_nonce, ) );

    }

    // This is where we create our form shortcodes and link to the template for the form in the '.../templates/' folder.
    public function signup_form_general()
    {
        ob_start();

        require_once( "$this->plugin_path/templates/signup-form-general.php" );

        return ob_get_clean();
    }

    public function form_win_free_tour_2021()
    {
        ob_start();

        require_once( "$this->plugin_path/templates/form-signup-win-2021.php" );

        return ob_get_clean();
    }

    public function form_inquiry_tour()
    {
        ob_start();

        require_once( "$this->plugin_path/templates/form-inquiry-tour.php" );

        return ob_get_clean();
    }

    public function form_inquiry_general()
    {
        ob_start();

        require_once( "$this->plugin_path/templates/form-inquiry-general.php" );

        return ob_get_clean();
    }

    public function form_prebooking()
    {
        ob_start();

        require_once( "$this->plugin_path/templates/form-prebooking.php" );

        return ob_get_clean();
    }

 }