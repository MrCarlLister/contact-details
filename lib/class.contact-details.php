<?php

// -- Contact Details! -- //

final class BirdBrain_Contact_Details {

	public function __construct () {
	
		// Build up hooks
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		
		// Register primary shortcode
		add_shortcode( 'contact', array( __CLASS__, '_shortcode' ) );
		
	}
	
	public static function _shortcode ( $attributes ) {
	
		if( !isset( $attributes['type'] ) )
			return;
			
		if( $data = get_option( 'contact_details' ) )
			return $data[$attributes['type']];
	
	}
	
	public static function admin_init () {
	
		// Output styles
		wp_enqueue_style( 'style.css', plugins_url( 'assets/css', dirname( __FILE__ ) ) . '/style.css', false, false, 'all' );
	
	}
	
	public static function admin_menu () {
	
		// Add menu page which allows the user to specify which post types to work with
		add_options_page( 'Contact Details', 'Contact Details', 'manage_options', 'birdbrain-contact-details', array( __CLASS__, '_options_page' )  );
	
	}
	
	public static function _options_page () {
	
		// Check if posting, if so, save data
		if( !empty( $_POST ) )
			update_option( 'contact_details', array_map( 'sanitize_text_field', $_POST['contact_details'] ) );
			
		$details = get_option( 'contact_details' );
		
		// Array for storing form structure
		$data = array(
		
			'Basic Details' => array(
			
				'primary_contact_name' => 'Primary Contact Name',
				'business_name' => 'Business Name',
				'copyright_text' => 'Copyright Text'
			
			),
			
			'Address 1' => array(
				
				'location_name' => 'Location Name',
				'phone_number' => 'Phone Number',
				'fax' => 'Fax',
				'mobile' => 'Mobile',
				'email_address' => 'Email Address',
				'street_number_name' => 'Street Number &amp; Name',
				'suburb' => 'Suburb',
				'postcode' => 'Postcode',
				'state' => 'State',
				'country' => 'Country',
				'business_hours' => 'Business Hours'
			
			),
			'Address 2' => array(
			
				'location_name_2' => 'Location Name',
				'phone_number_2' => 'Phone Number',
				'fax_2' => 'Fax',
				'mobile_2' => 'Mobile',
				'email_address_2' => 'Email Address',
				'street_number_name_2' => 'Street Number &amp; Name',
				'suburb_2' => 'Suburb',
				'postcode_2' => 'Postcode',
				'state_2' => 'State',
				'country_2' => 'Country',
				'business_hours_2' => 'Business Hours'
			
			),
			'Australian Business Numbers' => array(
			
				'abn' => 'ABN',
				'acn' => 'ACN'
				
			),
			'Social Networking' => array(
			
				'facebook' => 'Facebook',
				'twitter' => 'Twitter',
				'myspace' => 'Myspace',
				'linkedin' => 'LinkedIn',
				'googleplus' => 'Google+',
				'pinterest' => 'Pinterest',
				'youtube' => 'YouTube'
				
			)
		
		);
		
		// Render options in-line with WordPress core styling
		echo '<div class="wrap" id="post-navigator-settings">';
		
		echo '	<div class="icon32" id="icon-options-general"><br></div>';
		echo '	<h2>Contact Details</h2>';
		
		echo '	<p>Enter your contact details below. To display any particular contact details on your website, use the shortcode supplied</p>';

		echo '	<form id="contact-details" name="contact-details" method="POST" action="#">';
		
		// Loop through "sections" and output form fields
		foreach( $data as $section => $fields ) {
		
			echo '<div class="contact-details">';
			
			echo '	<h3>' . $section . '</h3>';
			
			foreach( $fields as $key => $title ) {
			
				echo '<label for="' . $key . '">' . $title . '</label>';
				echo '<input type="text" name="contact_details[' . $key . ']" value="' . esc_attr( $details[$key] ) . '" />&nbsp;&nbsp;&nbsp;';
				echo '[contact type="' . $key . '"]';
				echo '<br /><br />';
				
			}
					
			echo '</div>';
		
		}
		
		echo '<input type="submit" value="Save Details" class="button button-primary" />';
		
		echo '	</form>';

		echo '</div>';
	
	}

}

?>