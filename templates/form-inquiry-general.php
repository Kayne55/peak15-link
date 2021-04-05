
<form id="peak-15-form" name="form-inquiry-general" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

    <input type="hidden" name="formname" value="General Inquiry Form">
    <input type="hidden" name="pagename" value="Motorcycle Tour - Enquiry">
    <input type="hidden" name="rule" value="Contacts with same First Name Email">
    <!-- <input type="hidden" name="ruletype" value="retainexistingvalues"> -->
    <!-- <input type="hidden" name="p15_listid" value="" /> -->
    <input type="hidden" name="contacttype" value="Prospect">
    <input type="hidden" name="p15_channel" value="Web">
    <!-- GOOGLE ANALYTICS FIELDS -->
    <input type="hidden" id='source' name='p15_unresolved_campaign'>
    <input type="hidden" id='medium' name='p15_gamedium'>
    <input type="hidden" id='term' name='p15_searchkeywords'>
    <input type="hidden" id='content' name='p15_gacontent'>
    <input type="hidden" id='campaign' name='p15_gacampaign'>

    <!-- FIRST NAME -->
    <div id="firstname-group" class="p15-input-group">
        <label for="firstname">First Name <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="firstname" placeholder="Enter your first name...">
        <!-- errors will go here -->
    </div>

    <!-- LAST NAME -->
    <div id="lastname-group" class="p15-input-group">
        <label for="lastname">Last Name <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="lastname" placeholder="Enter your last name...">
        <!-- errors will go here -->
    </div>

    <!-- EMAIL ADDRESS -->
    <div id="email-group" class="p15-input-group">
        <label for="email">Email Address <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="email" placeholder="Enter your email address...">
        <!-- errors will go here -->
    </div>

    <!-- PHONE NUMBER -->
	<div id="phone-group" class="p15-input-group">		
		<label for="telephone1">Phone Number <span style="color:red">*</span></label>
		<input type="tel" class="p15-input-control"  placeholder="Type your phone number (Eg. +44 123 456 7891)" notrequired="" name="telephone1">
		<!-- errors will go here -->
	</div>

    <!-- MESSAGE -->
    <div id="message-group" class="p15-input-group">		
		<label for="p15_comment">Your Message</label>
        <textarea class="p15-input-control" placeholder="Type your message here..." name="p15_comment" maxlength="500"></textarea>
    </div>
    
<!--
    <div id="tourinterest-group" class="p15-input-group">			
		<label class="">What tour are you interested in?</label>
		<select  name="tour_most_interested_in">
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
			<option value="Cape Town to Victoria Falls">Cape Town to Victoria Falls</option>
			<option value="Other">Other</option>
		</select>
	</div>

    <div id="tourinterest-group" class="p15-input-group">			
		<label class="">What countries are you interested in?</label>
        <select  name="tour_most_interested_in">
            <input type="checkbox" value="Patagonia"> Patagonia
			<input type="checkbox" value="Morocco"> Morocco
			<input type="checkbox" value="Bolivia"> Bolivia
			<input type="checkbox" value="Peru"> Peru
			<input type="checkbox" value="Nepal"> Nepal
        </select>
    </div>
-->
    <!-- SUBSCRIBE TO NEWSLETTER -->
    <div class="p15-checkbox-group" style="background-color: transparent;">
        <label style="background-color: transparent;" for="bulkemail">
            <input class="boolcheckbox" type="checkbox" name="bulkemail" value=""> Subscribe to Our Newsletter
        </lable> 
    </div>

    <button id="formSubmit" type="submit" class="p15-btn">Submit <span class="fa fa-arrow-right"></span></button>

    <input type="hidden" name="action" value="submit_form">

</form>