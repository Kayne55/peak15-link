<!--
<form id="peak-15-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

    <input type="hidden" name="pagename" value="">
    <input type="hidden" name="statuscode" value="Request Completed">
    <input type="hidden" name="catalogrequest" value="1">
    <input type="hidden" name="ruletype" value="" />
    <input type="hidden" name="bulkemail" value="0">
    <input type="hidden" name="donotsendmm" value="0" />
    <!-- <input type="hidden" name="p15_listid" value="" /> --
    <input type="hidden" name="contacttype" value="Subscriber">

    <!-- FIRST NAME --
    <div id="firstname-group" class="p15-input-group">
        <label for="firstname">First Name</label>
        <input type="text" class="p15-input-control" name="firstname" placeholder="Enter your first name...">
        <!-- errors will go here --
    </div>

    <!-- LAST NAME --
    <div id="lastname-group" class="p15-input-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="p15-input-control" name="lastname" placeholder="Enter your last name...">
        <!-- errors will go here --
    </div>

    <!-- EMAIL ADDRESS --
    <div id="email-group" class="p15-input-group">
        <label for="email">Email Address</label>
        <input type="text" class="p15-input-control" name="email" placeholder="Enter your email address...">
        <!-- errors will go here --
    </div>

    <button id="formSubmit" type="submit" class="p15-btn">Submit <span class="fa fa-arrow-right"></span></button>

    <input type="hidden" name="action" value="submit_form">

    <?php //wp_nonce_field( 'ajax-form-nonce', '' ) ?>

</form>-->

