<script type="text/javascript">
    __ARSLikeAjaxURL = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
global $arsocial_lite_like, $arsocial_lite, $wpdb;
$social_options = array();
$displays = array();
$result = get_option('arslite_like_display_settings');
$social_options = maybe_unserialize($result);   
$displays = isset( $social_options['display'] ) ? $social_options['display'] : array();

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
    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="sticky_belt_loader ars_loader" />
    <button type='button' data-id="sticky_belt" id="save_social_like_display_settings" class="arsocialshare_save_display_settings"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
</div>

<form name="arsocialshare_like_display_settings" method="post" id="arsocialshare_like_display_settings" onsubmit="return false;">
    <div class="arsocialshare_main_wrapper">
        <div class="arsocialshare_title_wrapper">

            <label class="arsocialshare_page_title"><?php esc_html_e('Social Like/Follow & Subscribe Configuration', 'arsocial_lite'); ?></label>
            <input type="hidden" name='arslike_ajaxurl' id='arslike_ajaxurl' value='<?php echo admin_url('admin-ajax.php'); ?>' />
            <input type='hidden' name='arsocial_like_action' value="ars_like_global_display_settings" />
            <input type="hidden" id="arsocialshare_like_order" name="arsocialshare_like_order" value='<?php echo json_encode(maybe_unserialize(get_option('arslite_global_like_order'))); ?>' />

        </div>
        <div class="documentation_link" id="documentation_link"><a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>" target="_blank"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?></a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL; ?>/documentation/assets/sysinfo.php');" /></div>

        <div class="arsocialshare_inner_wrapper" style='padding:0;'>
            <div class="arsocialshare_networks_inner_wrapper">

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">1</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Networks', 'arsocial_lite'); ?></div>
                </div>

                <span class="ars_error_message" id="arsocialshare_like_network_error"><?php esc_html_e('Please select atleast one network.', 'arsocial_lite'); ?></span>
                <div class="arsocialshare_inner_container">
                    <div class="ars_network_list_container selected arsocialshare_like_settings arsocialshare_sharing_sortable ars_save_order" id="arsocialshare_like_follow_subscribe">
                        <?php $social_options['facebook']['is_fb_like'] = (isset($social_options['facebook']['is_fb_like']) && $social_options['facebook']['is_fb_like'] ) ? $social_options['facebook']['is_fb_like'] : ''; ?>

                        <div class="arsocialshare_social_box <?php echo $fbClassBtn; ?>" title="<?php echo $fbDisableNotice; ?>" id="facebook" data-listing-order="1">
                            <input type="hidden" name="arsocialshare_like_network[]" value="facebook" class="arsocialshare_like_networks" />
                            <input type='checkbox' onclick="ars_network_active_deactive(this, 'facebook');" class="arsocialshare_like_network_input" name='active_fb_like' id='like_fb_active' value='1' <?php echo $fbLikeChecked; ?> />
                            <label for="like_fb_active"><span></span></label>
                            <div class="arsocialshare_network_icon facebook"></div>
                            <div class="arsocialshare_social_box_title"><?php esc_html_e('Facebook', 'arsocial_lite'); ?>&nbsp;</div>
                            <span class="arsocialshare_move_icon"></span>
                            <div class="arsocialshare_box_container" id="arsocialshare_box_facebook_container" style="<?php echo (isset($social_options['facebook']['is_fb_like']) && !empty($social_options['facebook']['is_fb_like']) ) ? "" : "display:none"; ?>">
                                <div class="arsocialshare_box_row arsocialshare_row_margin">
                                    <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('URL to Like', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_box_input">
                                        <input type='text' class='arsocial_lite_locker_input_control arsocialshare_input_box' id='arsocialshare_fb_like_url' value="<?php echo isset($social_options['facebook']['fb_like_url']) ? $social_options['facebook']['fb_like_url'] : ''; ?>" name='arsocialshare_fb_like_url' style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set an URL of facebook page or website page which user has to like. Leave this field blank to use URL of page where this button will be located.', 'arsocial_lite'); ?>">(?)</span>
                                    </div>
                                </div>

                                <div class="arsocialshare_box_row arsocialshare_row_margin">
                                    <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Button Layout', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_box_input">
                                        <select class="arsocialshare_dropdown" id='arsocialshare_fb_like_button_layout' name='arsocialshare_fb_like_button_layout' style="width:90%;">
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
                                        <input type='text' class='arsocial_lite_locker_input_control arsocialshare_input_box' id='arsocialshare_fb_like_button_width' value="<?php echo isset($social_options['facebook']['fb_button_width']) ? $social_options['facebook']['fb_button_width'] : ''; ?>" name='arsocialshare_fb_like_button_width' style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Work only with standard layout.', 'arsocial_lite'); ?>">(?)</span>
                                    </div>
                                </div>

                                <div class="arsocialshare_box_row arsocialshare_row_margin">
                                    <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Button Action', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_box_input">
                                        <select  class="arsocialshare_dropdown" id='arsocialshare_fb_like_button_action_type' name='arsocialshare_fb_like_button_action_type' style="width:90%;">
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
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Button Colorscheme', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>

                                        <select id='arsocialshare_fb_like_button_colorscheme' name='arsocialshare_fb_like_button_colorscheme' style="width:90%;">
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
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Language', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>

                                        <select id='arsocialshare_fb_like_button_language' name='arsocialshare_fb_like_button_language' style="width:90%;">
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
                                    <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e("Show Friend's Faces", 'arsocial_lite'); ?> </div>
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
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Username', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocial_lite_locker_input_control arsocialshare_input_box' id='arsocialshare_twitter_like_url' value="<?php echo isset($social_options['twitter']['twitter_like_url']) ? $social_options['twitter']['twitter_like_url'] : ''; ?>" name='arsocialshare_twitter_like_url' style="width:90%;" />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Show User Name', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <div class='arsocial_inner_input_wrap arsocialshare_checkbox_margin'>
                                            <input type='checkbox' name='arsocialshare_twitter_show_username' id='arsocialshare_twitter_show_username' value='1' <?php checked(isset($social_options['twitter']['twitter_show_username']) ? $social_options['twitter']['twitter_show_username'] : '', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='arsocialshare_twitter_show_username'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Large Button', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <div class='arsocial_inner_input_wrap arsocialshare_checkbox_margin'>
                                            <input type='checkbox' name='arsocialshare_twitter_large_button' id='arsocialshare_twitter_large_button' value='1' <?php checked(isset($social_options['twitter']['twitter_large_button']) ? $social_options['twitter']['twitter_large_button'] : '', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='arsocialshare_twitter_large_button'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Language', 'arsocial_lite'); ?> </div>
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
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Opt-out of tailoring Twitter', 'arsocial_lite'); ?> </div>
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
                    <!--Disabled Networks List-->
                    <div class="ars_network_list_container selected arsocialshare_like_settings ars_lite_pro_networks" id="arsocialshare_like_follow_subscribe">
                        <div class="ars_lite_pro_networks_info"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Available in premium version', 'arsocial_lite'); ?> )</span></div>
                        <div class="arsocialshare_social_box_disabled" title="" id="linkedin"  data-listing-order="6">
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
                            <input type='checkbox' name='active_vk_like' class="arsocialshare_like_network_input" id='active_vk_like' value='1'  />
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
                        <div class="arsocialshare_box_clear"></div>                        
                        
                    </div>                    
                </div>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">2</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Sitewide Button Setup', 'arsocial_lite'); ?></div>
                </div>

                <div class="arsocialshare_inner_container">
                    <div class="arsocialshare_inner_content_wrapper">

                        <?php
                        $sidebar_checked = "";
                        $topbottombar_checked = "";
                        $popup_checked = "";
                        if (is_array($displays) && array_key_exists('sidebar', $displays)) {
                            $sidebar_checked = "checked='checked'";
                        }
                        if (is_array($displays) && array_key_exists('top_bottom_bar', $displays)) {
                            $topbottombar_checked = "checked='checked'";
                        }
                        if (is_array($displays) && array_key_exists('popup', $displays)) {
                            $popup_checked = "checked='checked'";
                        }
                        ?>
                        <input type="checkbox" name="ars_enable_sidebar" value="sidebar" id="ars_enable_sidebar"  <?php echo $sidebar_checked; ?> class="ars_display_option_input ars_hide_checkbox" />
                        <input type="checkbox" name="arsocialshare_enable_top_bottom_bar" value="top_bottom_bar" <?php echo $topbottombar_checked ?> id="arsocialshare_enable_top_bottom_bar" class="ars_display_option_input ars_hide_checkbox" />
                        <input type="checkbox" name="arsocialshare_enable_popup" value="popup" <?php echo $popup_checked ?> id="arsocialshare_enable_popup" class="ars_display_option_input ars_hide_checkbox" />

                        <div class="arsocialshare_inner_container_main">
                            <div class="arsocialshare_option_box top_bottom_bar_icon <?php echo ($topbottombar_checked !== '' ) ? "selected" : ""; ?>" data-id="arsocialshare_enable_top_bottom_bar" data-opt-id="arsocialshare_top_bottom_bar">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                            <div class="arsocialshare_option_box popup_icon <?php echo ($popup_checked !== '' ) ? "selected" : ""; ?>" data-id="arsocialshare_enable_popup" data-opt-id="arsocialshare_popup">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                        </div>
                        <div class="ars_network_list_container <?php echo ($topbottombar_checked !== '' ) ? "selected" : ""; ?>" id="arsocialshare_top_bottom_bar" style="padding-top:0px !important;padding-bottom:0 !important;">
                            <div class="arsocialshare_option_title">
                                <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/top_bottom_bar_styling_setting.png" /></div>
                                <div class="arsfontsize25"><?php esc_html_e('Top/Bottom Bar Styling Settings', 'arsocial_lite'); ?></div>
                            </div>
                            <div class="arsocialshare_option_container ars_column arsmarginleft10">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select class="arsocialshare_dropdown ars_lite_pro_options" name="ars_top_bottom_skins" id="ars_top_bottom_skins" >
                                            <?php
                                            $top_bottom_bar_skin = isset($displays['top_bottom_bar']['skin']) ? $displays['top_bottom_bar']['skin'] : 'default';
                                            ?>
                                            <option <?php selected($top_bottom_bar_skin, 'default'); ?> value="default"><?php esc_html_e('Flat', 'arsocial_lite'); ?></option>
                                            <!-- <option <?php //selected($top_bottom_bar_skin, 'skin1'); ?> value="skin1"><?php //esc_html_e('Modern', 'arsocial_lite'); ?></option>
                                             -->
                                             <!-- <option <?php //selected($top_bottom_bar_skin, 'skin2'); ?> value="skin2"><?php //esc_html_e('Iconic', 'arsocial_lite'); ?></option> -->
                                            <option <?php selected($top_bottom_bar_skin, 'skin3'); ?> value="skin3"><?php esc_html_e('Classic', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $top_bar_checked = "";
                                        $bottom_bar_checked = "";
                                        if (isset($displays['top_bottom_bar']['top']) && $displays['top_bottom_bar']['top'] == true) {
                                            $top_bar_checked = "checked='checked'";
                                        }
                                        if (isset($displays['top_bottom_bar']['bottom']) && $displays['top_bottom_bar']['bottom'] == true) {
                                            $bottom_bar_checked = "checked='checked'";
                                        }

                                        if ($top_bar_checked == '' && $bottom_bar_checked == '') {
                                            $top_bar_checked = "checked='checked'";
                                        }
                                        ?>
                                        <input type="radio" name="arsocialshare_top_bar" value="1" data-on="top_bar" <?php echo $top_bar_checked; ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_top" />
                                        <input type="radio" name="arsocialshare_bottom_bar" value="1" <?php echo $bottom_bar_checked; ?> data-on="bottom_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_bottom" />

                                        <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($top_bar_checked !== '' ) ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('arsocialshare_buttons_on_top', '', '');" id="arsocialshare_buttons_on_top_img" data-value="top">
                                            <span class="arsocialshare_inner_option_icon top_bar"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($bottom_bar_checked !== '' ) ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('arsocialshare_buttons_on_bottom', '', '');" id="arsocialshare_buttons_on_bottom_img" data-value="right">
                                            <span class="arsocialshare_inner_option_icon bottom_bar"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $display_bar_on = isset($displays['top_bottom_bar']['display_bar']) ? $displays['top_bottom_bar']['display_bar'] : 'onload'; ?>
                                        <select class="arsocialshare_dropdown" name="ars_top_bottom_display_bar" id="arsocialshare_top_bottom_bar_display_on">
                                            <option value="onload" <?php selected($display_bar_on, 'onload'); ?> ><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                            <option value="onscroll" <?php selected($display_bar_on, 'onscroll'); ?>><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row arsocialshare_display_bar_option <?php echo ($display_bar_on === 'onload') ? 'selected' : ''; ?>" id="arsocialshare_on_load_wrapper">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n seconds', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <input type="text" name="ars_top_bottom_bar_onload_time" id="arsocialshare_top_bottom_bar_onload_time" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['onload_time']) ? $displays['top_bottom_bar']['onload_time'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row arsocialshare_display_bar_option <?php echo ($display_bar_on === 'onscroll') ? 'selected' : ''; ?>" id="arsocialshare_on_scroll_wrapper">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n % of scroll', 'arsocial_lite') ?></div>
                                    <div class="arsocialshare_option_input">
                                        <input type="text" name="ars_top_bottom_bar_onscroll_percentage" id="arsocialshare_top_bottom_bar_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['onscroll_percentage']) ? $displays['top_bottom_bar']['onscroll_percentage'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row" id="ars_like_bar_top_y_point">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Start Top bar from Y Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">

                                        <input type="text" name="arslike_bar_y_position" id="arslike_bar_y_position" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['y_point']) ? $displays['top_bottom_bar']['y_point'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px;top:8px;"> px </span>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Load Native Buttons', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $top_bottom_bar_load_native_btn = (isset($displays['top_bottom_bar']['load_native_btn']) && !empty($displays['top_bottom_bar']['load_native_btn'])) ? $displays['top_bottom_bar']['load_native_btn'] : "yes"; ?>
                                        <input type="hidden" name="ars_top_bottom_bar_load_native_btn" id="ars_top_bottom_bar_load_native_btn" value="<?php echo $top_bottom_bar_load_native_btn; ?>" />
                                        <div class="arsocialshare_switch <?php echo ($top_bottom_bar_load_native_btn === 'yes') ? "selected" : ""; ?>" data-id="ars_top_bottom_bar_load_native_btn">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $top_bottom_btn_width = (isset($displays['top_bottom_bar']['btn_width'])) ? $displays['top_bottom_bar']['btn_width'] : "medium"; ?>
                                        <input type="radio" name="ars_top_bottom_bar_btn_width" id="ars_top_bottom_btn_small"  <?php echo checked($top_bottom_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_like_top_bottom_btn_width_input" />
                                        <input type="radio" name="ars_top_bottom_bar_btn_width" id="ars_top_bottom_btn_medium" <?php echo checked($top_bottom_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_like_top_bottom_btn_width_input"  />
                                        <input type="radio" name="ars_top_bottom_bar_btn_width" id="ars_top_bottom_btn_large"  <?php echo checked($top_bottom_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_like_top_bottom_btn_width_input" />

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

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $topbottom_btn_align = isset($displays['top_bottom_bar']['align']) ? $displays['top_bottom_bar']['align'] : 'center'; ?>
                                        <input type="radio" name="ars_top_bottom_bar_align" <?php checked($topbottom_btn_align, 'left'); ?> id="ars_top_bottom_bar_align_left" value="left" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                        <input type="radio" name="ars_top_bottom_bar_align" <?php checked($topbottom_btn_align, 'center'); ?> id="ars_top_bottom_bar_align_medium" value="center" class="ars_hide_checkbox ars_top_bottom_btn_align_input"  />
                                        <input type="radio" name="ars_top_bottom_bar_align" <?php checked($topbottom_btn_align, 'right'); ?> id="ars_top_bottom_bar_align_large" value="right" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />

                                        <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'left') ? 'selected' : ''; ?>" id="ars_top_bottom_bar_align_left_img" data-value="left" onclick="ars_select_radio_img('ars_top_bottom_bar_align_left', 'ars_top_bottom_btn_align  ')">
                                            <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'center') ? 'selected' : ''; ?>" id="ars_top_bottom_bar_align_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_top_bottom_bar_align_medium', 'ars_top_bottom_btn_align  ')">
                                            <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'right') ? 'selected' : ''; ?>" id="ars_top_bottom_bar_align_large_img" data-value="large" onclick="ars_select_radio_img('ars_top_bottom_bar_align_large', 'ars_top_bottom_btn_align ')">
                                            <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <div class="ars_template_preview_container ars_like_btn_preview" id="ars_top_bottom_popup_preview" style="margin-top:-15px;">
                                    <?php
                                    if ($top_bottom_bar_load_native_btn == 'no') {
                                        $top_bottom_bar_skin = 'no';
                                    }
                                    ?>
                                    <div id="arsociallike_top_bottom_preview_wrapper" class="arsocial_lite_like_button arsocial_lite_like_button_wrapper ars_native_<?php echo $top_bottom_bar_skin; ?> ars_like_<?php echo $top_bottom_btn_width; ?>">
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

                            <div class="arsocialshare_option_container" style="margin-top:-6px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_page_excludes_topbottom_bar" id="arsocialshare_page_excludes_topbottom_bar" value="<?php echo isset($displays['top_bottom_bar']['exclude_pages']) ? $displays['top_bottom_bar']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container" style="margin-top:0px;">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>

                            <div class="arsocialshare_clear">&nbsp;</div>
                            <div class="arsocial_lite_locker_row_seperator"></div>
                            <div class="arsocialshare_clear">&nbsp;</div>

                        </div>

                        <div class="ars_network_list_container <?php echo ($popup_checked !== '' ) ? "selected" : ""; ?>" id="arsocialshare_popup" style="padding-top:0px !important;padding-bottom:0 !important;">
                            <div class="arsocialshare_option_title">
                                <?php esc_html_e('Popup Styling Settings', 'arsocial_lite'); ?>
                            </div>
                            <div class="arsocialshare_option_container ars_column">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select name="ars_popup_skins" id="ars_popup_skins" class="arsocialshare_dropdown">
                                            <?php $popup_skin = isset($displays['popup']['skin']) ? $displays['popup']['skin'] : 'default'; ?>
                                            <option <?php selected($popup_skin, 'default'); ?> value="default"><?php esc_html_e('Flat', 'arsocial_lite'); ?></option>
                                            <option <?php selected($popup_skin, 'skin1'); ?> value="skin1"><?php esc_html_e('Modern', 'arsocial_lite'); ?></option>
                                            <option <?php selected($popup_skin, 'skin2'); ?> value="skin2"><?php esc_html_e('Iconic', 'arsocial_lite'); ?></option>
                                            <option <?php selected($popup_skin, 'skin3'); ?> value="skin3"><?php esc_html_e('Classic', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>


                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $display_popup = isset($displays['popup']['display_popup']) ? $displays['popup']['display_popup'] : 'onload';
                                        ?>
                                        <select class="arsocialshare_dropdown" name="ars_display_popup" id="arsocialshare_popup_display_on">
                                            <option <?php selected($display_popup, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                            <option <?php selected($display_popup, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row arsocialshare_display_bar_option <?php echo ($display_popup === 'onload' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_load_wrapper">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n seconds', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <input type="text" name="ars_popup_onload_time" id="ars_popup_onload_time" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['onload_time']) ? $displays['popup']['onload_time'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row arsocialshare_display_bar_option <?php echo ($display_popup === 'onscroll' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_scroll_wrapper">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n % of scroll', 'arsocial_lite') ?></div>
                                    <div class="arsocialshare_option_input">
                                        <input type="text" name="ars_popup_onscroll_percentage" id="ars_popup_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['onscroll_percentage']) ? $displays['popup']['onscroll_percentage'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                    </div>
                                </div>



                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Load Native Buttons', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $popup_load_native_btn = (isset($displays['popup']['load_native_btn']) && !empty($displays['popup']['load_native_btn'])) ? $displays['popup']['load_native_btn'] : "yes"; ?>
                                        <input type="hidden" name="ars_popup_load_native_btn" id="ars_popup_load_native_btn" value="<?php echo $popup_load_native_btn; ?>" />
                                        <div class="arsocialshare_switch <?php echo ($popup_load_native_btn === 'yes') ? "selected" : ""; ?>" data-id="ars_popup_load_native_btn">
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
                                        <?php $popup_btn_width = (isset($displays['popup']['btn_width']) && !empty($displays['popup']['btn_width'])) ? $displays['popup']['btn_width'] : 'medium'; ?>

                                        <input type="radio" name="ars_popup_btn_width"  <?php echo checked($popup_btn_width, 'small'); ?>id="ars_popup_btn_small" value="small" class="ars_hide_checkbox ars_like_popup_btn_width_input" />
                                        <input type="radio" name="ars_popup_btn_width" <?php echo checked($popup_btn_width, 'medium'); ?> id="ars_popup_btn_medium" value="medium" class="ars_hide_checkbox ars_like_popup_btn_width_input"  />
                                        <input type="radio" name="ars_popup_btn_width" <?php echo checked($popup_btn_width, 'large'); ?> id="ars_popup_btn_large" value="large" class="ars_hide_checkbox ars_like_popup_btn_width_input" />

                                        <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ($popup_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_popup_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_popup_btn_small', 'ars_popup_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ($popup_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_popup_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_popup_btn_medium', 'ars_popup_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ($popup_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_popup_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_popup_btn_large', 'ars_popup_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>


                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display close button', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $popup_close_button = isset($displays['popup']['is_close_button']) ? $displays['popup']['is_close_button'] : 'yes'; ?>
                                        <input type="hidden" name="ars_popup_close_button" id="ars_popup_close_button" value="<?php echo $popup_close_button; ?>" />
                                        <div class="arsocialshare_switch <?php echo ($popup_close_button === 'yes') ? 'selected' : ''; ?>" data-id="ars_popup_close_button">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $popup_width = isset($displays['popup']['popup_width']) ? $displays['popup']['popup_width'] : ''; ?>
                                        <input type="text" class="arsocialshare_input_box" name="ars_popup_width" id="ars_popup_width" value="<?php echo $popup_width; ?>" />
                                    </div>
                                    <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto width.', 'arsocial_lite'); ?></span>
                                </div>
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Height', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $popup_height = isset($displays['popup']['popup_height']) ? $displays['popup']['popup_height'] : ''; ?>

                                        <input type="text" class="arsocialshare_input_box" name="ars_popup_height" id="ars_popup_height" value="<?php echo $popup_height; ?>" />
                                    </div>
                                    <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto height.', 'arsocial_lite'); ?></span>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <div class="ars_template_preview_container ars_like_btn_preview" id="ars_like_popup_preview" style="margin-top:-15px;">
                                    <?php
                                    if ($popup_load_native_btn == 'no') {
                                        $popup_skin = 'no';
                                    }
                                    ?>
                                    <div id="arsociallike_popup_preview_wrapper" class="arsocial_lite_like_button arsocial_lite_like_button_wrapper ars_native_<?php echo $popup_skin; ?> ars_like_<?php echo $popup_btn_width; ?>">
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

                            <div class="arsocialshare_option_container" style="margin-top:-30px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_page_excludes_popup" id="arsocialshare_page_excludes_popup" value="<?php echo isset($displays['popup']['exclude_pages']) ? $displays['popup']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">3</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Sectionwise Button Setup', 'arsocial_lite'); ?></div>
                </div>
                <span class="ars_error_message" id="arsocialshare_like_network_position_error"><?php esc_html_e('Please select atleast one position.', 'arsocial_lite'); ?></span>
                <div class="arsocialshare_inner_container">
                    <div class="arsocialshare_inner_content_wrapper">
                        <div class="arsocialshare_inner_container_main">


                            <?php
                            $pages_selected = "";
                            $posts_selected = "";
                            if (is_array($displays) && array_key_exists('page', $displays)) {
                                $pages_selected = "checked='checked'";
                            }
                            if (is_array($displays) && array_key_exists('post', $displays)) {
                                $posts_selected = "checked='checked'";
                            }
                            ?>
                            <input type="checkbox" name="arsocialshare_enable_pages" value="pages" id="arsocialshare_enable_pages" <?php echo $pages_selected; ?> class="ars_display_option_input ars_hide_checkbox" />
                            <input type="checkbox" name="arsocialshare_enable_posts" value="posts" id="arsocialshare_enable_posts" <?php echo $posts_selected; ?> class="ars_display_option_input ars_hide_checkbox" />
                            <div class="arsocialshare_inner_container_main">
                                <div class="arsocialshare_option_box page_icon <?php echo ($pages_selected !== '' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_pages" data-opt-id="arsocialshare_pages" data-mob-page-id="like">
                                    <div class="arsocialshare_option_checkbox"><span></span></div>
                                </div>
                                <div class="arsocialshare_option_box post_icon <?php echo ($posts_selected !== '' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_posts" data-opt-id="arsocialshare_posts" data-mob-page-id="like">
                                    <div class="arsocialshare_option_checkbox"><span></span></div>
                                </div>
                            </div>




                        </div>

                        <div class="ars_network_list_container <?php echo ($pages_selected !== '' ) ? 'selected' : ''; ?>" id="arsocialshare_pages" style="padding-top:0px !important;padding-bottom:0 !important;">
                        <div class="arsocialshare_option_title">
                                <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/page_setting.png" /></div>
                                <div class="arsfontsize25"><?php esc_html_e('Page Settings', 'arsocial_lite'); ?></div>
                         </div>
                            <div class="arsocialshare_option_container ars_column arsmarginleft10">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $page_skin = (isset($displays['page']['skin']) && !empty($displays['page']['skin'])) ? $displays['page']['skin'] : "default"; ?>
                                        <select name="arsociallike_page_skins" id="arsociallike_page_skins" class="arsocialshare_dropdown ars_lite_pro_options">
                                            <option <?php selected($page_skin, 'default'); ?> value="default"><?php esc_html_e('Flat', 'arsocial_lite'); ?></option>
                                            <!-- <option <?php //selected($page_skin, 'skin1'); ?> value="skin1"><?php //esc_html_e('Modern', 'arsocial_lite'); ?></option>
                                            <option <?php //selected($page_skin, 'skin2'); ?> value="skin2"><?php //esc_html_e('Iconic', 'arsocial_lite'); ?></option> -->
                                            <option <?php selected($page_skin, 'skin3'); ?> value="skin3"><?php esc_html_e('Classic', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                </div>


                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">

                                        <?php
                                        $top_bar_checked = "";
                                        $bottom_bar_checked = "";
                                        if (isset($displays['page']['top']) && $displays['page']['top'] == true) {
                                            $top_bar_checked = "checked='checked'";
                                        }
                                        if (isset($displays['page']['bottom']) && $displays['page']['bottom'] == true) {
                                            $bottom_bar_checked = "checked='checked'";
                                        }

                                        if ($top_bar_checked == '' && $bottom_bar_checked == '') {
                                            $top_bar_checked = "checked='checked'";
                                        }
                                        ?>

                                        <input type="radio" name="arsocialshare_page_top" value="1" data-on="pages_top" <?php echo $top_bar_checked; ?> class="arsocialshare_display_networks_pages_on ars_hide_checkbox ars_like_pages_top" id="arsocialshare_pages_buttons_on_top" />
                                        <input type="radio" name="arsocialshare_page_bottom" value="1" data-on="pages_bottom" <?php $bottom_bar_checked; ?> class="arsocialshare_display_networks_pages_on ars_hide_checkbox ars_like_pages_bottom" id="arsocialshare_pages_buttons_on_bottom" />

                                        <div class="arsocialshare_inner_option_box arsocialshare_pages_position <?php echo ($top_bar_checked !== '' ) ? "selected" : ""; ?>" id="arsocialshare_pages_buttons_on_top_img" onclick="ars_select_checkbox_img('arsocialshare_pages_buttons_on_top', 'arsocialshare_enable_pages', 'like');" data-value="ars_top">
                                            <span class="arsocialshare_inner_option_icon pages_top"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_pages_position <?php echo ($bottom_bar_checked !== '' ) ? "selected" : ""; ?>" id="arsocialshare_pages_buttons_on_bottom_img"  onclick="ars_select_checkbox_img('arsocialshare_pages_buttons_on_bottom', 'arsocialshare_enable_pages', 'like');" data-value="ars_bottom" >
                                            <span class="arsocialshare_inner_option_icon pages_bottom"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                        </div>

                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $pages_btn_align = isset($displays['page']['align']) ? $displays['page']['align'] : 'ars_align_center'; ?>

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




                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Load Native Buttons', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">

                                        <?php $page_load_native_btn = (isset($displays['page']['load_native_btn']) && !empty($displays['page']['load_native_btn'])) ? $displays['page']['load_native_btn'] : "yes"; ?>

                                        <input type="hidden" name="ars_page_load_native_btn" id="ars_page_load_native_btn" value="<?php echo $page_load_native_btn; ?>" />
                                        <div class="arsocialshare_switch <?php echo ($page_load_native_btn === 'yes') ? "selected" : ""; ?>" data-id="ars_page_load_native_btn">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $pages_btn_width = isset($displays['page']['btn_width']) ? $displays['page']['btn_width'] : 'medium';
                                        ?>
                                        <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_small" <?php checked($pages_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_like_pages_btn_width_input" />
                                        <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_medium" <?php checked($pages_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_like_pages_btn_width_input"  />
                                        <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_large" <?php checked($pages_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_like_pages_btn_width_input" />
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $pages_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_pages_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_pages_btn_small', 'ars_pages_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $pages_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_pages_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_pages_btn_medium', 'ars_pages_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $pages_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_pages_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_pages_btn_large', 'ars_pages_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                                <div class="ars_template_preview_container ars_like_btn_preview" id="ars_like_pages_preview" style="margin-top:-15px;">
                                    <?php
                                    if ($page_load_native_btn == 'no') {
                                        $page_skin = 'no';
                                    }
                                    ?>
                                    <div id="arsociallike_pages_preview_wrapper" class="arsocial_lite_like_button arsocial_lite_like_button_wrapper ars_native_<?php echo $page_skin; ?> ars_like_<?php echo $pages_btn_width; ?>">
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

                            <div class="arsocialshare_option_container" style="margin-top:20px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="ars_page_excludes" id="arsocialshare_page_excludes" value="<?php echo isset($displays['page']['exclude']) ? $displays['page']['exclude'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>


                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>

                            <div class="arsocialshare_clear">&nbsp;</div>
                            <div class="arsocial_lite_locker_row_seperator"></div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                        </div>


                        <div class="ars_network_list_container <?php echo ($posts_selected !== '' ) ? 'selected' : ''; ?>" id="arsocialshare_posts" style="padding-top:0px !important;padding-bottom:0 !important;">
                            <div class="arsocialshare_option_title">
                            <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/post_setting.png" /></div>
                            <div class="arsfontsize25"><?php esc_html_e('Posts Settings', 'arsocial_lite'); ?></div>
                        </div>
                            <div class="arsocialshare_option_container ars_column arsmarginleft10">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $post_skin = (isset($displays['post']['skin']) && !empty($displays['post']['skin'])) ? $displays['post']['skin'] : "default"; ?>
                                        <select name="ars_post_skin" id="ars_post_skin" class="arsocialshare_dropdown ars_lite_pro_options">
                                            <option <?php selected($post_skin, 'default'); ?> value="default"><?php esc_html_e('Flat', 'arsocial_lite'); ?></option>
                                            <!-- <option <?php //selected($post_skin, 'skin1'); ?> value="skin1"><?php //esc_html_e('Modern', 'arsocial_lite'); ?></option>
                                            <option <?php //selected($post_skin, 'skin2'); ?> value="skin2"><?php //esc_html_e('Iconic', 'arsocial_lite'); ?></option> -->
                                            <option <?php selected($post_skin, 'skin3'); ?> value="skin3"><?php esc_html_e('Classic', 'arsocial_lite'); ?></option>
                                        </select>

                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $post_top_bar_checked = "";
                                        $post_bottom_bar_checked = "";
                                        if (isset($displays['post']['top']) && $displays['post']['top'] == true) {
                                            $post_top_bar_checked = "checked='checked'";
                                        }
                                        if (isset($displays['post']['bottom']) && $displays['post']['bottom'] == true) {
                                            $post_bottom_bar_checked = "checked='checked'";
                                        }

                                        if ($post_top_bar_checked == '' && $post_bottom_bar_checked == '') {
                                            $post_top_bar_checked = "checked='checked'";
                                        }
                                        ?>
                                        <input type="radio" name="ars_post_top" value="1" data-on="posts_top" <?php echo $post_top_bar_checked; ?> class="arsocialshare_display_networks_posts_on ars_hide_checkbox ars_like_posts_top" id="arsocialshare_posts_buttons_on_top" />
                                        <input type="radio" name="ars_post_bottom" value="1" data-on="posts_bottom" <?php echo $post_bottom_bar_checked; ?> class="arsocialshare_display_networks_posts_on ars_hide_checkbox ars_like_posts_bottom" id="arsocialshare_posts_buttons_on_bottom" />

                                        <div class="arsocialshare_inner_option_box arsocialshare_posts_position <?php echo ($post_top_bar_checked !== '' ) ? "selected" : ""; ?>" id="arsocialshare_posts_buttons_on_top_img" data-value="ars_top" onclick="ars_select_checkbox_img('arsocialshare_posts_buttons_on_top', 'arsocialshare_enable_posts', 'like');">
                                            <span class="arsocialshare_inner_option_icon posts_top"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_posts_position <?php echo ($post_bottom_bar_checked !== '' ) ? "selected" : ""; ?>" id="arsocialshare_posts_buttons_on_bottom_img" data-value="ars_bottom" onclick="ars_select_checkbox_img('arsocialshare_posts_buttons_on_bottom', 'arsocialshare_enable_posts', 'like');" >
                                            <span class="arsocialshare_inner_option_icon posts_bottom"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $posts_btn_align = isset($displays['post']['btn_align']) ? $displays['post']['btn_align'] : 'ars_align_center';
                                        ?>
                                        <input type="radio" name="ars_posts_align" id="ars_posts_btn_left" <?php checked($posts_btn_align, 'ars_align_left'); ?> value="ars_align_left" class="ars_hide_checkbox ars_posts_btn_align_input" />
                                        <input type="radio" name="ars_posts_align" id="ars_posts_btn_center" <?php checked($posts_btn_align, 'ars_align_center'); ?> value="ars_align_center" class="ars_hide_checkbox ars_posts_btn_align_input"  />
                                        <input type="radio" name="ars_posts_align" id="ars_posts_btn_right" <?php checked($posts_btn_align, 'ars_align_right'); ?> value="ars_align_right" class="ars_hide_checkbox ars_posts_btn_align_input" />
                                        <div class="arsocialshare_inner_option_box ars_posts_btn_align <?php echo ($posts_btn_align === 'ars_align_left') ? 'selected' : ''; ?>" id="ars_posts_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_posts_btn_left', 'ars_posts_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_posts_btn_align <?php echo ($posts_btn_align === 'ars_align_center') ? 'selected' : ''; ?>" id="ars_posts_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_posts_btn_center', 'ars_posts_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_posts_btn_align <?php echo ($posts_btn_align === 'ars_align_right') ? 'selected' : ''; ?>" id="ars_posts_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_posts_btn_right', 'ars_posts_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Load Native Buttons', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $post_load_native_btn = (isset($displays['post']['load_native_btn']) && !empty($displays['post']['load_native_btn'])) ? $displays['post']['load_native_btn'] : "yes"; ?>
                                        <input type="hidden" name="ars_post_load_native_btn" id="ars_post_load_native_btn" value="<?php echo $post_load_native_btn; ?>" />
                                        <div class="arsocialshare_switch <?php echo ($post_load_native_btn === 'yes') ? "selected" : ""; ?>" data-id="ars_post_load_native_btn">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $posts_btn_width = isset($displays['post']['btn_width']) ? $displays['post']['btn_width'] : 'medium';
                                        ?>
                                        <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_small" <?php checked($posts_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_posts_btn_width_input" />
                                        <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_medium" <?php checked($posts_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_posts_btn_width_input"  />
                                        <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_large" <?php checked($posts_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_posts_btn_width_input" />

                                        <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ( $posts_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_posts_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_posts_btn_small', 'ars_posts_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ( $posts_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_posts_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_posts_btn_medium', 'ars_posts_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ( $posts_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_posts_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_posts_btn_large', 'ars_posts_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Enable Social Icons on Post Excerpt', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $post_excerpt = (isset($displays['post']['post_excerpt']) && !empty($displays['post']['post_excerpt'])) ? $displays['post']['post_excerpt'] : "no"; ?>
                                        <input type="hidden" name="arsocialshare_enable_post_excerpt" id="arsocialshare_enable_post_excerpt" value="<?php echo $post_excerpt; ?>" />
                                        <div class="arsocialshare_switch  <?php echo ($post_excerpt === 'yes') ? "selected" : ""; ?>" data-id="arsocialshare_enable_post_excerpt">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <div class="ars_template_preview_container ars_like_btn_preview" id="ars_like_posts_preview" style="margin-top:-15px;">
                                    <?php
                                    if ($post_load_native_btn == 'no') {
                                        $post_skin = 'no';
                                    }
                                    ?>
                                    <div id="arsociallike_posts_preview_wrapper" class="arsocial_lite_like_button arsocial_lite_like_button_wrapper ars_native_<?php echo $post_skin; ?> ars_like_<?php echo $posts_btn_width; ?>">
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

                            <div class="arsocialshare_option_container" style="margin-top:20px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Posts', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_post_excludes" id="arsocialshare_post_excludes" value="<?php echo isset($displays['post']['exclude_pages']) ? $displays['post']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Posts', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated post id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>



                            <div class="arsocialshare_clear">&nbsp;</div>
                            <div class="arsocial_lite_locker_row_seperator"></div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                        </div>

                    </div>

                </div>

                <?php
                $no = 4;
                if (is_plugin_active('woocommerce/woocommerce.php')) {
                    ?>

                    <div class="arsocialshare_title_belt">
                        <div class="arsocialshare_title_belt_number"><?php echo $no; ?></div>
                        <div class="arsocialshare_belt_title"><?php esc_html_e('Woocommerce Settings', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                    </div>
                    <div class="ars_network_list_container selected arsocial_lite_global_section_restricted" id="arsocialshare_woocommerce" style="padding-top:10px;">
                    <div class="disable_all_click_event">

                        <div id="ars_woocommerce_like" class="selected">

                            <div class="arsocialshare_option_container ars_column">


                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $woocommerce_skin = isset($displays['woocommerce']['skin']) ? $displays['woocommerce']['skin'] : 'default'; ?>
                                        <select name="arsociallike_woocommerce_skins" id="arsociallike_woocommerce_skins" class="arsocialshare_dropdown ars_lite_pro_options">
                                            <option <?php selected($woocommerce_skin, 'default'); ?> value="default"><?php esc_html_e('Flat', 'arsocial_lite'); ?></option>
                                            <!-- <option <?php //selected($woocommerce_skin, 'skin1'); ?> value="skin1"><?php //esc_html_e('Modern', 'arsocial_lite'); ?></option>
                                            <option <?php //selected($woocommerce_skin, 'skin2'); ?> value="skin2"><?php //esc_html_e('Iconic', 'arsocial_lite'); ?></option> -->
                                            <option <?php selected($woocommerce_skin, 'skin3'); ?> value="skin3"><?php esc_html_e('Classic', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label">(More templates are available in pro version)</label>
                                </div>


                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $ars_woocommerce_before_product = '';
                                        $ars_woocommerce_after_product = '';
                                        $ars_woocommerce_after_price = '';
                                        if (isset($displays['woocommerce']['before_product']) && $displays['woocommerce']['before_product'] === 'woocommerce_before_product') {
                                            $ars_woocommerce_before_product = "checked='checked'";
                                        }
                                        if (isset($displays['woocommerce']['after_product']) && $displays['woocommerce']['after_product'] === 'woocommerce_after_product') {
                                            $ars_woocommerce_after_product = "checked='checked'";
                                        }
                                        if (isset($displays['woocommerce']['after_price']) && $displays['woocommerce']['after_price'] === 'woocommerce_after_price') {
                                            $ars_woocommerce_after_price = "checked='checked'";
                                        }
                                        if ($ars_woocommerce_before_product == '' && $ars_woocommerce_after_product == '' && $ars_woocommerce_after_price == '') {
                                            $ars_woocommerce_after_product = "checked='checked'";
                                        }
                                        ?>
                                        <input type="radio" name="arsocialshare_woocommerce_after_price" value="woocommerce_after_price" data-on="woocommerce_after_price" class="arsocialshare_display_networks_on_woocommerce ars_hide_checkbox" <?php echo $ars_woocommerce_after_price; ?> id="arsocialshare_woocommerce_buttons_after_price" />
                                        <input type="radio" name="arsocialshare_woocommerce_after_product" value="woocommerce_after_product" data-on="woocommerce_after_product" class="arsocialshare_display_networks_on_woocommerce ars_hide_checkbox" <?php echo $ars_woocommerce_after_product; ?> id="arsocialshare_woocommerce_buttons_after_product" />
                                        <input type="radio" name="arsocialshare_woocommerce_before_product" value="woocommerce_before_product" <?php echo $ars_woocommerce_before_product; ?> data-on="woocommerce_before_product" class="arsocialshare_display_networks_on_woocommerce ars_hide_checkbox" id="arsocialshare_woocommerce_buttons_before_product" />
                                        <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($ars_woocommerce_after_price != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_after_price_img" data-value="left" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_after_price', '', '');">
                                            <span class="arsocialshare_inner_option_icon woocommerce_after_price"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('After Price', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($ars_woocommerce_after_product != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_after_product_img" data-value="right" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_after_product', '', '');" >
                                            <span class="arsocialshare_inner_option_icon woocommerce_after_product"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('After Product', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($ars_woocommerce_before_product != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_before_product_img" data-value="right" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_before_product', '', '');" >
                                            <span class="arsocialshare_inner_option_icon woocommerce_before_product"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('Before Product', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $woocommerce_btn_align = isset($displays['woocommerce']['btn_align']) ? $displays['woocommerce']['btn_align'] : 'ars_align_center';
                                        ?>
                                        <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_left" <?php checked($woocommerce_btn_align, 'ars_align_left'); ?> value="ars_align_left" class="ars_hide_checkbox ars_woocommerce_btn_align_input" />
                                        <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_center" <?php checked($woocommerce_btn_align, 'ars_align_center'); ?> value="ars_align_center" class="ars_hide_checkbox ars_woocommerce_btn_align_input"  />
                                        <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_right" <?php checked($woocommerce_btn_align, 'ars_align_right'); ?> value="ars_align_right" class="ars_hide_checkbox ars_woocommerce_btn_align_input" />
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ($woocommerce_btn_align === 'ars_align_left') ? 'selected' : ''; ?>" id="ars_woocommerce_align_left_img" data-value="left" onclick="ars_select_radio_img('ars_woocommerce_align_left', 'ars_woocommerce_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ($woocommerce_btn_align === 'ars_align_center') ? 'selected' : ''; ?>" id="ars_woocommerce_align_center_img" onclick="ars_select_radio_img('ars_woocommerce_align_center', 'ars_woocommerce_btn_align');" data-value="medium">
                                            <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ($woocommerce_btn_align === 'ars_align_right') ? 'selected' : ''; ?>" id="ars_woocommerce_align_right_img" onclick="ars_select_radio_img('ars_woocommerce_align_right', 'ars_woocommerce_btn_align');" data-value="large">
                                            <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Load Native Buttons', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">

                                        <?php $woocommerce_load_native_btn = (isset($displays['woocommerce']['load_native_btn']) && !empty($displays['woocommerce']['load_native_btn'])) ? $displays['woocommerce']['load_native_btn'] : "yes"; ?>
                                        <input type="hidden" name="ars_woocommerce_load_native_btn" id="ars_woocommerce_load_native_btn" value="<?php echo $woocommerce_load_native_btn; ?>" />
                                        <div class="arsocialshare_switch <?php echo ($woocommerce_load_native_btn === 'yes') ? "selected" : ""; ?>" data-id="ars_woocommerce_load_native_btn">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $woocommerce_btn_width = isset($displays['woocommerce']['btn_width']) ? $displays['woocommerce']['btn_width'] : 'medium'; ?>
                                        <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_small" <?php checked($woocommerce_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_like_woocommerce_btn_width_input" />
                                        <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_medium" <?php checked($woocommerce_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_like_woocommerce_btn_width_input"  />
                                        <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_large" <?php checked($woocommerce_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_like_woocommerce_btn_width_input" />
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width <?php echo ($woocommerce_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_woocommerce_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_woocommerce_btn_small', 'ars_woocommerce_btn_width');" >
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width <?php echo ($woocommerce_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_woocommerce_btn_medium_img" onclick="ars_select_radio_img('ars_woocommerce_btn_medium', 'ars_woocommerce_btn_width');" data-value="medium">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width <?php echo ($woocommerce_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_woocommerce_btn_large_img" onclick="ars_select_radio_img('ars_woocommerce_btn_large', 'ars_woocommerce_btn_width');" data-value="large">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>






                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <div class="ars_template_preview_container ars_like_btn_preview" id="ars_like_woocommerce_preview" style="margin-top:-15px;">
                                    <?php
                                    if ($woocommerce_load_native_btn == 'no') {
                                        $woocommerce_skin = 'no';
                                    }
                                    ?>
                                    <div id="arsociallike_woocommerce_preview_wrapper" class="arsocial_lite_like_button arsocial_lite_like_button_wrapper ars_native_<?php echo $woocommerce_skin; ?> ars_like_<?php echo $woocommerce_btn_width; ?>">
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

                            <div class="arsocialshare_option_container" style="margin-top:20px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Products', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_woocommerce_excludes" id="arsocialshare_woocommerce_excludes" value="<?php echo isset($displays['woocommerce']['exclude_pages']) ? $displays['woocommerce']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Products', 'arsocial_lite'); ?>:</div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated product id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>

                        </div>
                    </div>
                    </div>
                    <?php
                    $no++;
                }
                ?>

                <!-- 18-02-2016 -->
                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number"><?php
                        echo $no;
                        $no++;
                        ?></div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Mobile Display Settings', 'arsocial_lite'); ?> </div>
                </div>


                <div class="ars_network_list_container selected" style="width:100%;">

                    <div class="arsocialshare_option_container ars_no_border " style="width:100%; padding-top:0;  ">
                        <?php
// mobile
                        $mobile_checked = "";
                        $mobile_options = "display:none;";

                        if (is_array($displays) && array_key_exists('mobile', $displays)) {
                            $mobile_checked = "checked='checked'";
                            $mobile_options = "display:block";
                        }
                        $default_themes_mobile = array(
                            'default' => 'Flat',
                            'skin2' => 'Iconic',
                            'skin3' => 'Classic',
                        );
                        $mobile_skin = isset($displays['mobile']['skin']) ? $displays['mobile']['skin'] : 'default';
                        ?>

                        <div class="arsocialshare_option_row">

                            <div class="arsocialshare_option_label" style="width: 12%;"><?php echo esc_html__('Display on Custom Position', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input" style="width:88%;">
                                <input type="radio" name="arsocialshare_enable_mobile" id="arsocialshare_enable_mobile" class="ars_display_option_input ars_hide_checkbox" value="<?php echo ($mobile_checked != '' ) ? 'mobile' : ''; ?>" <?php echo ($mobile_checked != '') ? "checked='checked'" : ''; ?> />
                                <div class="arsocialshare_switch <?php echo ($mobile_checked != '' && $mobile_checked != 'no') ? "selected" : ""; ?>" data-id="arsocialshare_enable_mobile">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="mobile"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>

                        <div id="ars_mobile_position" style="<?php echo $mobile_options; ?>">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label" style="width:12%;"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input ars_mobile_skin">
                                    <input type='hidden' id='ars_mobile_skins' name = 'ars_mobile_skins' value='<?php echo $mobile_skin; ?>' /> 
                                    <dl style="" data-id="ars_mobile_skins" data-name="ars_mobile_skins" class="arsocialshare_selectbox">
                                        <dt>
                                        <span>
                                            <?php echo $default_themes_mobile[$mobile_skin]; ?>
                                        </span>
                                        <input type="text" class="ars_autocomplete" value="<?php echo $default_themes_mobile[$mobile_skin]; ?>" style="display:none;">
                                        <div style="" class="socialshare-angle-down ars_angle_dropdown"></div>
                                        </dt>
                                        <dd>
                                            <ul style="display:none" data-id='ars_mobile_skins'>
                                                <?php
                                                foreach ($default_themes_mobile as $key => $value) {
                                                    ?>
                                                    <li id='<?php echo $key ?>' label='<?php echo $value; ?>' data-value='<?php echo $key; ?>'  class="ars_mobile_template ars_like_dropdown">
                                                        <img src='<?php echo ARSOCIAL_LITE_IMAGES_URL . '/' . $key . '_like_dropdown_icon.png' ?>' />
                                                        <div style="margin-top: 6px;">
                                                            <?php echo $value; ?>
                                                        </div>
                                                    </li>

                                                <?php } ?>
                                            </ul>
                                        </dd>
                                    </dl>    
                                </div>
                            </div>

                            <div class="arsocialshare_option_row"  >
                                <div class="arsocialshare_option_label" style="width: 12%; line-height:50px;" ><?php esc_html_e('Position Type', 'arsocial_lite'); ?> </div>
                                <div class="arsocialshare_option_input" style="width: 88%;">
                                    <div class="arsocialshare_position_image arsocialshare_display_on_mobile  <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_footer_icons') ? "selected" : ""; ?>" id="arsocialshare_share_button_bar_footer_icons_img" onclick="ars_select_radio_img('arsocialshare_share_button_bar_footer_icons', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_footer_icons'>
                                        <input type="radio" name="arsocialshare_display_mobile"  value="share_footer_icons" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_button_bar_footer_icons" />
                                        <span class="arsocialshare_position_image_icon_footer_icons"></span>
                                        <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Footer Icons', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_position_image arsocialshare_display_on_mobile" id="arsocialshare_share_button_bar_type_img" onclick="ars_select_radio_img('arsocialshare_share_button_bar_type', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_footer_bar'>
                                        <input type="radio" name="arsocialshare_display_mobile"  value="share_button_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_button_bar_type" />
                                        <span class="arsocialshare_like_position_image_icon_footer_bar"></span>
                                        <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Footer Bar', 'arsocial_lite'); ?> </label>
                                        <span class='ars_lite_pro_version_info_label'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                                    </div>
                                    <div class="arsocialshare_position_image arsocialshare_display_on_mobile" id="arsocialshare_share_left_point_type_img" onclick="ars_select_radio_img('arsocialshare_share_left_point_type', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_side_buttons'>
                                        <input type="radio" name="arsocialshare_display_mobile" value="share_point" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_left_point_type" />
                                        <span class="arsocialshare_like_position_image_icon_left_point"></span>
                                        <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Side Buttons', 'arsocial_lite'); ?> </label>
                                        <span class='ars_lite_pro_version_info_label'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                                    </div>

                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_footer_icons') ? 'block' : 'none'; ?>" id='arsshare_mobile_footer_icons'>
                                <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?> </div>
                                <?php
                                $mobile_more_btn_style = (isset($displays['mobile']['more_button_style']) && !empty($displays['mobile']['more_button_style'])) ? $displays['mobile']['more_button_style'] : "plus_icon";
                                ?>

                                <div class="arsocialshare_option_input ars_mobile_skin">
                                    <select name="arsocialshare_mobile_more_button_style" id="arsocialshare_mobile_more_button_style" class="arsocialshare_dropdown">
                                        <option value="plus_icon" <?php selected($mobile_more_btn_style, 'plus_icon'); ?>><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option value="dot_icon" <?php selected($mobile_more_btn_style, 'dot_icon'); ?>><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_button_bar') ? 'block' : 'none'; ?>" id='arsshare_mobile_footer_bar'>
                                <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('Footer Bar Label', 'arsocial_lite'); ?> </div>
                                <div class="arsocialshare_option_input ars_mobile_skin">
                                    <?php $mobile_more_btn_after = 'Like'; ?>
                                    <input type="text" name="arsocialshare_mobile_bottom_bar_label" class="arsocialshare_input_box" id="arsocialshare_mobile_bottom_bar_label" value="<?php echo $mobile_more_btn_after; ?>" readonly="readonly" />
                                </div>
                            </div>
                            <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_point') ? 'block' : 'none'; ?>" id='arsshare_mobile_side_buttons'>
                                <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('Select Button Position', 'arsocial_lite'); ?> </div>
                                <div class="arsocialshare_option_input ars_mobile_skin">
                                    <select name="arsocialshare_mobile_more_button_position" id="arsocialshare_mobile_more_button_position" class="arsocialshare_dropdown">
                                        <option value="left" <?php selected(isset($mobile_bar_position)?$mobile_bar_position:'', 'left'); ?>><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                        <option value="right" <?php selected(isset($mobile_bar_position)?$mobile_bar_position:'', 'right'); ?>><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="arsocialshare_option_row ars_litemargintop30">
                            <div class="arsocialshare_option_label" style="width: 12%; line-height:40px;"><?php esc_html_e('Hide on Mobile', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input" style="width: 88%; line-height:30px;">
                                <div class="arshare_opt_checkbox_row">
                                    <div class="arsocialshare_opt_inner_input_wrapper">
                                        <input type="checkbox" name="arsocialshare_mobile_hide_top" value="1" id="arsocialshare_mobile_hide_top" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_top']) ? $displays['hide_mobile']['enable_mobile_hide_top'] : '', 1); ?> data-id="enable_mobile_hide_top" />
                                        <label for="arsocialshare_mobile_hide_top" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Top Position', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_opt_inner_input_wrapper">
                                        <input type="checkbox" name="arsocialshare_mobile_hide_bottom" value="1" id="arsocialshare_mobile_hide_bottom" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_bottom']) ? $displays['hide_mobile']['enable_mobile_hide_bottom'] : '', 1); ?> data-id="enable_mobile_hide_bottom" />
                                        <label for="arsocialshare_mobile_hide_bottom" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Bottom Position', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                                <div class="arshare_opt_checkbox_row" style="line-height:normal;">
                                    <div class="arsocialshare_opt_inner_input_wrapper">
                                        <input type="checkbox" name="enable_mobile_hide_top_bottom_bar" value="1" id="enable_mobile_hide_top_bottom_bar" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_top_bottom_bar']) ? $displays['hide_mobile']['enable_mobile_hide_top_bottom_bar'] : '', 1); ?> data-id="enable_mobile_hide_top_bottom_bar" />
                                        <label for="enable_mobile_hide_top_bottom_bar" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Top/Bottom Bar', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_opt_inner_input_wrapper arsocial_lite_global_section_restricted">
                                        <div class="disable_all_click_event">
                                        <input type="checkbox" name="arsocialshare_mobile_hide_onload" value="1" id="arsocialshare_mobile_hide_onload" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_onload']) ? $displays['hide_mobile']['enable_mobile_hide_onload'] : '', 1); ?> data-id="enable_mobile_hide_onload" />
                                        <label for="arsocialshare_mobile_hide_onload" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Popup', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 18-02-2016 -->

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number"><?php
                        echo $no;
                        $no++;
                        ?></div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Custom CSS', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                </div>


                <div class="ars_network_list_container selected" style="width:100%;">
                    <div class="arsocialshare_option_container ars_column ars_no_border" style="width:100%; padding-top:0;  ">
                        <div class="arsocialshare_option_row" style="padding-bottom: 0px;">
                            <div class="arsocialshare_option_label" style="width: 12%; line-height: 25px;"><?php esc_html_e('Enter Custom CSS', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input arsocial_lite_custom_css_global_restricted" style="width: 88%;">
                                <div class="arshare_opt_checkbox_row">
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%">
                                        <textarea name="arsocialshare_like_customcss" id="arsocialshare_like_customcss" class="ars_display_option_input" style="width:700px;height:200px;padding:5px 10px !important;"></textarea>
                                    </div>
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%; margin-top:10px; ">
                                        <span class='arsocial_lite_locker_note' style="width: 100%;">
                                            <?php echo "eg: .arsocial_lite_like_top_button  { background-color: #d1d1d1; }"; ?>
                                        </span>
                                        <span class='arsocial_lite_locker_note' style="float:left;">
                                            <?php esc_html_e('For CSS Class information related to Like Buttons,', 'arsocial_lite'); ?>
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
        <div class="arsocial_lite_share_button_wrapper">
            <button value="true" style="margin:15px 0px 0px 60px;" class="arsocialshare_save_display_settings" id="save_social_like_display_settings" name="save_social_like_display_settings" type="button"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
            <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="arsocialshare_save_loader" />
        </div>
    </div>
</form>
<div class="ars_lite_upgrade_modal" id="ars_lite_pro_global_premium_notice" style="display:none;">
    <div class="upgrade_modal_top_belt">
        <div class="logo" style="text-align:center;"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_update_logo.png" /></div>
        <div id="nav_style_close" class="close_button b-close"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_upgrade_close_img.png" /></div>
    </div>
    <div class="upgrade_title"><?php esc_html_e('Upgrade To Premium Version.', 'arsocial_lite'); ?></div>
    <div class="upgrade_message"><?php esc_html_e('To unlock this Feature, Buy Premium Version for $20.00 Only.', 'arsocial_lite'); ?></div>
    <div class="upgrade_modal_btn">
        <button id="pro_upgrade_button"  type="button" class="buy_now_button"><?php esc_html_e('Buy Now', 'arsocial_lite'); ?></button>
        <button id="pro_upgrade_cancel_button"  class="learn_more_button" type="button"><?php esc_html_e('Learn More', 'arsocial_lite'); ?></button>
         <input type="hidden" name="ars_version" id="ars_version" value="<?php global $arsocial_lite_version; echo $arsocial_lite_version;?>" />
        <input type="hidden" name="ars_request_version" id="ars_request_version" value="<?php echo get_bloginfo('version');?>" />
    </div>
</div>