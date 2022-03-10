<?php 
/**
 * @package Peak15Link
 */

 namespace Inc\Pages;

 use \Inc\Api\SettingsApi;
 use \Inc\Base\BaseController;
 use \Inc\Api\Callbacks\AdminCallbacks;

 class Admin extends BaseController
 {
	public $settings;

	public $callbacks;
	
	public $pages = array();

	public $subpages = array();

    public function register() 
    {

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setPages();

		$this->setSubPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

     	$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}
	
	public function setPages()
	{
		$this->pages = array(
			array(
				'page_title' => 'Peak15 Link Plugin (Beta)',
				'menu_title' => 'Peak15 Link (Beta)',
				'capability' => 'manage_options',
				'menu_slug' => 'peak15_link',
				'callback' => array( $this->callbacks, 'adminDashboard' ),
				'icon_url' => 'dashicons-admin-links', 
				'position' => 25
			)
		);
	}

	public function setSubPages()
	{
		$this->subpages = array(
            // array(
            //     'parent_slug' => 'peak15_link',
            //     'page_title' => 'Itinerary Feed',
			// 	'menu_title' => 'Itinerary Feed',
			// 	'capability' => 'manage_options',
			// 	'menu_slug' => 'peak15_link_itinerary_feed',
			// 	'callback' => array( $this->callbacks, 'adminItineraryFeed' )
			// ),
			array(
                'parent_slug' => 'peak15_link',
                'page_title' => 'Website Forms',
				'menu_title' => 'Website Forms',
				'capability' => 'manage_options',
				'menu_slug' => 'peak15_link_webforms',
				'callback' => array( $this->callbacks, 'adminWebForms' )
            )
         );
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'peak15link_api_settings',
				'option_name' => 'api_token',
				'callback' => array( $this->callbacks, 'peak15linkSettingsGroup' )
			),
			array(
				'option_group' => 'peak15link_api_settings',
				'option_name' => 'process_token',
				'callback' => array( $this->callbacks, 'peak15linkSettingsGroup' )
			),
			array(
				'option_group' => 'peak15link_api_settings',
				'option_name' => 'orgname'
			),
			array(
				'option_group' => 'peak15link_api_settings',
				'option_name' => 'notify_email'
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'peak15link_admin_index',
				'title' => 'API Settings',
				'callback' => array( $this->callbacks, 'peak15linkAdminSection' ),
				'page' => 'peak15_link'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'orgname',
				'title' => 'Organization Name',
				'callback' => array( $this->callbacks, 'peak15linkOrgName' ),
				'page' => 'peak15_link',
				'section' => 'peak15link_admin_index',
				'args' => array(
					'label_for' => 'orgname',
					'class' => 'example-class'
				)			
				),
			array(
				'id' => 'api_token',
				'title' => 'API Token',
				'callback' => array( $this->callbacks, 'peak15linkApiToken' ),
				'page' => 'peak15_link',
				'section' => 'peak15link_admin_index',
				'args' => array(
					'label_for' => 'api_token',
					'class' => 'example-class'
				)			
			),
			array(
				'id' => 'process_token',
				'title' => 'Process Execute Token',
				'callback' => array( $this->callbacks, 'peak15linkProcessToken' ),
				'page' => 'peak15_link',
				'section' => 'peak15link_admin_index',
				'args' => array(
					'label_for' => 'process_token',
					'class' => 'example-class'
				)
				),
			array(
				'id' => 'notify_email',
				'title' => 'Email for API Notices',
				'callback' => array( $this->callbacks, 'peak15linkNotifyEmail' ),
				'page' => 'peak15_link',
				'section' => 'peak15link_admin_index',
				'args' => array(
					'label_for' => 'notify_email',
					'class' => 'example-class'
				)
			)
		);

		$this->settings->setFields( $args );
	}
 }