<form class="peak-15-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

	<!-- Our Hidden Data tp be pre-populated -->
	<input type="hidden" name="pagename" value="">
    <input type="hidden" name="statuscode" value="Request Completed">
    <input type="hidden" name="ruletype" value="">
    <input type="hidden" name="bulkemail" value="0">
    <input type="hidden" name="donotsendmm" value="0">
    <!-- <input type="hidden" name="p15_listid" value="" /> -->
    <input type="hidden" name="contacttype" value="Subscriber">

	<div class="">
		<p>
			Hello and thank you for your interest in joining one of our epic motorcycle adventures! Before we can go any further we need to ask a few simple questions for us to better understand you, your ability on 2-wheels and your personal preferences...
		</p>
	</div>
	
    <!-- FIRST NAME -->
    <div id="firstname-group" class="p15-input-group">
        <label for="firstname">First Name</label>
        <input type="text" class="p15-input-control" name="firstname" placeholder="Enter your first name..." required="">
        <!-- errors will go here -->
    </div>

    <!-- LAST NAME -->
    <div id="lastname-group" class="p15-input-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="p15-input-control" name="lastname" placeholder="Enter your last name..." required="">
        <!-- errors will go here -->
    </div>

    <!-- EMAIL ADDRESS -->
    <div id="email-group" class="p15-input-group">
        <label for="email">Email Address</label>
        <input type="text" class="p15-input-control" name="email" placeholder="Enter your email address..." required="">
        <!-- errors will go here -->
    </div>
	<!-- PHONE NUMBER -->
	<div id="phone-group" class="p15-input-group">		
		<label class="">Phone*</label>
		<input type="text" class="p15-input-control"  placeholder="Type your phone number" required="" name="telephone1">
	</div>

	<!-- <div id="paxno-group" class="p15-input-group">	
		<label >How many people are there in your group?</label>
		<select  name="how_many_people">
			<option selected=""></option>
			<option value="Just myself">Just myself</option>
			<option value="1 to 2">1 to 2</option>
			<option value="2 to 4">2 to 4</option>
			<option value="4 to 6">4 to 6</option>
			<option value="6 to 8">6 to 8</option>
			<option value="8 to 10">8 to 10</option>
			<option value="10 +">10 +</option>
		</select>
	</div> -->

	<!-- <div id="email-group" class="p15-input-group">			
		<label class="">What is the name of the tour in which you are interested?</label>
		<select  name="tour_most_interested_in">
			<option selected=""></option>
			<option value="Undecided" selected="">Undecided</option>
			<option value="The Warrior's Trail (Mongolia)">The Warrior's Trail (Mongolia)</option>
			<option value="Himalayan Heights (India)">Himalayan Heights (India)</option>
			<option value="Hidden Himalayas (India)">Hidden Himalayas (India)</option>
			<option value="Laos - Vietnam (Vietnam &amp; Laos)">Laos - Vietnam (Vietnam &amp; Laos)</option>
			<option value="Ho Chi Minh Trail (Laos)">Ho Chi Minh Trail (Laos)</option>
			<option value="Hill Tribe Expedition (Laos)">Hill Tribe Expedition (Laos)</option>
			<option value="Cambodian Quest (Cambodia)">Cambodian Quest (Cambodia)</option>
			<option value="Cambo Quest - New (Cambodia)">Cambo Quest - New (Cambodia)</option>
			<option value="Cardamom Mountain Explorer (Cambodia)">Cardamom Mountain Explorer (Cambodia)</option>
			<option value="Jungle &amp; Mountain Explorer (Cambodia)">Jungle &amp; Mountain Explorer (Cambodia)</option>
			<option value="The Tough One (Cambodia)">The Tough One (Cambodia)</option>
			<option value="Tumble in the Jungle (Cambodia)">Tumble in the Jungle (Cambodia)</option>
			<option value="Sea to Safari (South Africa)">Sea to Safari (South Africa)</option>
			<option value="Cape Crusader (South Africa)">Cape Crusader (South Africa)</option>
			<option value="Colombian Trailblazer (Colombia)">Colombian Trailblazer (Colombia)</option>
			<option value="Himalayan Escape (India)">Himalayan Escape (India)</option>
			<option value="Vietnam Off-Road">Vietnam Off-Road</option>
			<option value="Ultimate Vietnam Off-Road">Ultimate Vietnam Off-Road</option>
			<option value="Vietnam Road Rider">Vietnam Road Rider</option>
			<option value="Ultimate Vietnam Road Rider">Ultimate Vietnam Road Rider</option>
			<option value="Namibia Unleashed">Namibia Unleashed</option>
			<option value="Patagonia">Patagonia</option>
			<option value="Morocco">Morocco</option>
			<option value="Bolivia">Bolivia</option>
			<option value="Peru">Peru</option>
			<option value="Nepal">Nepal</option>
			<option value="Cape Town to Victoria Falls">Cape Town to Victoria Falls</option>
			<option value="Other">Other</option>
		</select>
	</div> -->
	
	<!-- <div id="email-group" class="p15-input-group">	
		<label class="">What are your ideal travel dates? </label>
		<input type="text" class="p15-input-control"  value="" placeholder="" name="ideal_travel_dates">
	</div> -->

	<!-- LICENSE TYPE -->
	<div id="licensetype-group" class="p15-input-group">			
		<label for="rideexp_motorcyclelicensetype">Motorcycle License Type *</label>
		<select name="rideexp_motorcyclelicensetype">
			<option value="None">None</option>
			<option value="Restricted">Restricted</option>
			<option value="Unrestricted">Unrestricted</option>
		</select>
	</div>
	<!-- LICENSE HELD SINCE -->
	<div id="licensetype-group" class="p15-input-group">			
		<label for="rideexp_licenseheldsince">License held since *</label>
		<input type="text" name="rideexp_licenseheldsince" id="datepicker">
	</div>
	
	<div id="email-group" class="p15-input-group">			
		<label class="">Do you hold a motorcycle license in your home country?* (It is a requirement of any responsible motorcycle touring company that you hold a license which allows you to ride motorcycles in your home country. Without a valid motorcycle it won't be possible for you to obtain the necessary travel insurance).*</label>	
		
		<input  type="radio"  value="Yes" required="" name="motorcycle_license">
		<span><label for="">Yes</label></span>

		<input  type="radio"  value="No" name="motorcycle_license">
		<span><label for="">No</label></span>
	</div>

	<div id="email-group" class="p15-input-group">	
		<label class="">How many years on-road riding experience do you have?*</label>
				
		<input  type="radio"  value="< 1 Year" required="" name="riding_experience_on_road">
		<span><label for="">&lt; 1 Year</label></span>
	
		<input  type="radio"  value="1 - 2 Years" name="riding_experience_on_road">
		<span><label for="">1 - 2 Years</label></span>
		
		<input  type="radio"  value="3 - 5 Years" name="riding_experience_on_road">
		<span><label for="">3 - 5 Years</label></span>
			
		<input  type="radio"  value="6+ Years" name="riding_experience_on_road">
		<span><label for="">6+ Years</label></span>
	</div>
	
	<div id="email-group" class="p15-input-group">							
		<label class="">How many years off-road riding experience do you have?*</label>		
		<input  type="radio"  value="< 1 Year" required="" name="riding_experience_off_road">
		<span><label for="">&lt; 1 Year</label></span>
		
		<input  type="radio"  value="1 - 2 Years" name="riding_experience_off_road">
		<span><label for="">1 - 2 Years</label></span>
			
		<input  type="radio"  value="3 - 5 Years" name="riding_experience_off_road">
		<span><label for="">3 - 5 Years</label></span>
			
		<input  type="radio"  value="6+ Years" name="riding_experience_off_road">
		<span><label for="">6+ Years</label></span>
	</div>
	
	<div id="email-group" class="p15-input-group">	
		<label class="">Please indicate the terrain you have experience riding on: *</label>
		
		<input  type="checkbox"  value="Gravel" class="">
		<span><label for="">Gravel</label></span>

		<input  type="checkbox"  value="Dirt Roads" name="terrain_experience">
		<span><label for="">Dirt Roads</label></span>

		<input  type="checkbox"  value="Sand" name="terrain_experience">
		<span><label for="">Sand</label></span>
	
		<input  type="checkbox"  value="Mud" name="terrain_experience">
		<span><label for="">Mud</label></span>
	
		<input  type="checkbox"  value="Motocross Tracks" name="terrain_experience">
		<span><label for="">Motocross Tracks</label></span>
	
		<input  type="checkbox"  value="Bulldust" name="terrain_experience">
		<span><label for="">Bulldust</label></span>
	
		<input  type="checkbox"  value="None of the above" name="terrain_experience">
		<span><label for="">None of the above</label></span>
	
		<input  type="checkbox"  value="Other" name="terrain_experience">
		<span><label for="">Other</label></span>
	</div>
	
	<div id="email-group" class="p15-input-group">	
		<label class=""></label>
		<input type="text" class="p15-input-control"  value="" placeholder="Other explained..." name="terrain_experience_other">
	
		<label class="">Please list current and previous motorcycles owned:*</label>
		<textarea  placeholder="" required="" name="motorcycles_owned"></textarea>
	
		<label class="">What is your age?*</label>					
		<input  type="radio"  value="<18" required="" name="age">
		<span><label for="">&lt;18</label></span>
		
		<input  type="radio"  value="18 - 25" name="age">
		<span><label for="">18 - 25</label></span>
	
		<input  type="radio"  value="26 - 45" name="age">
		<span><label for="">26 - 45</label></span>
	
		<input  type="radio"  value="46 - 60" name="age">
		<span><label for="">46 - 60</label></span>
	
		<input  type="radio"  value="61 - 70" name="age">
		<span><label for="">61 - 70</label></span>
	
		<input  type="radio"  value="71+" name="age">
		<span><label for="">71+</label></span>
	</div>
	
	<div id="email-group" class="p15-input-group">	
		<label class="">Where did you hear about us?*</label>
				
		<input  type="radio"  value="Search engine" required="" name="where_did_you_hear_about_us">
		<span><label for="">Search engine</label></span>
	
		<input  type="radio"  value="Facebook" name="where_did_you_hear_about_us">
		<span><label for="">Facebook</label></span>
	
		<input  type="radio"  value="Youtube" name="where_did_you_hear_about_us">
		<span><label for="">Youtube</label></span>
	
		<input  type="radio"  value="Magazine article" name="where_did_you_hear_about_us">
		<span><label for="">Magazine article</label></span>
	
		<input  type="radio"  value="Magazine advert" name="where_did_you_hear_about_us">
		<span><label for="">Magazine advert</label></span>
	
		<input  type="radio"  value="Online advert" name="where_did_you_hear_about_us">
		<span><label for="">Online advert</label></span>
	
		<input  type="radio"  value="Word of mouth" name="where_did_you_hear_about_us">
		<span><label for="">Word of mouth</label></span>
	
		<input  type="radio"  value="Other..." name="where_did_you_hear_about_us">
		<span><label for="">Other...</label></span>
	</div>
		
	<div id="email-group" class="p15-input-group">	
		<label class=""></label>
		<input type="text" class="p15-input-control"  value="" placeholder="Other explained..." name="hear_about_other">
	</div>

	<button id="formSubmit" type="submit" class="p15-btn">Submit <span class="fa fa-arrow-right"></span></button>

    <input type="hidden" name="action" value="submit_form">
				
</form>