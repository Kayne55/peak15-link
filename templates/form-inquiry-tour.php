
<form id="peak-15-form" name="form-inquiry-tour" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
    
    <input type="hidden" name="formname" value="Tour Inquiry Form">
    <input type="hidden" name="pagename" value="">
    <input type="hidden" name="statuscode" value="">
    <input type="hidden" name="catalogrequest" value="1">
    <input type="hidden" name="rule" value="Contacts with same First Name Email">
    <!-- <input type="hidden" name="ruletype" value="retainexistingvalues"> -->
    <!-- <input type="hidden" name="p15_listid" value="" /> -->
    <input type="hidden" name="contacttype" value="Prospect">
    <!-- TRIP, DESTINATION & ACTIVITY INTEREST -->
    <input type="hidden" name="p15_trips" value="">
    <input type="hidden" name="destination" value="">
    <input type="hidden" name="tripactivity" value="">
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
	</div>
    <!-- errors will go here -->

    <!-- MESSAGE -->
    <div id="message-group" class="p15-input-group">		
		<label for="p15_comment">Your Message</label>
        <textarea class="p15-input-control" placeholder="Type your message here..." name="p15_comment" maxlength="500"></textarea>
    </div>

    <!-- GROUP SIZE -->
	<div id="groupsize-group" class="p15-input-group">			
		<label for="p15_groupsize">Group Size <span style="color:red">*</span></label>
		<select class="p15-input-control" name="p15_groupsize">
			<option value=""></option>
			<option value="Just Myself">Just Myself</option>
			<option value="1 to 2">1 to 2</option>
			<option value="2 to 4">2 to 4</option>
			<option value="4 to 6">4 to 6</option>
			<option value="6 to 8">6 to 8</option>
			<option value="8 to 10">8 to 10</option>
			<option value="10 +">10 +</option>
		</select>
	</div>
	<!-- errors will go here -->   
    
    <!-- SUBSCRIBE TO NEWSLETTER -->
    <div class="p15-checkbox-group" style="background-color: transparent;">
        <label style="background-color: transparent;" for="bulkemail">
            <input class="boolcheckbox" type="checkbox" name="bulkemail" value=""> Subscribe to Our Newsletter
        </lable> 
    </div>

    <button id="formSubmit" type="submit" class="p15-btn">Submit <span class="fa fa-arrow-right"></span></button>

    <input type="hidden" name="action" value="submit_form">

</form>