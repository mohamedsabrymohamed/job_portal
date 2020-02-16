<?php 
    if(is_user_login() and !is_user_verified())
    {
        set_temp_session();
    }
	else
	{
		unset_temp_session_id();
	}
    if(get_temp_session_id())
    {
        ?>
        <div class="confirmation_top_bar">
            <p>Please Confirm your email address.</p>
            <div>
                <?php $action_url = create_url('process.php'); ?>
                <form class='reg-form' id="resend-confirmation-form" method="post" action="<?php echo $action_url; ?>" data-parsley-validate>
                    <input type="hidden" name="form_name" value="resend_confirmation_mail" />
                    <input type="submit" name="Account" class='button_f' value="Resend Email"/>
                </form>
            </div>
            <?php echo '<br/><div id="confirmation-messagebox" class="message">'.get_error_message().'</div>'; ?>
        </div>
        <?php
    }
?>