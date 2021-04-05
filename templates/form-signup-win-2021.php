
<form id="peak-15-form" name="form-win-free-tour-2021" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

    <input type="hidden" name="formname" value="Win a FREE Tour 2021">
    <input type="hidden" name="pagename" value="">
    <input type="hidden" name="statuscode" value="Request Completed">
    <input type="hidden" name="catalogrequest" value="1">
    <input type="hidden" name="rule" value="Contacts with same First Name Email">
    <!-- <input type="hidden" name="ruletype" value="retainexistingvalues"> -->
    <input type="hidden" name="bulkemail" value="0">
    <input type="hidden" name="donotsendmm" value="0" />
    <input type="hidden" name="p15_listid" value="Win a FREE Tour 2021" />
    <input type="hidden" name="contacttype" value="Subscriber">
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

    <button id="formSubmit" type="submit" class="p15-btn">Submit <span class="fa fa-arrow-right"></span></button>

    <input type="hidden" name="action" value="submit_form">

</form>