<script type="text/javascript">
    __ARSLikeAjaxURL = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
global $arsocial_lite_like, $arsocial_lite, $wpdb;

$displays = array('page' => 'page');
$action = isset($_REQUEST['arsocialaction']) ? $_REQUEST['arsocialaction'] : 'new-like';
$like_id = isset($_REQUEST['network_id']) ? $_REQUEST['network_id'] : '';
$like_name = '';
$like_content = '';
$social_options = array();
if ($action !== '' && ($action === 'edit-like' || $action === 'duplicate') && $like_id !== '') {
    $table = $wpdb->prefix . 'arsocial_lite_like';
    $like = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$table` WHERE ID = %d", $like_id));
    $like = $like[0];
    $like_content = $like->content;
    $social_options = maybe_unserialize($like_content);
    $displays = isset($social_options['display']) ? $social_options['display'] : array();
}

$sociallike_tab_option = $arsocial_lite->ARSocialShareDefaultLikeNetworks();

$enableNetworks = $arsocial_lite->ars_get_enable_networks();
$fbClassBtn = $fbDisableNotice = $twClassBtn = $twDisableNotice = "";

$fbLikeChecked = checked(isset($social_options['facebook']['is_fb_like']) ? $social_options['facebook']['is_fb_like'] : '', 1, false);
if (!in_array('facebook', $enableNetworks)) {
    $fbClassBtn = "ars_disable arsocialshare_disable_tooltip";
    $fbDisableNotice = esc_html__('Please configure facebook api settings in general settings', 'arsocial_lite');
    $social_options['facebook']['is_fb_like'] = 0;
    $fbLikeChecked = $fbFollowChecked = 'disabled="disabled"';
}
$twChecked = checked(isset($social_options['twitter']['is_twitter_like']) ? $social_options['twitter']['is_twitter_like'] : '', 1, false);
if (!in_array('twitter', $enableNetworks)) {
    $twClassBtn = "ars_disable arsocialshare_disable_tooltip";
    $twDisableNotice = esc_html__('Please configure twitter api settings in general settings', 'arsocial_lite');
    $social_options['twitter']['is_twitter_like'] = 0;
    $twChecked = 'disabled="disabled"';
}
?>

<div class="success-message" id="success-message">
</div>

<div class="ars_sticky_top_belt" id="ars_sticky_top_belt">
    <div class="arsocialshare_title_wrapper sticky_top_belt">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Like/Follow & Subscribe Configuration', 'arsocial_lite'); ?></label>
    </div>
    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="sticky_belt_loader" />
    <div class="ars_share_wrapper" title="<?php esc_html_e('Click to copy', 'arsocial_lite'); ?>" style="<?php echo ($like_id !== '' && $action !== 'duplicate' ) ? '' : 'display:none;' ?>" >
        <div class="ars_copied" style="position:absolute;top:7px;display:none;"><?php esc_html_e('Copied', 'arsocial_lite'); ?></div>
        <div class="ars_share_shortcode" id="ars_share_shortcode" data-code="[ARSocial_Lite_Like id=<?php echo $like_id; ?>]">
            [ARSocial_Lite_Like id=<?php echo $like_id; ?>]
        </div>
    </div>
    <button type='button' id="save_social_like" class="arsocialshare_save_display_settings shortcode_generator"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
    <button value="true" class="arsocialshare_save_display_settings cancel_button" id="ars_cancel_button" name="ars_cancel_button" type="button" onclick="location.href = '<?php echo admin_url('admin.php?page=arsocial-lite-shortcode-generator'); ?>'"><?php esc_html_e('Cancel', 'arsocial_lite'); ?></button>

</div>
<form name="arsocialshare_like" method="post" id="arsocialshare_like" onsubmit="return false;">
    <div class="arsocialshare_main_wrapper">
        <div class="arsocialshare_title_wrapper">
            <label class="arsocialshare_page_title"><?php esc_html_e('Social Like/Follow & Subscribe Configuration', 'arsocial_lite'); ?></label>
            <input type="hidden" name='arslike_ajaxurl' id='arslike_ajaxurl' value='<?php echo admin_url('admin-ajax.php'); ?>' />
        </div>
        <div class="documentation_link" id="documentation_link"><a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>" target="_blank"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?></a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL; ?>/documentation/assets/sysinfo.php');" /></div>
        
        <div class="arsocialshare_inner_wrapper">
            <div class="arsocialshare_networks">  
                <div class="arsocialshare_inner_wrapper" style='padding:0;'>
                    <div class="arsocialshare_networks_inner_wrapper">

                        <input type='hidden' name='arsocial_like_action' value="<?php echo $action; ?>" />
                        <input type='hidden' name='like_id' value='<?php echo $like_id; ?>' />

                        <div class="arsocialshare_title_belt">
                            <div class="arsocialshare_title_belt_number">1</div>
                            <div class="arsocialshare_belt_title"><?php esc_html_e('Select Position Where You Want To Display Like Buttons', 'arsocial_lite'); ?></div>
                        </div>
                        <?php
                        $page_hide_show = $sidebar_hide_show = $top_bottom_hide_show = $popup_hide_show = '';
                        $page_checked = '';
                        if (is_array($displays) && array_key_exists('page', $displays)) {
                            $page_checked = "checked='checked'";
                            $page_hide_show = 'display:block;';
                        }
                        ?>
                        <div class="arsocialshare_inner_container" style="padding:30px 5px 25px 30px;">
                            <label class="arsocialshare_inner_container_box two_col ars_shortcode_radio_position <?php echo ($page_checked !== '' ) ? 'selected' : ''; ?>">
                                <div class="arsocialshare_container_box_title_belt">
                                    <input type="radio" name="arsocialshare_like_enable_on" value="page" id="arsocialshare_like_enable_page" class="arsocialshare_radio_input ars_hide_radio" <?php echo $page_checked; ?> data-id="enable_sidebar_btns"/>
                                    <label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_like_enable_page" ><span></span>&nbsp;&nbsp;<?php esc_html_e('Pages', 'arsocial_lite'); ?></label>
                                </div>
                            </label>

                            <?php
                            $sidebar_checked = "";

                            if (is_array($displays) && array_key_exists('sidebar', $displays)) {
                                $sidebar_checked = "checked='checked'";
                                $sidebar_hide_show = "display:block;";
                            }
                            ?>
                            <?php
                            $ds_checked = "";
                            if (is_array($displays) && array_key_exists('top_bottom_bar', $displays)) {
                                $ds_checked = "checked='checked'";
                                $top_bottom_hide_show = 'display:block;';
                            }
                            ?>

                            <label class="arsocialshare_inner_container_box two_col inner_btn_option ars_shortcode_radio_position <?php echo ( $ds_checked !== '' ) ? "selected" : ''; ?>">
                                <div class="arsocialshare_container_box_title_belt">
                                    <input type="radio" name="arsocialshare_like_enable_on" value="top_bottom_bar" id="arsocialshare_enable_fly_in" class="arsocialshare_radio_input ars_hide_radio" <?php echo $ds_checked; ?> data-id="enable_fly_in_btns"/>
                                    <label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_enable_fly_in"><span></span>&nbsp;&nbsp;<?php esc_html_e('Top/Bottom Bar', 'arsocial_lite'); ?></label>
                                </div>
                            </label>

                            <?php
                            // popup
                            $pop_checked = $is_close_checked = "";
                            $pop_options = $onload_display = $onscroll_display = "display:none;";

                            if (is_array($displays) && array_key_exists('popup', $displays)) {
                                $pop_checked = "checked='checked'";
                                $popup_hide_show = 'display:block;';
                            }
                            ?>

                            <label class="arsocialshare_inner_container_box two_col inner_btn_option arsocial_lite_position_shortcode_restricted <?php echo ($pop_checked !== '' ) ? 'selected' : ''; ?>">
                                <div class="arsocialshare_container_box_title_belt">
                                    <input type="radio" name="arsocialshare_like_enable_on" value="popup" id="arsocialshare_enable_popup" class="arsocialshare_radio_input ars_hide_radio" data-id="enable_popup" <?php echo $pop_checked; ?>/>
                                    <label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_enable_popup"><span></span>&nbsp;&nbsp;<?php esc_html_e('Popup', 'arsocial_lite'); ?></label>&nbsp;&nbsp;<span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                                </div>
                            </label>


                        </div>

                        <div class="arsocialshare_title_belt">
                            <div class="arsocialshare_title_belt_number">2</div>
                            <div class="arsocialshare_belt_title"><?php esc_html_e('Select Networks', 'arsocial_lite'); ?></div>
                        </div>
                        <span class="ars_error_message" id="arsocialshare_like_network_error"><?php esc_html_e('Please select atleast one network.', 'arsocial_lite'); ?></span>
                        <input type="hidden" id="arsocialshare_like_order" name="arsocialshare_like_order" value='<?php echo json_encode(maybe_unserialize(isset($social_options['display']['network_order']) && is_array($social_options['display']['network_order']) ? $social_options['display']['network_order'] : array())); ?>' />
                        <div class="arsocialshare_inner_container arsocialshare_like_settings arsocialshare_sharing_sortable" id="arsocialshare_like_follow_subscribe" style="padding:30px 5px 25px 30px;">
                            <?php $social_options['facebook']['is_fb_like'] = (isset($social_options['facebook']['is_fb_like']) && $social_options['facebook']['is_fb_like'] ) ? $social_options['facebook']['is_fb_like'] : ''; ?>

                            <div class="arsocialshare_social_box <?php echo $fbClassBtn; ?>" title="<?php echo $fbDisableNotice; ?>" id="facebook" data-listing-order="1">
                                <input type="hidden" name="arsocialshare_like_network[]" value="facebook" class="arsocialshare_like_networks" />
                                <input type='checkbox' onclick="ars_network_active_deactive(this, 'facebook');" class="arsocialshare_like_network_input" name='active_fb_like' id='like_fb_active' value='1' <?php echo $fbLikeChecked; ?> />
                                <label for="like_fb_active"><span></span>&nbsp;&nbsp;</label>
                                <div class="arsocialshare_network_icon facebook"></div>
                                <div class="arsocialshare_social_box_title"><?php esc_html_e('Facebook', 'arsocial_lite'); ?>&nbsp;</div>
                                <span class="arsocialshare_move_icon"></span>
                                <div class="arsocialshare_box_container" id="arsocialshare_box_facebook_container" style="<?php echo (isset($social_options['facebook']['is_fb_like']) && !empty($social_options['facebook']['is_fb_like']) ) ? "" : "display:none"; ?>">
                                    <div class="arsocialshare_box_row arsocialshare_row_margin">
                                        <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('URL to Like', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_box_input">
                                            <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_like_url' value="<?php echo isset($social_options['facebook']['fb_like_url']) ? $social_options['facebook']['fb_like_url'] : ''; ?>" name='arsocialshare_fb_like_url' style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set an URL of facebook page or website page which user has to like. Leave this field blank to use URL of page where this button will be located.', 'arsocial_lite'); ?>">(?)</span>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_box_row arsocialshare_row_margin">
                                        <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Button Layout', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_box_input">
                                            <select id='arsocialshare_fb_like_button_layout' class="arsocialshare_dropdown" name='arsocialshare_fb_like_button_layout' style="width:90%;">
                                                <?php
                                                $fb_button_layout = $sociallike_tab_option['facebook']['facebook_button_layout'];
                                                $social_options['facebook']['fb_button_layout'] = isset($social_options['facebook']['fb_button_layout']) ? $social_options['facebook']['fb_button_layout'] : '';
                                                foreach ($fb_button_layout as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $key; ?>" <?php
                                                    if ($key == $social_options['facebook']['fb_button_layout']) {
                                                        echo 'selected';
                                                    }
                                                    ?> > <?php echo $value; ?> </option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_box_row arsocialshare_row_margin">
                                        <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_box_input">
                                            <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_like_button_width' value="<?php echo isset($social_options['facebook']['fb_button_width']) ? $social_options['facebook']['fb_button_width'] : ''; ?>" name='arsocialshare_fb_like_button_width' style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Work only with standard layout.', 'arsocial_lite'); ?>">(?)</span>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_box_row arsocialshare_row_margin">
                                        <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Button Action', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_box_input">
                                            <select class="arsocialshare_dropdown" id='arsocialshare_fb_like_button_action_type' name='arsocialshare_fb_like_button_action_type' style="width:90%;">
                                                <?php
                                                $fb_button_action_type = $sociallike_tab_option['facebook']['facebook_like_button_action_type'];
                                                $social_options['facebook']['fb_button_action_type'] = isset($social_options['facebook']['fb_button_action_type']) ? $social_options['facebook']['fb_button_action_type'] : '';
                                                foreach ($fb_button_action_type as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $key; ?>" <?php
                                                    if ($key == $social_options['facebook']['fb_button_action_type']) {
                                                        echo 'selected';
                                                    }
                                                    ?> > <?php echo $value; ?> </option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                        <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Button Colorscheme', 'arsocial_lite'); ?></div>
                                        <div class='arsocialshare_box_input'>

                                            <select class="arsocialshare_dropdown" id='arsocialshare_fb_like_button_colorscheme' name='arsocialshare_fb_like_button_colorscheme' style="width:90%;">
                                                <?php
                                                $fb_button_colorscheme = $sociallike_tab_option['facebook']['facebook_like_button_colorscheme'];
                                                $social_options['facebook']['facebook_like_button_colorscheme'] = isset($social_options['facebook']['facebook_like_button_colorscheme']) ? $social_options['facebook']['facebook_like_button_colorscheme'] : '';
                                                foreach ($fb_button_colorscheme as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $key; ?>" <?php
                                                    if ($key == $social_options['facebook']['facebook_like_button_colorscheme']) {
                                                        echo 'selected';
                                                    }
                                                    ?> > <?php echo $value; ?> </option>
                                            <?php } ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                        <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Language', 'arsocial_lite'); ?></div>
                                        <div class='arsocialshare_box_input'>

                                            <select class="arsocialshare_dropdown" id='arsocialshare_fb_like_button_language' name='arsocialshare_fb_like_button_language' style="width:90%;">
                                                <?php
                                                $fb_button_language = $arsocial_lite->ars_facebook_language_array();
                                                $social_options['facebook']['facebook_like_button_language'] = isset($social_options['facebook']['facebook_like_button_language']) ? $social_options['facebook']['facebook_like_button_language'] : 'en_US';
                                                foreach ($fb_button_language as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $key; ?>" <?php
                                                    if ($key == $social_options['facebook']['facebook_like_button_language']) {
                                                        echo 'selected';
                                                    }
                                                    ?> > <?php echo $value; ?> </option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <?php $social_options['facebook']['fb_button_show_friend_face'] = isset($social_options['facebook']['fb_button_show_friend_face']) ? $social_options['facebook']['fb_button_show_friend_face'] : '' ?>
                                    <div class="arsocialshare_box_row arsocialshare_row_margin">
                                        <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e("Show Friend's Faces", 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_box_input">
                                            <div class='arsocial_inner_input_wrap arsocialshare_checkbox_margin'>
                                                <input type='checkbox' name='arsocialshare_fb_like_button_show_friend_face' id='arsocialshare_fb_like_button_show_friend_face' value='1' <?php checked($social_options['facebook']['fb_button_show_friend_face'], 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='arsocialshare_fb_like_button_show_friend_face'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="arsocialshare_social_box <?php echo $twClassBtn; ?>" title="<?php echo $twDisableNotice; ?>" id="twitter"  data-listing-order="3">
                                <input type="hidden" name="arsocialshare_like_network[]" value="twitter" class="arsocialshare_like_networks" />
                                <input type='checkbox' name='active_twitter_like' id='active_twitter_like' class="arsocialshare_like_network_input" onclick="ars_network_active_deactive(this, 'twitter');" value='1' <?php echo $twChecked; ?> />
                                <label for="active_twitter_like"><span></span></label>
                                <div class="arsocialshare_network_icon twitter"></div>
                                <div class="arsocialshare_social_box_title">
<?php esc_html_e('Twitter Follow', 'arsocial_lite'); ?>
                                </div>
                                <span class="arsocialshare_move_icon"></span>
                                <div class="arsocialshare_box_container" id="arsocialshare_box_twitter_container" style="<?php echo (isset($social_options['twitter']['is_twitter_like']) && !empty($social_options['twitter']['is_twitter_like'])) ? "" : "display: none;"; ?>">

                                    <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                        <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Username', 'arsocial_lite'); ?></div>
                                        <div class='arsocialshare_box_input'>
                                            <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_like_url' value="<?php echo isset($social_options['twitter']['twitter_like_url']) ? $social_options['twitter']['twitter_like_url'] : ''; ?>" name='arsocialshare_twitter_like_url' style="width:90%;" />
                                        </div>
                                    </div>
                                    <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                        <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Show User Name', 'arsocial_lite'); ?></div>
                                        <div class='arsocialshare_box_input'>
                                            <div class='arsocial_inner_input_wrap arsocialshare_checkbox_margin'>
                                                <input type='checkbox' name='arsocialshare_twitter_show_username' id='arsocialshare_twitter_show_username' value='1' <?php checked(isset($social_options['twitter']['twitter_show_username']) ? $social_options['twitter']['twitter_show_username'] : '', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='arsocialshare_twitter_show_username'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                        <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Large Button', 'arsocial_lite'); ?></div>
                                        <div class='arsocialshare_box_input'>
                                            <div class='arsocial_inner_input_wrap arsocialshare_checkbox_margin'>
                                                <input type='checkbox' name='arsocialshare_twitter_large_button' id='arsocialshare_twitter_large_button' value='1' <?php checked(isset($social_options['twitter']['twitter_large_button']) ? $social_options['twitter']['twitter_large_button'] : '', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='arsocialshare_twitter_large_button'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                        <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Language', 'arsocial_lite'); ?></div>
                                        <div class='arsocialshare_box_input'>
                                            <select class="arsocialshare_dropdown" id='arsocialshare_twitter_like_button_language' name='arsocialshare_twitter_like_button_language' style="width:90%;">
                                                <?php
                                                $twitter_button_language = $sociallike_tab_option['twitter']['language'];
                                                $social_options['twitter']['twitter_button_language'] = isset($social_options['twitter']['twitter_button_language']) ? $social_options['twitter']['twitter_button_language'] : 'automatic';
                                                foreach ($twitter_button_language as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $key; ?>" <?php
                                                    if ($key == $social_options['twitter']['twitter_button_language']) {
                                                        echo 'selected';
                                                    }
                                                    ?> > <?php echo $value; ?> </option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                        <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Opt-out of tailoring Twitter', 'arsocial_lite'); ?></div>
                                        <div class='arsocialshare_box_input'>
                                            <div class='arsocial_inner_input_wrap arsocialshare_checkbox_margin'>
                                                <input type='checkbox' name='arsocialshare_twitter_opt_out_tailoring' id='arsocialshare_twitter_opt_out_tailoring' value='1' <?php checked(isset($social_options['twitter']['twitter_opt_out_tailoring']) ? $social_options['twitter']['twitter_opt_out_tailoring'] : '', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='arsocialshare_twitter_opt_out_tailoring'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_box_clear"></div>                                               
                        </div>
                        <!--Disabled Networks-->
                        <div class="arsocialshare_inner_container arsocialshare_like_settings" id="arsocialshare_like_follow_subscribe" style="padding:0px 5px 25px 30px;">
                            <div class="ars_lite_pro_networks_info"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Available in premium version', 'arsocial_lite'); ?> )</span></div>

                            <div class="arsocialshare_social_box_disabled" title="" id="linkedin"  data-listing-order="11">
                                <input type="hidden" name="arsocialshare_like_network_disabled[]" value="linkedin" class="arsocialshare_like_networks" />
                                <input type='checkbox' name='active_linkedin_like' class="arsocialshare_like_network_input" id='active_linkedin_like' value='1' />
                                <label for="active_linkedin_like"><span></span></label>
                                <div class="arsocialshare_network_icon linkedin"></div>
                                <div class="arsocialshare_social_box_title">
                                    <?php esc_html_e('Linkedin Follow', 'arsocial_lite'); ?>
                                </div>
                            </div>     
                            
                            <div class="arsocialshare_social_box_disabled" id="pinterest"  data-listing-order="7">
                                <input type="hidden" name="arsocialshare_like_network_disabled[]" value="pinterest" class="arsocialshare_like_networks" />
                                <input type='checkbox' name='active_pinterest_like' class="arsocialshare_like_network_input" id='active_pinterest_like' value='1' />
                                <label for="active_pinterest_like"><span></span></label>
                                <div class="arsocialshare_network_icon pinterest"></div>
                                <div class="arsocialshare_social_box_title">
<?php esc_html_e('Pinterest Pinit', 'arsocial_lite'); ?>
                                </div>
                            </div>

                            <div class="arsocialshare_social_box_disabled" id="pinterest_follow"  data-listing-order="8">
                                <input type="hidden" name="arsocialshare_like_network_disabled[]" value="pinterest_follow" class="arsocialshare_like_networks" />
                                <input type='checkbox' name='active_pinterest_follow' class="arsocialshare_like_network_input" id='active_pinterest_follow' value='1' />
                                <label for="active_pinterest_follow"><span></span></label>
                                <div class="arsocialshare_network_icon pinterest"></div>
                                <div class="arsocialshare_social_box_title">
<?php esc_html_e('Pinterest Follow', 'arsocial_lite'); ?>
                                </div>
                            </div>

                            <div class="arsocialshare_social_box_disabled" title="" id="vk"  data-listing-order="9">
                                <input type="hidden" name="arsocialshare_like_network_disabled[]" value="vk" class="arsocialshare_like_networks" />
                                <input type='checkbox' name='active_vk_like' class="arsocialshare_like_network_input" id='active_vk_like' value='1' />
                                <label for="active_vk_like"><span></span></label>
                                <div class="arsocialshare_network_icon vk"></div>
                                <div class="arsocialshare_social_box_title">
<?php esc_html_e('VK Like', 'arsocial_lite'); ?>
                                </div>
                            </div>

                            <div class="arsocialshare_box_clear"></div>

                            <div class="arsocialshare_social_box_disabled" id="viadeo"  data-listing-order="11">
                                <input type="hidden" name="arsocialshare_like_network_disabled[]" value="viadeo" class="arsocialshare_like_networks" />
                                <input type='checkbox' name='active_viadeo_like' class="arsocialshare_like_network_input" id='active_viadeo_like' value='1' />
                                <label for="active_viadeo_like"><span></span></label>
                                <div class="arsocialshare_network_icon viadeo"></div>
                                <div class="arsocialshare_social_box_title">
<?php esc_html_e('Viadeo', 'arsocial_lite'); ?>
                                </div>
                            </div>

                            <div class="arsocialshare_social_box_disabled" id="instagram" data-listing-order="12">
                                <input type="hidden" name="arsocialshare_like_network_disabled[]" value="instagram" class="arsocialshare_like_networks" />
                                <input type='checkbox' name='active_instagram_like' class="arsocialshare_like_network_input" id='active_instagram_like' value='1' />
                                <label for="active_instagram_like"><span></span></label>
                                <div class="arsocialshare_network_icon instagram"></div>
                                <div class="arsocialshare_social_box_title">
<?php esc_html_e('Instagram', 'arsocial_lite'); ?>
                                </div>
                            </div>
                            
                            <div class="arsocialshare_social_box_disabled" id="youtube"  data-listing-order="13">
                                <input type="hidden" name="arsocialshare_like_network_disabled[]" value="youtube" class="arsocialshare_like_networks" />
                                <input type='checkbox' name='active_youtube_like' id='active_youtube_like' class="arsocialshare_like_network_input" value='1' />
                                <label for="active_youtube_like"><span></span></label>
                                <div class="arsocialshare_network_icon youtube"></div>
                                <div class="arsocialshare_social_box_title">
<?php esc_html_e('Youtube Subscribe', 'arsocial_lite'); ?>
                                </div>
                            </div>
                            
                        </div>
                        <div class="arsocialshare_title_belt">
                            <div class="arsocialshare_title_belt_number">3</div>
                            <div class="arsocialshare_belt_title"><?php esc_html_e('Select Template & Style', 'arsocial_lite'); ?></div>
                        </div>

                        <div class="arsocialshare_inner_container"  style="padding:30px 5px 25px 30px;">
                            <div class="arsocialshare_inner_content_container">
                                <?php
                                $load_native_button = isset($social_options['load_native_button']) ? $social_options['load_native_button'] : 0;
                                $native_skin = (isset($social_options['load_native_skin']) && !empty($social_options['load_native_skin'])) ? $social_options['load_native_skin'] : 'default';
                                $native_button_width = (isset($social_options['native_btn_width']) && !empty($social_options['native_btn_width'])) ? $social_options['native_btn_width'] : 'automatic';
                                $fixed_width_btn = ($native_button_width === 'fixed_width') ? 'display:block;' : 'display:none;';
                                $fixed_width = isset($social_options['button_fixed_width']) ? $social_options['button_fixed_width'] : '';
                                $full_width_btn = ($native_button_width === 'full_width') ? 'display:block;' : 'display:none;';
                                $full_width = isset($social_options['button_full_width']) ? $social_options['button_full_width'] : '';
                                $btn_width = '';
                                if ($native_button_width !== 'automatic') {
                                    if ($native_button_width == 'fixed_width') {
                                        $btn_width = "width:" . $fixed_width . 'px;';
                                    } elseif ($native_button_width == 'fixed_width') {
                                        if ($full_width !== '' && $full_width != 0) {
                                            $btn_width = "width:100%;max-width:" . $full_width . '%;';
                                        } else {
                                            $btn_width = "width:100%;";
                                        }
                                    }
                                }
                                ?>
                                <div class="arsocialshare_option_container ars_column">
                                    <div class="arsocialshare_option_row">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
                                            <select  name="ars_like_skins" id="ars_top_bottom_skins" class="arsocialshare_dropdown ars_lite_pro_options">
                                                <?php
                                                $top_bottom_bar_skin = isset($displays['skin']) ? $displays['skin'] : 'default';
                                                ?>
                                                <option <?php selected($top_bottom_bar_skin, 'default'); ?> value="default"><?php esc_html_e('Flat', 'arsocial_lite'); ?></option>
                                                <!-- <option <?php //selected($top_bottom_bar_skin, 'skin1'); ?> value="skin1"><?php //esc_html_e('Modern', 'arsocial_lite'); ?></option>
                                                <option <?php //selected($top_bottom_bar_skin, 'skin2'); ?> value="skin2"><?php //esc_html_e('Iconic', 'arsocial_lite'); ?></option> -->
                                                <option <?php selected($top_bottom_bar_skin, 'skin3'); ?> value="skin3"><?php esc_html_e('Classic', 'arsocial_lite'); ?></option>
                                            </select>
                                        </div>
                                        <label class="arsocialshare_inner_option_label more_templates_label" ><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                    </div>

                                    <div class="arsocialshare_option_row">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Load Native Buttons', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
<?php $top_bottom_bar_load_native_btn = (isset($displays['load_native_btn']) && !empty($displays['load_native_btn'])) ? $displays['load_native_btn'] : "yes"; ?>
                                            <input type="hidden" name="ars_load_native_btn" id="ars_top_bottom_bar_load_native_btn" value="<?php echo $top_bottom_bar_load_native_btn; ?>" />
                                            <div class="arsocialshare_switch  <?php echo ($top_bottom_bar_load_native_btn === 'yes') ? "selected" : ""; ?>" data-id="ars_top_bottom_bar_load_native_btn" >
                                                <div class="arsocialshare_switch_options <?php echo ($top_bottom_bar_load_native_btn === 'yes') ? "selected" : ""; ?>" >
                                                    <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                    <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                                </div>
                                                <div class="arsocialshare_switch_button"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show" id="ars_top_bottombar_displaybar" style="display:none;<?php echo $top_bottom_hide_show; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
                                            <?php
                                            $display_bar_on = isset($displays['top_bottom_bar']['display_bar']) ? $displays['top_bottom_bar']['display_bar'] : 'onload';
                                            ?>
                                            <select class="arsocialshare_dropdown" name="arsocialshare_top_bottom_bar_display_on" id="arsocialshare_top_bottom_bar_display_on">
                                                <option <?php selected($display_bar_on, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                                <option <?php selected($display_bar_on, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row ars_popup_hide_show" style="display:none;<?php echo $popup_hide_show; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
                                            <?php
                                            $display_popup = isset($displays['popup']['display_popup']) ? $displays['popup']['display_popup'] : 'onload';
                                            ?>
                                            <select class="arsocialshare_dropdown" name="arsocialshare_popup_display_on" id="arsocialshare_popup_display_on">
                                                <option <?php selected($display_popup, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                                <option <?php selected($display_popup, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                    if ($display_popup == 'onload' && isset($displays['display_type']) && $displays['display_type'] == 'popup') {
                                        $popup_onload_show = 'display:block;';
                                    }
                                    if ($display_popup == 'onscroll' && isset($displays['display_type']) && $displays['display_type'] == 'popup') {
                                        $popup_onscroll_show = 'display:block;';
                                    }
                                    ?>
                                    <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option <?php echo ($display_popup === 'onload' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_load_wrapper" style="display:none;<?php echo isset($popup_onload_show)?$popup_onload_show:''; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n seconds', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="text" name="arsocialshare_popup_onload_time" id="arsocialshare_popup_onload_time" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['onload_time']) ? $displays['popup']['onload_time'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option <?php echo ($display_popup === 'onscroll' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_scroll_wrapper" style="display:none;<?php echo isset($popup_onscroll_show)?$popup_onscroll_show:''; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n % of scroll', 'arsocial_lite') ?></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="text" name="arsocialshare_popup_onscroll_percentage" id="arsocialshare_popup_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['onscroll_percentage']) ? $displays['popup']['onscroll_percentage'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                        </div>
                                    </div>

                                    <?php
                                    $display_bar_onload = $display_bar_onscroll = '';
                                    if ($display_bar_on == 'onload' && isset($displays['display_type']) && $displays['display_type'] == 'top_bottom_bar') {
                                        $display_bar_onload = 'display:block;';
                                    } else if ($display_bar_on == 'onscroll' && isset($displays['display_type']) && $displays['display_type'] == 'top_bottom_bar') {
                                        $display_bar_onscroll = 'display:block;';
                                    }
                                    ?>
                                    <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show arsocialshare_display_bar_option <?php echo ($display_bar_on === 'onload') ? 'selected' : ''; ?>" id="arsocialshare_on_load_wrapper" style="display:none;<?php echo $display_bar_onload; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n seconds', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="text" name="arsocialshare_top_bottom_bar_onload_time" id="arsocialshare_top_bottom_bar_onload_time" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['onload_time']) ? $displays['top_bottom_bar']['onload_time'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row arsocialshare_display_bar_option ars_dipsplay_bar_hide_show <?php echo ($display_bar_on === 'onscroll') ? 'selected' : ''; ?>" id="arsocialshare_on_scroll_wrapper" style="display:none;<?php echo $display_bar_onscroll; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n % of scroll', 'arsocial_lite') ?></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="text" name="arsocialshare_top_bottom_bar_onscroll_percentage" id="arsocialshare_top_bottom_bar_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['onscroll_percentage']) ? $displays['top_bottom_bar']['onscroll_percentage'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row arsocialshare_display_bar_option ars_dipsplay_bar_hide_show" style="<?php echo ( isset($displays['display_type']) && $displays['display_type'] == 'top_bottom_bar') ? 'display:block;' : 'display:none'; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Start Top Bar from Y Position', 'arsocial_lite') ?></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="text" name="arsocialshare_top_bottom_bar_y_position" id="arsocialshare_top_bottom_bar_y_position" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['y_point']) ? $displays['top_bottom_bar']['y_point'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px;top:8px;"> px </span>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row ars_popup_hide_show" style="display:none;<?php echo $popup_hide_show; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Show Close Button', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
<?php $is_close_button = isset($displays['popup']['is_close_button']) ? $displays['popup']['is_close_button'] : 'yes'; ?>
                                            <input type="hidden" name="arsocialshare_pop_show_close_button" id="arsocialshare_show_close_button" value="<?php echo $is_close_button ?>" />
                                            <div class="arsocialshare_switch <?php echo ($is_close_button === 'yes' ) ? 'selected' : ''; ?>" id="hide_on_mobile" data-id="arsocialshare_show_close_button">
                                                <div class="arsocialshare_switch_options">
                                                    <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                    <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                                </div>
                                                <div class="arsocialshare_switch_button"></div>
                                            </div>
                                        </div>
                                    </div>   
                                </div>

                                <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">



                                    <div class="arsocialshare_option_row">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
<?php $top_bottom_btn_width = isset($displays['btn_width']) ? $displays['btn_width'] : 'medium'; ?>
                                            <input type="radio" name="ars_btn_width" id="ars_top_bottom_btn_small" value="small" class="ars_hide_checkbox ars_like_top_bottom_btn_width_input" <?php checked($top_bottom_btn_width, 'small'); ?>/>
                                            <input type="radio" name="ars_btn_width" id="ars_top_bottom_btn_medium" value="medium" class="ars_hide_checkbox ars_like_top_bottom_btn_width_input"  <?php checked($top_bottom_btn_width, 'medium'); ?>/>
                                            <input type="radio" name="ars_btn_width" id="ars_top_bottom_btn_large" value="large" class="ars_hide_checkbox ars_like_top_bottom_btn_width_input" <?php checked($top_bottom_btn_width, 'large'); ?>/>

                                            <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width  <?php echo ($top_bottom_btn_width === 'small') ? "selected" : ""; ?>" id="ars_top_bottom_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_top_bottom_btn_small', 'ars_top_bottom_btn_width ')">
                                                <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                            </div>                                                                                                                                                                                                      
                                            <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width  <?php echo ($top_bottom_btn_width === 'medium') ? "selected" : ""; ?>" id="ars_top_bottom_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_top_bottom_btn_medium', 'ars_top_bottom_btn_width ')">
                                                <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                            </div>
                                            <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width  <?php echo ($top_bottom_btn_width === 'large') ? "selected" : ""; ?>" id="ars_top_bottom_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_top_bottom_btn_large', 'ars_top_bottom_btn_width ')">
                                                <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show" id="ars_share_alignment" style="display : none;<?php echo $page_hide_show . $top_bottom_hide_show; ?>">
                                        <div class="arsocialshare_option_label "><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
<?php $pages_btn_align = isset($displays['align']) ? $displays['align'] : 'ars_align_center'; ?>

                                            <input type="radio" name="ars_pages_align" id="ars_pages_btn_left" <?php checked($pages_btn_align, 'ars_align_left'); ?> value="ars_align_left" class="ars_hide_checkbox ars_pages_btn_align_input" />
                                            <input type="radio" name="ars_pages_align" id="ars_pages_btn_center" <?php checked($pages_btn_align, 'ars_align_center'); ?> value="ars_align_center" class="ars_hide_checkbox ars_pages_btn_align_input"  />
                                            <input type="radio" name="ars_pages_align" id="ars_pages_btn_right" <?php checked($pages_btn_align, 'ars_align_right'); ?> value="ars_align_right" class="ars_hide_checkbox ars_pages_btn_align_input" />

                                            <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($pages_btn_align === 'ars_align_left') ? 'selected' : ''; ?>" id="ars_pages_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_pages_btn_left', 'ars_pages_btn_align');">
                                                <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                            </div>
                                            <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($pages_btn_align === 'ars_align_center') ? 'selected' : ''; ?>" id="ars_pages_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_pages_btn_center', 'ars_pages_btn_align');">
                                                <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                            </div>
                                            <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($pages_btn_align === 'ars_align_right') ? 'selected' : ''; ?>" id="ars_pages_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_pages_btn_right', 'ars_pages_btn_align');">
                                                <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Hide On Mobile', 'arsocial_lite'); ?> &nbsp;&nbsp;<span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="hidden" name="arsocialshare_mobile_hide" id="arsocialshare_mobile_hide" value="no" />
                                            <div class="arsocialshare_switch arsocial_lite_restrict_shortcode_mobile" id="hide_on_mobile" data-id="arsocialshare_mobile_hide">
                                                <div class="arsocialshare_switch_options">
                                                    <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                    <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                                </div>
                                                <div class="arsocialshare_switch_button"></div>
                                            </div>
                                        </div>
                                    </div>

				   <?php $displays['sidebar']['position'] = isset($displays['sidebar']['position'])?$displays['sidebar']['position']:'';?>
                                    <div class="arsocialshare_option_row" id="ars_lite_sidebar_position" style="display:none;<?php echo $sidebar_hide_show; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="radio" name="arsocialshare_sidebar" value="left" data-on="sidebar_left" <?php checked($displays['sidebar']['position'], 'left'); ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_sidebar_buttons_on_left" />
                                            <input type="radio" name="arsocialshare_sidebar" value="right" data-on="sidebar_right" <?php checked($displays['sidebar']['position'], 'right'); ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_sidebar_buttons_on_right" />
                                            <div class="arsocialshare_inner_option_box arsocialshare_sidebar_position <?php echo ($displays['sidebar']['position'] === 'left') ? "selected" : ""; ?>" id="arsocialshare_sidebar_buttons_on_left_img" data-value="left" onclick="ars_select_radio_img('arsocialshare_sidebar_buttons_on_left', 'arsocialshare_sidebar_position')">
                                                <span class="arsocialshare_inner_option_icon sidebar_left"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                            </div>
                                            <div class="arsocialshare_inner_option_box arsocialshare_sidebar_position <?php echo ($displays['sidebar']['position'] === 'right') ? "selected" : ""; ?>" id="arsocialshare_sidebar_buttons_on_right_img" data-value="right" onclick="ars_select_radio_img('arsocialshare_sidebar_buttons_on_right', 'arsocialshare_sidebar_position')">
                                                <span class="arsocialshare_inner_option_icon sidebar_right"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="arsocialshare_option_row" id='ars_position_top_bottom_bar' style="display:none;<?php echo $top_bottom_hide_show; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_option_input">
                                            <?php
                                            $top_bar_checked = "";
                                            $bottom_bar_checked = "";
                                            $top_bar_checked = isset($displays['top_bottom_bar']['position']) ? $displays['top_bottom_bar']['position'] : 'top_bar';
                                            ?>
                                            <input type="radio" name="arsocialshare_top_bar" value="top_bar" data-on="top_bar" <?php checked($top_bar_checked, 'top_bar'); ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_top" />
                                            <input type="radio" name="arsocialshare_top_bar" value="bottom_bar" <?php checked($top_bar_checked, 'bottom_bar'); ?> data-on="bottom_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_bottom" />
                                            <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($top_bar_checked == 'top_bar' ) ? "selected" : ""; ?>" onclick="ars_select_radio_img('arsocialshare_buttons_on_top', 'arsocialshare_bar_position');" id="arsocialshare_buttons_on_top_img" data-value="top">
                                                <span class="arsocialshare_inner_option_icon top_bar"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                            </div>
                                            <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($top_bar_checked == 'bottom_bar' ) ? "selected" : ""; ?>" onclick="ars_select_radio_img('arsocialshare_buttons_on_bottom', 'arsocialshare_bar_position');" id="arsocialshare_buttons_on_bottom_img" data-value="right">
                                                <span class="arsocialshare_inner_option_icon bottom_bar"></span>
                                                <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option" style="display:none;<?php echo $popup_hide_show; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Popup Height', 'arsocial_lite') ?></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="text" name="arsocialshare_popup_height" id="arsocialshare_popup_height" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['popup_height']) ? $displays['popup']['popup_height'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> px </span>
                                        </div>
                                        <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto height.', 'arsocial_lite'); ?></span>
                                    </div>

                                    <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option" style="display:none;<?php echo $popup_hide_show; ?>">
                                        <div class="arsocialshare_option_label"><?php esc_html_e('Popup Width', 'arsocial_lite') ?></div>
                                        <div class="arsocialshare_option_input">
                                            <input type="text" name="arsocialshare_popup_width" id="arsocialshare_popup_width" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['popup_width']) ? $displays['popup']['popup_width'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> px </span>
                                        </div>
                                        <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto width.', 'arsocial_lite'); ?></span>
                                    </div>

                                </div>

                                <div class="arsocialshare_option_container ars_column ars_no_border">
                                    <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                                    <div class="ars_template_preview_container ars_like_btn_preview" id="ars_top_bottom_popup_preview" style="margin-top:-15px;">
                                        <?php
                                        if ($top_bottom_bar_load_native_btn == 'no') {
                                            $native_skin = 'no';
                                        }
                                        ?>
                                        <div id="arsociallike_top_bottom_preview_wrapper" class="arsocial_lite_like_button arsocial_lite_like_button_wrapper ars_native_<?php echo $native_skin; ?> ars_like_<?php echo $top_bottom_btn_width; ?>">
                                            <div class="arsocialshare_like_wraper arsocial_lite_like_facebook_wraper native_button_parent ars_native_parent_facebook">
                                                <div class="ars_btn_container">
                                                    <div id="arsocial_lite_like_native_facebook_wrapper" class="arsocialshare_like_native_wrapper arsocial_lite_like_native_facebook_wrapper native_button ars_native_facebook">
                                                        <span id="arsocial_lite_like_native_facebook_icon" class="arsocialshare_native_button_icon arsocial_lite_like_native_facebook_icon socialshare-facebook"></span>
                                                        <span id="arsocial_lite_like_native_facebook_label" class="arsocialshare_like_native_label arsocial_lite_like_native_facebook_label">Facebook</span>
                                                    </div>
                                                    <div id="arsocial_lite_like_api_button_facebook" class="arsocialshare_like_button_wrapper arsocial_lite_like_api_button_facebook">
                                                        <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_facebook.png" alt="facebook">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="arsocialshare_title_belt">
                            <div class="arsocialshare_title_belt_number">4</div>
                            <div class="arsocialshare_belt_title"><?php esc_html_e('Custom CSS', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                        </div>

                        <div class="ars_network_list_container selected" style="width:100%;">
                            <div class="arsocialshare_option_container ars_column ars_no_border" style="width:100%; padding-top:0;  ">
                                <div class="arsocialshare_option_row" style="padding-bottom: 0px;">
                                    <div class="arsocialshare_option_label" style="width: 12%; line-height: 25px;"><?php esc_html_e('Enter Custom CSS', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input arsocial_lite_custom_css_shortcode_restricted" style="width: 88%;">
                                        <div class="arshare_opt_checkbox_row">
                                            <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%">
                                                
                                                <textarea name="arsocialshare_like_customcss" id="arsocialshare_like_customcss" class="ars_display_option_input" style="width:700px;height:200px;padding:5px 10px !important;" readonly="readonly"></textarea>
                                            </div>
                                            <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%; margin-top:10px; ">
                                                <span class='arsocial_lite_locker_note' style="width: 100%;">
                                                    <?php echo "eg: .arsociallike_page_button_wrapper { background-color: #d1d1d1; }"; ?>
                                                </span>
                                                <span class='arsocial_lite_locker_note' style="float:left;">
<?php esc_html_e('For CSS Class information related to like buttons,', 'arsocial_lite'); ?>
                                                </span>
                                                <div class="ars_custom_css_info_link arsocial_lite_locker_note" style="float: left;cursor: pointer;"><b>&nbsp;<?php esc_html_e('Please Click Here', 'arsocial_lite'); ?></b></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        <div class="arsocial_lite_share_button_wrapper">
            <div class="ars_save_loader_bottom">&nbsp;
                <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="arsocialshare_save_loader" />
            </div>

            <button type='button' style="margin:15px 0px 0px 15px;" id="save_social_like" class="arsocialshare_save_display_settings"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
            <button value="true" class="arsocialshare_save_display_settings cancel_button bottom_button" id="ars_cancel_button" name="ars_cancel_button" type="button" onclick="location.href = '<?php echo admin_url('admin.php?page=arsocial-lite-shortcode-generator'); ?>'"><?php esc_html_e('Cancel', 'arsocial_lite'); ?></button>
        </div>
    </div>
</form>

<div class="ars_lite_upgrade_modal" id="ars_lite_pro_shortcode_premium_notice" style="display:none;">
    <div class="upgrade_modal_top_belt">
        <div class="logo" style="text-align:center;"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_update_logo.png" /></div>
        <div id="nav_style_close" class="close_button b-close"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_upgrade_close_img.png" /></div>
    </div>
    <div class="upgrade_title"><?php esc_html_e('Upgrade To Premium Version.', 'arsocial_lite'); ?></div>
    <div class="upgrade_message"><?php esc_html_e('To unlock this Feature, Buy Premium Version for $20.00 Only.', 'arsocial_lite'); ?></div>
    <div class="upgrade_modal_btn">
        <button id="pro_upgrade_button"  type="button" class="buy_now_button"><?php esc_html_e('Buy Now', 'arsocial_lite'); ?></button>
        <button id="pro_upgrade_cancel_button"  class="learn_more_button" type="button">Learn More</button>
        <input type="hidden" name="ars_version" id="ars_version" value="<?php global $arsocial_lite_version; echo $arsocial_lite_version;?>" />
        <input type="hidden" name="ars_request_version" id="ars_request_version" value="<?php echo get_bloginfo('version');?>" />
    </div>
</div>