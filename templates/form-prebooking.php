
<form id="peak-15-form" name="p15-prebooking-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

	<!-- Our Hidden Data tp be pre-populated -->
	<input type="hidden" name="formname" value="Pre-Booking Form">
	<input type="hidden" name="pagename" value="">
    <input type="hidden" name="statuscode" value="Request Completed">
    <input type="hidden" name="rule" value="Contacts with same First Name Email">
    <!-- <input type="hidden" name="ruletype" value="retainexistingvalues"> -->
    <input type="hidden" name="contacttype" value="HOT Prospect">

	<div class="">
		<p>
			Hello and thank you for your interest in joining one of our epic motorcycle adventures! Before we can go any further we need to ask a few simple questions for us to better understand you, your ability on 2-wheels and your personal preferences...
		</p>
	</div>

	<h3>Contact Information:</h3>

    <!-- FIRST NAME -->
    <div id="firstname-group" class="p15-input-group">
        <label for="firstname">First Name <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="firstname" placeholder="Enter your first name..." >
        <!-- errors will go here -->
    </div>

    <!-- LAST NAME -->
    <div id="lastname-group" class="p15-input-group">
        <label for="lastname">Last Name <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="lastname" placeholder="Enter your last name..." >
        <!-- errors will go here -->
    </div>

    <!-- EMAIL ADDRESS -->
    <div id="email-group" class="p15-input-group">
        <label for="email">Email Address <span style="color:red">*</span></label>
        <input type="text" class="p15-input-control" name="email" placeholder="Enter your email address..." >
        <!-- errors will go here -->
    </div>
	<!-- PHONE NUMBER -->
	<div id="phone-group" class="p15-input-group">		
		<label for="telephone1">Phone Number <span style="color:red">*</span></label>
		<input type="tel" class="p15-input-control"  placeholder="Type your phone number (Eg. +44 123 456 7891)"  name="telephone1">
		<!-- errors will go here -->
	</div>
	<hr>

	<h3>License &amp; Riding Level:</h3>
	<!-- LICENSE TYPE -->
	<div id="licensetype-group" class="p15-input-group">			
		<label for="rideexp_motorcyclelicensetype">Motorcycle License Type <span style="color:red">*</span></label>
		<select class="p15-input-control" name="rideexp_motorcyclelicensetype" >
			<option value=""></option>
			<option value="No License">No License</option>
			<option value="Restricted">Restricted</option>
			<option value="Unrestricted">Unrestricted</option>
		</select>
	</div>
	<!-- errors will go here -->

	<!-- LICENSE HELD SINCE -->
	<div id="licensesince-group" class="p15-input-group">			
		<label for="rideexp_licenseheldsince">License Held Since <span style="color:red">*</span></label>
		<input class="p15-input-control" name="rideexp_licenseheldsince" id="datepicker" >
	</div>
	<!-- errors will go here -->

	<!-- ROAD RIDING LEVEL -->
	<div id="levelroad-group" class="p15-input-group">			
		<label for="rideexp_roadridinglevel">Road Riding Level <span style="color:red">*</span></label>
		<select class="p15-input-control" name="rideexp_roadridinglevel" >
			<option value=""></option>
			<option value="Beginner">Beginner</option>
			<option value="Novice">Novice</option>
			<option value="Competent">Competent</option>
			<option value="Advanced">Advanced</option>
			<option value="Valentino Rossi">Valentino Rossi</option>
		</select>
	</div>
	<!-- errors will go here -->

	<!-- OFFROAD RIDING LEVEL -->
	<div id="leveloffroad-group" class="p15-input-group">			
		<label for="rideexp_offroadridinglevel">Off-Road Riding Level <span style="color:red">*</span></label>
		<select class="p15-input-control" name="rideexp_offroadridinglevel" >
			<option value=""></option>
			<option value="Beginner">Beginner</option>
			<option value="Novice">Novice</option>
			<option value="Competent">Competent</option>
			<option value="Advanced">Advanced</option>
			<option value="Graham Jarvis">Graham Jarvis</option>
		</select>
	</div>
	<!-- errors will go here -->

	<!-- MOTORCYCLES OWNED -->
	<div id="motorcycles-group" class="p15-input-group">
		<label class="">Motorcycles Owned <span style="color:red">*</span></label>
		<textarea class="p15-input-control" placeholder="Please list current and previous motorcycles owned..."  name="rideexp_motorcyclesowned"></textarea>
	</div>
	<!-- errors will go here -->

	<hr>
	<!-- TERRAIN EXPERIENCE -->
	<div id="terrainexp-group" class="p15-input-group ">	
		<h3 class="">Terrain Experience <span style="color:red">*</span></h3>
		<div class="p15-checkbox-group">
			<label for="rideexp_terrain_mountainroads">Mountain Roads
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_mountainroads">
			</label>
			<label for="rideexp_terrain_graveldirtroads">Gravel Roads / Dirt Roads
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_graveldirtroads">
			</label>
			<label for="rideexp_terrain_sandytracks">Sandy Tracks
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_sandytracks">
			</label>
			<label for="rideexp_terrain_sanddunes">Sand Dunes
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_sanddunes">
			</label>
			<label for="rideexp_terrain_mud">Mud
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_mud">
			</label>
			<label for="rideexp_terrain_motorcrosstracks">Motocross Tracks
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_motorcrosstracks">
			</label>
			<label for="rideexp_terrain_bulldust">Bulldust
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_bulldust">
			</label>
			<label for="rideexp_terrain_snow">Snow
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_snow">
			</label>
			<label for="rideexp_terrain_strongwinds">Strong Winds
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_strongwinds">
			</label>
			<label for="rideexp_terrain_noneoftheabove">None of the above
				<input class="yncheckbox" type="checkbox" value="No" name="rideexp_terrain_noneoftheabove">
			</label>
		</div>
		<textarea class="p15-input-control" placeholder="Other terrain experience..." name="rideexp_terrain_other"></textarea>
	</div>
	<!-- errors will go here -->
	<hr>

	<h3>Fitness Level:</h3>
	<!-- FITNESS LEVEL -->
	<div id="fitnesslevel-group" class="p15-input-group">			
		<label for="rideexp_fitness">Your fitness level <span style="color:red">*</span></label>
		<select class="p15-input-control" name="rideexp_fitness" >
			<option value=""></option>
			<option value="Very Unfit">Very Unfit</option>
			<option value="Quite Unfit">Quite Unfit</option>
			<option value="Average">Average</option>
			<option value="Quite Fit">Quite Fit</option>
			<option value="Very Fit">Very Fit</option>
		</select>
	</div>
	<!-- errors will go here -->

	<button id="formSubmit" type="submit" class="p15-btn">Submit <i class="fa fa-chevron-right" aria-hidden="true"></i></button>

    <input type="hidden" name="action" value="submit_form">
			
</form>