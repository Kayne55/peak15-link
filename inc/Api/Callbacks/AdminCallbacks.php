<?php
/**
 * @package Peak15Link
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
    public function adminDashboard()
    {
        return require_once( "$this->plugin_path/templates/admin-dashboard.php" );
    }

    public function adminItineraryFeed()
    {
        return require_once( "$this->plugin_path/templates/admin-itinerary.php" );
    }

    public function adminWebForms()
    {
        return require_once( "$this->plugin_path/templates/admin-web-forms.php" );
    }

    public function peak15OptionsGroup( $input )
    {
        return $input;
    }

    public function peak15linkAdminSection()
    {
        // add callback function here
    }

    public function peak15linkOrgName()
    {
        $value = esc_attr( $this->orgname );
        echo '<input type="text" class="regular-text" name="orgname" value="' . $value . '" placeholder="Insert your Organization Name here...">'; 
    }

    public function peak15linkApiToken()
    {
        $value = esc_attr( $this->api_token );
        echo '<input type="text" class="regular-text" name="api_token" value="' . $value . '" placeholder="Insert your API Token here...">'; 
    }

    public function peak15linkProcessToken()
    {
        $value = esc_attr( $this->process_token );
        echo '<input type="text" class="regular-text" name="process_token" value="' . $value . '" placeholder="Insert your Process Execute Token here...">'; 
    }

    public function peak15linkNotifyEmail()
    {
        $value = esc_attr( $this->notify_email );
        echo '<input type="email" class="regular-text" name="notify_email" value="' . $value . '" placeholder="Insert an Email to receive API Notifications...">'; 
    }
}