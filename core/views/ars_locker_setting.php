<?php
global $wpdb, $arsocial_lite,$arsocial_lite_locker;
$arsocial_locker_themes = $arsocial_lite->ARSocialShareLockerThemes();

$values = maybe_unserialize(get_option('arslite_locker_display_settings'));
$locker_name = isset($values['locker_title']) ? $values['locker_title'] : esc_html__('This Content is locked!', 'arsocial_lite');
$locker_content = (isset($values['locker_content'])) ? $values['locker_content'] : esc_html__("Like/Share on Facebook and Get your content", 'arsocial_lite');

$locker_type = isset($values['locker_type']) && $values['locker_type'] != '' ? $values['locker_type'] : 'social_like_share';
$social_options = isset( $values['social'] ) ? $values['social'] : array();
$displays = isset( $values['display'] ) ? $values['display'] : array();

$batch_lock = isset($values['batch_lock']) ? $values['batch_lock'] : array('is_element_lock' => '', 'is_paragraph_lock' => '');
$locker_template = isset($displays['locker_template']) ? $displays['locker_template'] : 'default';
$overlap_mode = isset($displays['overlap_mode']) ? $displays['overlap_mode'] : 'full';

$default_color = $arsocial_lite_locker->ars_locker_default_color();

$bg_color = isset($displays['arsocialshare_locker_bgcolor']) ? $displays['arsocialshare_locker_bgcolor'] : $default_color[$locker_template]['bg_color'];
$text_color = isset($displays['arsocialshare_locker_textcolor']) ? $displays['arsocialshare_locker_textcolor'] : $default_color[$locker_template]['text_color'];

$enableNetworks = $arsocial_lite->ars_get_enable_networks();
$fbClassBtn = $fbDisableNotice = $twClassBtn = $twDisableNotice = $liClassBtn = $liDisableNotice = "";
$fbSigninChecked = checked(isset($social_options['is_fb_signin']) ? $social_options['is_fb_signin'] : "", 1, false);
$fbLikeChecked = checked(isset($social_options['is_fb_like']) ? $social_options['is_fb_like'] : "", 1, false);
$fbShareChecked = checked(isset($social_options['is_fb_share']) ? $social_options['is_fb_share'] : "", 1, false);
if (!in_array('facebook', $enableNetworks)) {
    $fbClassBtn = "ars_disable arsocialshare_disable_tooltip";
    $fbDisableNotice = esc_html__('Please configure facebook api settings in general settings', 'arsocial_lite');
    $social_options['is_fb_signin'] = 0;
    $social_options['is_fb_like'] = 0;
    $social_options['is_fb_share'] = 0;
    $fbSigninChecked = $fbLikeChecked = $fbShareChecked = 'disabled="disabled"';
}
$twSigninChecked = checked(isset($social_options['is_twitter_signin']) ? $social_options['is_twitter_signin'] : "", 1, false);
$twLikeChecked = checked(isset($social_options['is_tw_locker']) ? $social_options['is_tw_locker'] : "", 1, false);
$twFollowChecked = checked(isset($social_options['is_tw_follow']) ? $social_options['is_tw_follow'] : "", 1, false);
if (!in_array('twitter', $enableNetworks)) {
    $twClassBtn = "ars_disable arsocialshare_disable_tooltip";
    $twDisableNotice = esc_html__('Please configure twitter api settings in general settings', 'arsocial_lite');
    $social_options['is_twitter_signin'] = 0;
    $social_options['is_tw_locker'] = 0;
    $social_options['is_tw_follow'] = 0;
    $twSigninChecked = $twLikeChecked = $twFollowChecked = 'disabled="disabled"';
}
$liSigninChecked = checked(isset($social_options['is_linkedin_signin']) ? $social_options['is_linkedin_signin'] : "", 1, false);
$liShareChecked = checked(isset($social_options['is_linkedin_share']) ? $social_options['is_linkedin_share'] : "", 1, false);
if (!in_array('linkedin', $enableNetworks)) {
    $liClassBtn = "ars_disable arsocialshare_disable_tooltip";
    $liDisableNotice = esc_html__('Please configure linkedin api settings in general settings', 'arsocial_lite');
    $social_options['is_linkedin_signin'] = 0;
    $social_options['is_linkedin_share'] = 0;
    $liSigninChecked = $liShareChecked = 'disabled="disabled"';
}
?>
<script type="text/javascript">
    jQuery(document).ready(function (e) {
        ars_set_blur_effect('ars_locked_blurring', true);
    });
    function arsocial_lite_locker_check_special_page() {
        var ars_locker_special_page;
        ars_locker_special_page = '<?php echo json_encode($arsocial_lite->arsocialshare_wp_special_pages()); ?>';
        return ars_locker_special_page;
    }

    __ARSLockerAjaxURL = '<?php echo admin_url('admin-ajax.php'); ?>';

</script>

<input type="hidden" id="arf_default_color" value='<?php echo json_encode($arsocial_lite_locker->ars_locker_default_color()); ?>' />
<div class="success-message" id="success-message"></div>

<div class="ars_sticky_top_belt" id="ars_sticky_top_belt">
    <div class="arsocialshare_title_wrapper" style="margin-left: 13%;margin-top: 3%;">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Locker Configuration', 'arsocial_lite'); ?></label>
    </div>
    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="sticky_belt_loader ars_loader" />&nbsp;<button type="button" name="update_arsocial_lite_locker_display_settings" id="update_arsocial_lite_locker_display_settings" data-id="sticky_belt" class="arsocialshare_save_display_settings float_right" value="true"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
</div>

<input type="hidden" id="arsocial_lite_locker_ajaxurl" name="arsocial_lite_locker_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>" />

<form name="arsocial_lite_locker_display_settings" id="arsocial_lite_locker_display_settings">
    <div class="arsocialshare_main_wrapper">
        <div class="arsocialshare_title_wrapper">
            <label class="arsocialshare_page_title"><?php esc_html_e('Social Locker Configuration', 'arsocial_lite'); ?></label>
        </div>
        <div class="documentation_link" id="documentation_link">
            <a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>" target="_blank">
                <span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?>
            </a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL; ?>/documentation/assets/sysinfo.php');" />
        </div>

        <div class="arsocialshare_inner_wrapper" style="padding:0;">
            <div class="arsocialshare_networks_inner_wrapper">
                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">1</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e(' Select Locker Type', 'arsocial_lite'); ?></div>
                </div>
                <div class="ars_network_list_container selected" style="width:100%;">
                    <div class="arsocialshare_option_container ars_column ars_no_border" style="width:100%;  padding-top:0;">
                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label" style="width: 12%; line-height: 25px;"><?php esc_html_e('Locker Type', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input" style="width: 88%;">
                                <div class="arshare_opt_checkbox_row">
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%">
                                        <input type="radio" name="locker_type" class="ars_hide_checkbox ars_locker_type_radio_locker_type " value="social_like_share" id="social_like_share" checked="checked" <?php // checked($locker_type, 'social_like_share'); ?> />
                                        <label for="social_like_share" style="width:auto;" class="arsocialshare_inner_option_label"><span></span><?php esc_html_e('Social Like & Share', 'arsocial_lite'); ?></label>
                                        <span class="arsocialshare_halp_text" style="margin-left:30px;">
                                            <?php esc_html_e('Asks users to "Unlock with a like" or share to unlock content.', 'arsocial_lite'); ?><br/>
                                            <?php esc_html_e('Perfect way to get more followers, attract social traffic and improve some social metrics.', 'arsocial_lite'); ?>
                                        </span>
                                    </div>

                                    <div class="arsocialshare_opt_inner_input_wrapper arsocial_lite_restricted" style="width: 100%; margin-top:10px; ">
                                        <input type="radio" name="locker_type" class="ars_hide_checkbox ars_locker_type_radio_locker_type" value="social_signin" <?php // checked($locker_type, 'social_signin'); ?> id="social_sing_in" />
                                        <label for="social_sing_in" style="width:auto;" class="arsocialshare_inner_option_label"><span></span><?php esc_html_e('Social Sign In', 'arsocial_lite'); ?></label>&nbsp;&nbsp;<span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                                        <span class="arsocialshare_halp_text" style="margin:0 0 0 30px;">
                                            <?php esc_html_e('Locks the content until the user signs in through social networks.', 'arsocial_lite'); ?><br/><br/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        $Paragraph_checked = '';
                        if (isset($batch_lock['is_paragraph_lock']) && $batch_lock['is_paragraph_lock'] == 'yes') {
                            $Paragraph_checked = "checked='checked'";
                        }
                        ?>
                        <div class="arsocialshare_option_row" >
                            <div class="arsocialshare_option_label" style="width: 12%; margin-top:5px;"><?php esc_html_e('Paragraph wise lock', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input" style="width: 88%;">

                                <input type="radio" name="arsocialshare_display_lock_paragraph" id="arsocialshare_lock_paragraph" class="ars_display_option_input ars_hide_checkbox" value="<?php echo ($Paragraph_checked !== '' ) ? 'yes' : ''; ?>" <?php echo ($Paragraph_checked !== '') ? "checked='checked'" : ''; ?> />
                                <div class="arsocialshare_switch <?php echo ($Paragraph_checked !== '' && $Paragraph_checked !== 'no') ? "selected" : ""; ?>" data-id="arsocialshare_lock_paragraph">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>    

                        <div class="arsocialshare_option_row arsocialshare_lock_paragraph_section" style="<?php echo ($Paragraph_checked !== '') ? "" : "display:none;"; ?>">
                            <div class="arsocialshare_option_label" style="width: 12%; margin-top:5px; " ><?php esc_html_e('Lock after paragraph', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input" id="arsocialshare_lock_paragraph_section" style="width: 88%;">
                                <?php 
                                     $skip_paragraph = isset($batch_lock['skip_paragraph']) ? $batch_lock['skip_paragraph'] : ''; ?>
                                <select style="" name="arsocialshare_paragraph_lock_number" id="arsocialshare_paragraph_lock_number" class="arsocialshare_dropdown">
                                    <?php for ($lx = 1; $lx <= 20; $lx++) { ?>
                                        <option <?php selected($skip_paragraph, $lx); ?> ><?php echo $lx; ?></option>
                                    <?php } ?>
                                </select>
                                &nbsp;<span style="float: left; line-height:30px; margin-left: 5px !important;" class="arsocialshare_tooltip" title="<?php esc_html_e('Enter number of paragraphs to skip. e.g. if you enter 3, three paragraphs will be visible, others will be locked.', 'arsocial_lite'); ?>">(?)</span>

                            </div>
                        </div>    
                        
                        <div class="arsocialshare_option_row" >
                            <div class="arsocialshare_option_label" style="width: 12%; margin-top:5px;"><?php esc_html_e('Css class wise lock', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input" style="width: 88%; ">
                                <input type="radio" name="arsocialshare_display_lock_element" id="arsocialshare_lock_css" class="ars_display_option_input ars_hide_checkbox" value="" />

                                <div class="arsocialshare_switch arsocial_lite_restricted_switch" data-id="arsocialshare_lock_css">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                                <div class="ars_lite_restricted_switch"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                            </div>
                        </div>   
                        
                        <?php

                        $args = array(
                            'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false, 'type' => 'post'
                        );
                        $categories = array();
                        $terms = get_categories($args);
                        if (!empty($terms)) {
                            $n = 0;
                            foreach ($terms as $key => $term) {
                                $categories[$n]['value'] = $term->term_id;
                                $categories[$n]['name'] = $term->name;
                                $n++;
                            }
                        }
                        ?>
                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label" style="width: 12%; margin-top:5px;"><?php esc_html_e('Category wise lock', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input" style="width: 88%; ">
<!--                                <input type="radio" name="arsocialshare_display_lock_category" id="arsocialshare_lock_category" class="ars_display_option_input ars_hide_checkbox" value="<?php echo (isset($category_locker_checked) && $category_locker_checked !== '' ) ? 'yes' : ''; ?>" <?php echo (isset($category_locker_checked) && $category_locker_checked !== '') ? "checked='checked'" : ''; ?> />-->
                                <input type="radio" name="arsocialshare_display_lock_category" id="arsocialshare_lock_category" class="ars_display_option_input ars_hide_checkbox" value="" />
                                <!--<div class="arsocialshare_switch <?php // echo ($category_locker_checked !== '' && $category_locker_checked !== 'no') ? "selected" : ""; ?>" data-id="arsocialshare_lock_category">-->
                                <div class="arsocialshare_switch arsocial_lite_restricted_switch" data-id="arsocialshare_lock_category">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                                <div class="ars_lite_restricted_switch"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label" style="width: 12%; margin-top:5px;"><?php esc_html_e('Tag wise lock', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input" style="width: 88%; ">
    <!--<input type="radio" name="arsocialshare_display_lock_tag" id="arsocialshare_lock_tag" class="ars_display_option_input ars_hide_checkbox" value="<?php // echo ($tag_locker_checked !== '' ) ? 'yes' : ''; ?>" <?php echo (isset($tag_locker_checked) && $tag_locker_checked !== '') ? "checked='checked'" : ''; ?> />-->
                                <input type="radio" name="arsocialshare_display_lock_tag" id="arsocialshare_lock_tag" class="ars_display_option_input ars_hide_checkbox" value=""/>
                                <!--<div class="arsocialshare_switch <?php // echo ($tag_locker_checked !== '' && $tag_locker_checked !== 'no') ? "selected" : ""; ?>" data-id="arsocialshare_lock_tag">-->
                                <div class="arsocialshare_switch arsocial_lite_restricted_switch" data-id="arsocialshare_lock_tag">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                                <div class="ars_lite_restricted_switch"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                            </div>
                        </div>
                        <!--<div class="arsocialshare_option_row arsocialshare_lock_tag_section" style="padding-bottom: 0px; <?php // echo ($tag_locker_checked !== '') ? "" : "display:none;"; ?>" >-->
<!--                        <div class="arsocialshare_option_row arsocialshare_lock_tag_section" style="padding-bottom: 0px; display:none;" >
                            <div class="arsocialshare_option_label" style="width: 12%; margin-top:10px;"><?php esc_html_e('Enter Tag names', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input " id="arsocialshare_lock_css_section" style="width: 88%; ">
                                <input style="width:540px;" type="text" name="arsocialshare_element_lock_tags" class="arsocialshare_input_box" id="arsocialshare_element_lock_tags" value="<?php // echo isset($batch_lock['tags']) ? $batch_lock['tags'] : ''; ?>" />
                                <input style="width:540px;" type="text" name="arsocialshare_element_lock_tags" class="arsocialshare_input_box" id="arsocialshare_element_lock_tags" value="" />
                                <span class="arsocialshare_tooltip" style="float: left; line-height:30px; margin-left: 5px !important;"  title="<?php esc_html_e('Enter tag name separated by comma(,) which you have applied on element to lock content.', 'arsocial_lite'); ?>">(?)</span>
                                <span class="arsocialshare_halp_text"><?php esc_html_e("Please Enter Comma Separated Tag Names", 'arsocial_lite'); ?></span>
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">2</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Networks', 'arsocial_lite'); ?></div>
                </div>
                <?php
                $display_share_locker = "";
                $display_login_locker = "";
                $display_no_locker = "";
                if ($locker_type === 'social_like_share') {
                    $display_share_locker = "display:block;";
                    $display_login_locker = "display:none;";
                    $display_no_locker = "display:none;";
                } else if ($locker_type === 'social_signin') {
                    $display_share_locker = "display:none;";
                    $display_login_locker = "display:block;";
                    $display_no_locker = "display:none;";
                } else {
                    $display_share_locker = "display:none;";
                    $display_login_locker = "display:none;";
                    $display_no_locker = "";
                }
                ?>

                <span class="ars_error_message" id="arsocial_lite_locker_network_error"><?php esc_html_e('Please select atleast one network.', 'arsocial_lite'); ?></span>
                <div id="arsocialshare_like_share_locker_options" style="float: left; <?php echo $display_share_locker; ?>">
                    <div class="arsocial_lite_locker_content selected">
                        <div class="arsocial_lite_locker_inner_wrapper">
                            <div class="arsocialshare_inner_container arsocialshare_fancounter_settings arsocialshare_sharing_sortable ars_save_order" id="arsocialshare_global_share_locker">
                                <div class="arsocialshare_social_box <?php echo $fbClassBtn; ?>" title="<?php echo $fbDisableNotice; ?>" id="facebook_like" data-listing-order="1">
                                    <input type="hidden" name="arsocial_lite_locker_share_networks[]" class="arsocial_lite_locker_share_networks" value="facebook_like" />
                                    <input type='checkbox' name='active_fb_locker' class="arsocial_lite_locker_share_like_network_input" onclick="ars_locker_network_active_deactive(this, 'facebook_like')" id='locker_fb_active' value='1' <?php echo $fbLikeChecked; ?> />
                                    <label for="locker_fb_active"><span></span></label>
                                    <div class="arsocialshare_network_icon facebook"></div>
                                    <div class="arsocialshare_social_box_title"><?php esc_html_e('Facebook Like', 'arsocial_lite'); ?></div>
                                    <!--<span class="arsocialshare_move_icon"></span>-->
                                    <div class="arsocialshare_box_container" id="arsocialshare_box_facebook_like_container" style="<?php echo (isset($social_options['is_fb_like']) && !empty($social_options['is_fb_like'])) ? "" : "display: none;"; ?>">
                                        <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                            <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('URL to Like', 'arsocial_lite'); ?></div>
                                            <div class='arsocialshare_box_input'>
                                                <input type='text' class='arsocial_lite_locker_input_control arsocialshare_input_box' id='arsocialshare_fb_like_url' value="<?php echo isset($social_options['fb_like_url']) ? $social_options['fb_like_url'] : ''; ?>" name='arsocialshare_fb_like_url' style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set an URL of facebook page or website page which user has to like in order to unlock your content. Leave this field blank to use URL of page where this locker will be located.', 'arsocial_lite'); ?>" data-title="<?php esc_html_e('Set an URL of facebook page or website page which user has to like in order to unlock your content. Leave this field blank to use URL of page where this locker will be located.', 'arsocial_lite'); ?>">(?)</span>
                                            </div>
                                        </div>

                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <div class='arsocial_inner_input_wrap arsocialshare_checkbox_margin'>
                                                    <input type='checkbox' name='is_fb_counter' id='active_fb_counter' value='1' <?php checked(isset($social_options['is_fb_counter'])?$social_options['is_fb_counter']:'', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='active_fb_counter'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_social_box <?php echo $twClassBtn; ?>" title="<?php echo $twDisableNotice; ?>" id="twitter_tweet" data-listing-order="2">
                                    <input type="hidden" name="arsocial_lite_locker_share_networks[]" class="arsocial_lite_locker_share_networks" value="twitter_tweet" />
                                    <input type='checkbox' name='active_tw_locker' class="arsocial_lite_locker_share_like_network_input" onclick="ars_locker_network_active_deactive(this, 'twitter_tweet')" id='locker_tw_active' value='1' <?php echo $twLikeChecked; ?> />
                                    <label for="locker_tw_active"><span></span></label>
                                    <div class="arsocialshare_network_icon twitter"></div>
                                    <div class="arsocialshare_social_box_title">
                                        <?php esc_html_e('Twitter Tweet', 'arsocial_lite'); ?>
                                    </div>
                                    <!--<span class="arsocialshare_move_icon"></span>-->
                                    <div class="arsocialshare_box_container" id="arsocialshare_box_twitter_tweet_container" style="<?php echo (isset($social_options['is_tw_locker']) && !empty($social_options['is_tw_locker'])) ? "" : "display: none;"; ?>">
                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('URL to Tweet', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <input type='text' class='arsocial_lite_locker_input_control arsocialshare_input_box' id='arsocialshare_tw_tweet_url' value="<?php echo isset($social_options['tweet_url']) ? @$social_options['tweet_url'] : ''; ?>" name='arsocialshare_tw_tweet_url' style="width:90%;" />&nbsp<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set an URL which user has to tweet in order to unlock your content. Leave this field blank to use URL of page where this locker will be located.', 'arsocial_lite'); ?>" data-title="<?php esc_html_e('Set an URL which user has to tweet in order to unlock your content. Leave this field blank to use URL of page where this locker will be located.', 'arsocial_lite'); ?>">(?)</span>
                                            </div>
                                        </div>

                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin" style="vertical-align:top;"><?php esc_html_e('Tweet', 'arsocial_lite') ?></div>
                                            <div class="arsocialshare_box_input">
                                                <textarea class="arsocialshare_textarea_box"  name="arsocial_locker_tweet_text" id="arsociallocker_tweet_text" style="width:90%;"><?php echo isset($social_options['tweet_txt']) ? $social_options['tweet_txt'] : ''; ?></textarea>&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Type a message to tweet. Leave this field empty to use default tweet (page title + URL).', 'arsocial_lite'); ?>" data-title="<?php esc_html_e('Type a message to tweet. Leave this field empty to use default tweet (page title + URL).', 'arsocial_lite'); ?>">(?)</span>
                                            </div>
                                        </div>

                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Via', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <input type='text' class='arsocial_lite_locker_input_control arsocialshare_input_box' id='arsocialshare_tw_tweet_via' value="<?php echo isset($social_options['tweet_via']) ? $social_options['tweet_via'] : ''; ?>" name='arsocialshare_tw_tweet_via' style="width:90%;" />&nbsp;<span class='arsocialshare_tooltip' title='<?php esc_html_e('Optional. Type Screen name of ther user to attribute the Tweet to ( without @ ).', 'arsocial_lite'); ?>' data-title='<?php esc_html_e('Optional. Type Screen name of ther user to attribute the Tweet to ( without @ ).', 'arsocial_lite'); ?>'>(?)</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="arsocialshare_box_clear"></div>
                            </div>
                            <!--Disabled Networks-->
                            <div class="arsocialshare_inner_container arsocialshare_fancounter_settings" id="arsocialshare_globaarsocialshare_sharing_sortablel_share_locker" style="padding-top: 25px;">
                                <div class="ars_lite_pro_networks_info"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Available in premium version', 'arsocial_lite'); ?> )</span></div>
                                
                                <div class="arsocialshare_social_box_disabled <?php echo $fbClassBtn; ?>" title="<?php echo $fbDisableNotice; ?>" id="facebook_share" data-listing-order="4">
                                    <input type="hidden" name="arsocial_lite_locker_share_networks[]" class="arsocial_lite_locker_share_networks" value="facebook_share" />
                                    <input type='checkbox' name='is_fb_share' class="arsocial_lite_locker_share_like_network_input" onclick="ars_locker_network_active_deactive(this, 'facebook_share')" id='is_fb_share' value='1' <?php echo $fbShareChecked; ?> />
                                    <label for="is_fb_share"><span></span></label>
                                    <div class="arsocialshare_network_icon facebook"></div>
                                    <div class="arsocialshare_social_box_title">
                                        <?php esc_html_e('Facebook Share', 'arsocial_lite'); ?>
                                    </div>
                                    <!--<span class="arsocialshare_move_icon"></span>-->
                                    <div class="arsocialshare_box_container" id="arsocialshare_box_facebook_share_container" style="<?php echo (isset($social_options['is_fb_share']) && !empty($social_options['is_fb_share'])) ? "" : "display: none;"; ?>">
                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('URL to share', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <input type="text" name="fb_share_url" id="fb_share_url" class="arsocial_lite_locker_input_control arsocialshare_input_box" value="<?php echo isset($social_options['fb_share_url']) ? $social_options['fb_share_url'] : ''; ?>" style="width:90%;">&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set an URL which user has to share on facebook in order to unlock your content. Leave this field empty to use URL of the page where this locker will be located.', 'arsocial_lite'); ?>" data-title="<?php esc_html_e('Set an URL which user has to share on facebook in order to unlock your content. Leave this field empty to use URL of the page where this locker will be located.', 'arsocial_lite'); ?>">(?)</span>
                                            </div>
                                        </div>

                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <div class='arsocial_inner_input_wrap arsocialshare_checkbox_margin'>
                                                    <input type='checkbox' name='is_fb_share_counter' id='is_fb_share_counter' value='1' <?php checked(isset($social_options['is_fb_share_counter'])?$social_options['is_fb_share_counter']:'', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='is_fb_share_counter'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="arsocialshare_social_box_disabled <?php echo $twClassBtn; ?>" title="<?php echo $twDisableNotice; ?>" id="twitter_follow" data-listing-order="5">
                                    <input type="hidden" name="arsocial_lite_locker_share_networks[]" class="arsocial_lite_locker_share_networks" value="twitter_follow" />
                                    <input type='checkbox' name='is_tw_follow' class="arsocial_lite_locker_share_like_network_input" onclick="ars_locker_network_active_deactive(this, 'twitter_follow')" id='is_tw_follow' value='1' <?php echo $twFollowChecked; ?> />
                                    <label for="is_tw_follow"><span></span></label>
                                    <div class="arsocialshare_network_icon twitter"></div>
                                    <div class="arsocialshare_social_box_title">
                                        <?php esc_html_e('Twitter Follow', 'arsocial_lite'); ?>
                                    </div>
                                    <!--<span class="arsocialshare_move_icon"></span>-->
                                    <div class="arsocialshare_box_container" id="arsocialshare_box_twitter_follow_container" style="<?php echo (isset($social_options['is_tw_follow']) && !empty($social_options['is_tw_follow'])) ? "" : "display:none;"; ?>">
                                        <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                            <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('User to Follow', 'arsocial_lite'); ?></div>
                                            <div class='arsocialshare_box_input'>
                                                <input type="text" name="tw_follow_url" id="tw_follow_url" class="arsocial_lite_locker_input_control arsocialshare_input_box" value="<?php echo isset($social_options['tw_follow_url']) ? $social_options['tw_follow_url'] : ''; ?>" style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set a full URL of your Twitter profile which the user has to follow in order to unlock you content.', 'arsocial_lite'); ?>" data-title="<?php esc_html_e('Set a full URL of your Twitter profile which the user has to follow in order to unlock you content.', 'arsocial_lite'); ?>">(?)</span>
                                            </div>
                                        </div>

                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Show username', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <div class="arsocial_inner_input_wrap arsocialshare_checkbox_margin">
                                                    <input type='checkbox' name='show_tw_username' id='show_tw_username' value='1' <?php checked(isset($social_options['show_tw_username'])?$social_options['show_tw_username']:'', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='show_tw_username'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <div class="arsocial_inner_input_wrap arsocialshare_checkbox_margin">
                                                    <input type="checkbox" name="show_tw_follow_cntr" id="show_tw_follow_cntr" value="1" <?php checked(isset($social_options['show_tw_follow_cntr'])?$social_options['show_tw_follow_cntr']:'', 1); ?> />&nbsp;<label class="arsocialshare_inner_label" for="show_tw_follow_cntr"><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_box_disabled <?php echo $liClassBtn; ?>" title="<?php echo $liDisableNotice; ?>" id="linkedin_share" data-listing-order="7">
                                    <input type="hidden" name="arsocial_lite_locker_share_networks[]" class="arsocial_lite_locker_share_networks" value="linkedin_share" />
                                    <input type='checkbox' name='is_linkedin_share' class="arsocial_lite_locker_share_like_network_input" onclick="ars_locker_network_active_deactive(this, 'linkedin_share')" id='is_linkedin_share' value='1' <?php echo $liShareChecked; ?> />
                                    <label for="is_linkedin_share"><span></span></label>
                                    <div class="arsocialshare_network_icon linkedin"></div>
                                    <div class="arsocialshare_social_box_title">
                                        <?php esc_html_e('Linkedin Share', 'arsocial_lite'); ?>
                                    </div>
                                    <!--<span class="arsocialshare_move_icon"></span>-->
                                    <div class="arsocialshare_box_container" id="arsocialshare_box_linkedin_share_container" style="<?php echo (isset($social_options['is_linkedin_share']) && !empty($social_options['is_linkedin_share'])) ? "" : "display: none;"; ?>">
                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('URL to Share', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <input type="text" name="linkedin_url_share" id="linkedin_url_share" class="arsocial_lite_locker_input_control arsocialshare_input_box" value="<?php echo isset($social_options['linkedin_url_share']) ? $social_options['linkedin_url_share'] : ''; ?>" style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set an URL which user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located', 'arsocial_lite'); ?>" data-title="<?php esc_html_e('Set an URL which user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located', 'arsocial_lite'); ?>">(?)</span>
                                            </div>
                                        </div>

                                        <div class="arsocialshare_box_row arsocialshare_row_margin">
                                            <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_box_input">
                                                <div class="arsocial_inner_input_wrap arsocialshare_checkbox_margin">
                                                    <input type='checkbox' name='is_linkedin_share_counter' id='is_linkedin_share_counter' value='1' <?php checked(isset($social_options['is_linkedin_share_counter'])?$social_options['is_linkedin_share_counter']:'', 1); ?> />&nbsp;<label class='arsocialshare_inner_label' for='is_linkedin_share_counter'><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="arsocialshare_signin_locker_options" style="float: left; <?php echo $display_login_locker; ?>">
                    <div class="arsocial_lite_locker_inner_wrapper arsocialshare_fancounter_settings arsocialshare_sharing_sortable ars_save_order" id="arsocialshare_global_signin_locker" >
                        <?php
                        $enable_fb_box = "";
                        if (isset($social_options['is_fb_signin']) && $social_options['is_fb_signin'] == 1) {
                            $enable_fb_box = "enable";
                        }
                        ?>
                        <div class="arsocialshare_social_box <?php echo $enable_fb_box; ?> <?php echo $fbClassBtn; ?>" title="<?php echo $fbDisableNotice; ?>" id="arsocial_lite_locker_option_box_wrapper_fb" data-listing-order="1">
                            <input type="hidden" name="arsocial_lite_locker_signin_networks[]" value="facebook" class="arsocial_lite_locker_signin_locker" />
                            <input type="checkbox" id="arsocial_lite_locker_fb_enable" value="1" class="arsocialshare_ds_locker_enable arsocial_lite_locker_signin_network_input" <?php echo $fbSigninChecked; ?> name="active_fb_signin_locker" data-box="arsocial_lite_locker_option_box_wrapper_fb" />
                            <label for="arsocial_lite_locker_fb_enable"><span></span></label>
                            <div class="arsocialshare_network_icon facebook"></div>
                            <div class="arsocialshare_social_box_title">&nbsp;<?php esc_html_e('Facebook', 'arsocial_lite'); ?></div>
                            <!--<span class="arsocialshare_move_icon"></span>-->
                            <div class="arsocial_lite_locker_option_box_container">
                                <div class="arsocial_lite_locker_option_row">
                                    <label class="arsocial_lite_locker_opt_label" style="width:auto;padding-right:10px;"><?php esc_html_e('Create Account', 'arsocial_lite'); ?></label>
                                    <div class="arsocial_lite_locker_opt_input">
                                        <input type="checkbox" name="fb_signin_create_wp_account" id="locker_fb_create_account" value="1" <?php checked(isset($social_options['is_fb_create_account']) ? $social_options['is_fb_create_account'] : '', 1); ?> />
                                        <label for="locker_fb_create_account"><span></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $enable_tw_box = "";
                        if (isset($social_options['is_twitter_signin']) && $social_options['is_twitter_signin'] == 1) {
                            $enable_tw_box = "enable";
                        }
                        ?>
                        <div class="arsocialshare_social_box <?php echo $enable_tw_box; ?> <?php echo $twClassBtn; ?>" title="<?php echo $twDisableNotice; ?>" id="arsocial_lite_locker_option_box_wrapper_tw" data-listing-order="2">
                            <input type="hidden" name="arsocial_lite_locker_signin_networks[]" value="twitter" class="arsocial_lite_locker_signin_locker" />
                            <input type="checkbox" id="arsocial_lite_locker_tw_enable" value="1" class="arsocialshare_ds_locker_enable arsocial_lite_locker_signin_network_input" name="active_twitter_signin_locker" data-box="arsocial_lite_locker_option_box_wrapper_tw" <?php echo $twSigninChecked; ?> />
                            <label for="arsocial_lite_locker_tw_enable"><span></span></label>
                            <div class="arsocialshare_network_icon twitter"></div>
                            <div class="arsocialshare_social_box_title"><?php esc_html_e('Twitter', 'arsocial_lite'); ?></div>
                            <!--<span class="arsocialshare_move_icon"></span>-->
                            <div class="arsocial_lite_locker_option_box_container">
                                <div class="arsocial_lite_locker_option_row">
                                    <label class="arsocial_lite_locker_opt_label"  style="width:auto;padding-right:10px;"><?php esc_html_e('Create Account', 'arsocial_lite'); ?></label>
                                    <div class="arsocial_lite_locker_opt_input">
                                        <input type="checkbox" name="twitter_signin_create_wp_account" id="locker_twitter_create_account" value="1" <?php checked(isset($social_options['is_twitter_create_account']) ? $social_options['is_twitter_create_account'] : '', 1); ?> />
                                        <label for="locker_twitter_create_account"><span></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $enable_ln_box = "";
                        if (isset($social_options['is_linkedin_signin']) && $social_options['is_linkedin_signin'] == 1) {
                            $enable_ln_box = "enable";
                        }
                        ?>
                        <div class="arsocialshare_social_box <?php echo $enable_ln_box; ?> <?php echo $liClassBtn; ?>" title="<?php echo $liDisableNotice; ?>" id="arsocial_lite_locker_option_box_wrapper_ln" data-listing-order="4">
                            <input type="hidden" name="arsocial_lite_locker_signin_networks[]" value="linkedin" class="arsocial_lite_locker_signin_locker" />
                            <input type="checkbox" id="arsocial_lite_locker_ln_enable" value="1" class="arsocialshare_ds_locker_enable arsocial_lite_locker_signin_network_input" name="is_linkedin_signin" data-box="arsocial_lite_locker_option_box_wrapper_ln" <?php echo $liSigninChecked; ?> />
                            <label for="arsocial_lite_locker_ln_enable"><span></span></label>
                            <div class="arsocialshare_network_icon linkedin"></div>
                            <div class="arsocialshare_social_box_title"><?php esc_html_e('Linkedin', 'arsocial_lite'); ?></div>
                            <!--<span class="arsocialshare_move_icon"></span>-->
                            <div class="arsocial_lite_locker_option_box_container">
                                <div class="arsocial_lite_locker_option_row">
                                    <label class="arsocial_lite_locker_opt_label"  style="width:auto;padding-right:10px;"><?php esc_html_e('Create Account', 'arsocial_lite'); ?></label>
                                    <div class="arsocial_lite_locker_opt_input">
                                        <input type="checkbox" name="linkedin_signin_create_wp_account" id="linkedin_signin_create_wp_account" value="1" <?php checked(isset($social_options['is_linkedin_create_account']) ? $social_options['is_linkedin_create_account'] : '', 1); ?> />
                                        <label for="linkedin_signin_create_wp_account"><span></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">3</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Template & Style', 'arsocial_lite'); ?></div>
                </div>
                <div class="arsocialshare_inner_content_wrapper">
                    <div class="ars_network_list_container" style="display: block;">
                        <div class="arsocialshare_option_container ars_column" style="width: 47%">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_global_locker_templates" class="arsocialshare_dropdown ars_lite_pro_options" id="arsocialshare_global_locker_templates">
                                        <?php
                                        if (!empty($arsocial_locker_themes) && is_array($arsocial_locker_themes)) {
                                            foreach ($arsocial_locker_themes as $key => $locker_theme) {
                                                ?>
                                                <option <?php selected($locker_template, $locker_theme['value']); ?> value="<?php echo $locker_theme['value']; ?>"><?php echo $key ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="arsocialshare_inner_option_label more_templates_label" ><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Overlap Mode', 'arsocial_lite'); ?></div>

                                <div class="arsocialshare_option_input">
                                    <div class="arsocialshare_inner_option_box" style="width: 115px" >
                                        <input type="radio" name="arsocial_lite_locker_overlap_mode" value="full" <?php checked('full', $overlap_mode); ?> class="ars_locker_overlap_mode_radio ars_hide_checkbox" id="arsocial_lite_locker_overlap_mode_full"  />
                                        <label class="arsocialshare_inner_option_label" for="arsocial_lite_locker_overlap_mode_full"><span></span><?php esc_html_e('Full (classic)', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box" style="width: 120px" >
                                        <input type="radio" name="arsocial_lite_locker_overlap_mode" value="transparency" <?php checked('transparency', $overlap_mode); ?> class="ars_locker_overlap_mode_radio ars_hide_checkbox" id="arsocial_lite_locker_overlap_mode_transparency"  />
                                        <label class="arsocialshare_inner_option_label" for="arsocial_lite_locker_overlap_mode_transparency"><span></span><?php esc_html_e('Transparency', 'arsocial_lite'); ?></label>
                                    </div>

                                    <div class="arsocialshare_inner_option_box" style="width:100px" >
                                        <input type="radio" name="arsocial_lite_locker_overlap_mode" value="blurring" <?php checked('blurring', $overlap_mode); ?> class="ars_locker_overlap_mode_radio ars_hide_checkbox" id="arsocial_lite_locker_overlap_mode_blurring"  />
                                        <label class="arsocialshare_inner_option_label" for="arsocial_lite_locker_overlap_mode_blurring"><span></span><?php esc_html_e('Blurring', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Locker Heading', 'arsocial_lite'); ?>:</div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocial_lite_locker_title" id="arsocial_lite_locker_title" value='<?php echo $locker_name; ?>' class="arsocialshare_input_box"/>
                                </div>
                            </div>
                            
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label" style="width: 25%;margin-top:10px;"><?php esc_html_e('Time Interval', 'arsocial_lite'); ?>:</div>
                                <div class="arsocialshare_option_input arsocial_lite_restrict_global_interval" style="width: 75%;">
                                    <div class="disable_all_click_event">
                                    <input type="radio" name="enable_locker_time_interval" id="enable_locker_time_interval" class="ars_display_option_input ars_hide_checkbox" value="" />
                                    <div class="arsocialshare_switch " data-id="enable_locker_time_interval">


                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="1"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="0"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                    <div class="ars_lite_restricted_switch"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                                </div>
                                </div>
                            </div>
                            
                            <div class="arsocialshare_option_row ars_lite_locker_time_interval_container" style="display: none;">
                                <div style="width: 25%;margin-top:10px;" class="arsocialshare_option_label"></div>
                                <div style="width: 75%;" class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_time_interval" id="arsocialshare_time_interval" value='' class="arsocialshare_input_box" />
                                    <span style="" class="arsocialshare_halp_text"><?php esc_html_e('Please enter time interval in seconds', 'arsocial_lite'); ?></span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row other" style="display:none;<?php echo ($locker_template!='gradient')?'display:block':''; ?>">
                                <div class="arsocialshare_option_label" style="width: 25%;margin-top:10px;"><?php esc_html_e('Background Color', 'arsocial_lite'); ?>:</div>
                                <div class="arsocialshare_option_input" style="width: 75%;">
                                    <input type="text" name="arsocialshare_locker_bgcolor" id="arsocialshare_locker_bgcolor" value='<?php echo $bg_color; ?>' class="arsocialshare_input_box ars_colpick" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label" style="width: 25%;margin-top:10px;"><?php esc_html_e('Text Color', 'arsocial_lite'); ?>:</div>
                                <div class="arsocialshare_option_input" style="width: 75%;">
                                    <input type="text" name="arsocialshare_locker_textcolor" id="arsocialshare_locker_textcolor" value='<?php echo $text_color; ?>' class="arsocialshare_input_box ars_colpick" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Locker Content', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <textarea class="arsocialshare_social_textarea" rows="7" cols="40" name="arsocial_lite_locker_content" id="arsocial_lite_locker_content"><?php echo $locker_content; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="arsocialshare_option_container ars_column ars_no_border" style="width: 52%">
                            <!-- Preview DIV -->
                            <style id="arf_preview_style" type="text/css"><?php
                            echo $arsocial_lite_locker->ars_locker_css('template_preview_box', $locker_template, $bg_color, $text_color);
                            ?></style>
                            <div class="ars_locker_template_preview_container">
                                <h3>Preview</h3>
                                <div class="ars_locker_template_preview_wrapper">
                                    <div class="arsocial_lite_locker_main_wrapper arsocialshare_locker_template_preview_box arsocial_lite_locker_template_preview_box arsocial_lite_locker_<?php echo $locker_template; ?>_theme arsocial_lite_locker_overlap_<?php echo $overlap_mode ?>" id="ars_locker_template_preview_box">
                                        <div class='arsocial_lite_locker_popup_bg'></div>
                                        <div class='arsocial_lite_locker_popup arsociallocker_popup' id='arsociallocker_popup'>
                                            <div class='arsocial_lite_locker_popup_inner'>
                                                <div class='arsocial_lite_locker_popup_inner_wrapper'>
                                                    <div id="ars_locker_heading" class='arsocial_lite_locker_popup_title arsocial_lite_locker_popup_title'><?php echo $locker_name; ?></div>
                                                    <div id='ars_locker_content' class='arsocial_lite_locker_popup_content arsocial_lite_locker_popup_content'><?php echo $locker_content; ?></div>
                                                    <div class='arsocialshare_button_outer_wrapper arsocial_lite_locker_button_wrapper1' id='arsocial_lite_locker_button_wrapper'>
                                                        <div class="ars_locker_btn_container">
                                                            <div class="ars_locker_btn_wrapper">
                                                                <div class="ars_locker_native_btn_wrapper ars_locker_native_facebook_wrapper">
                                                                    <span class="ars_native_button_icon socialshare-facebook"></span>
                                                                    <span class ="ars_native_label ars_native_facebook_label">Like</span>
                                                                </div>
                                                                <div id='arsocial_lite_locker_share_facebook_like_button' class='arsocial_lite_locker_button_wrapper arsocial_lite_locker_fb_wrapper'>
                                                                    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_facebook.png" alt="facebook">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ars_locker_btn_container">
                                                            <div class="ars_locker_btn_wrapper">
                                                                <div class="ars_locker_native_btn_wrapper ars_locker_native_twitter_wrapper">
                                                                    <span class="ars_native_button_icon socialshare-twitter"></span>
                                                                    <span class ="ars_native_label ars_native_twitter_label">Follow</span>
                                                                </div>
                                                                <div id='arsocial_lite_locker_share_twitter_like_button' class='arsocial_lite_locker_button_wrapper arsocial_lite_locker_tw_wrapper'>
                                                                    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_twitter.png" alt="twitter">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='ars_time_interval' style="display:none; <?php // echo $locker_interval; ?>">
                                                        or wait 
                                                        <label id='ars_seconds' class='ars_seconds'><?php // echo $time_interval['time_interval_sec']; ?>s</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="arsocialshare_locked_content ars_locked_<?php echo $overlap_mode ?>" style="display:none;">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed nisl non nulla dapibus faucibus. Nunc accumsan, augue quis mollis mollis. Integer ultricies sem purus, in pretium nunc laoreet ac. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                                            <br/>
                                            <p>Aliquam consequat dolor ac metus condimentum tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin quis varius turpis. Nunc rutrum nunc orci, vitae tincidunt orci aliquam pretium. Cras ac aliquet risus. Donec lorem justo, vulputate id suscipit pulvinar, fringilla eu lectus.</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Preview DIV -->
                        </div>
                    </div>
                </div>
                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">4</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Position(s) Where You Want To Display Locker', 'arsocial_lite'); ?></div>
                </div>
                <span id="arsocial_lite_locker_network_position_error" class="ars_error_message" style="display:done;"><?php esc_html_e('Please select atleast one network.', 'arsocial_lite'); ?></span>
                <div class="arsocialshare_inner_container">
                    <div class="arsocialshare_inner_content_wrapper">
                        <?php
                        $pages_selected = "";
                        $posts_selected = "";
                        if (is_array($displays) && array_key_exists('pages', $displays)) {
                            $pages_selected = "checked='checked'";
                        }
                        if (is_array($displays) && array_key_exists('posts', $displays)) {
                            $posts_selected = "checked='checked'";
                        }
                        ?>
                        <input type="checkbox" name="arsocialshare_enable_pages" value="pages" id="arsocialshare_enable_pages" <?php echo $pages_selected; ?> class="ars_display_option_input ars_hide_checkbox" />
                        <input type="checkbox" name="arsocialshare_enable_posts" value="posts" id="arsocialshare_enable_posts" <?php echo $posts_selected; ?> class="ars_display_option_input ars_hide_checkbox" />
                        <div class="arsocialshare_inner_container_main">
                            <div class="arsocialshare_option_box page_icon_locker <?php echo ($pages_selected !== '' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_pages" data-opt-id="arsocialshare_pages">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                            <div class="arsocialshare_option_box post_icon_locker <?php echo ($posts_selected !== '' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_posts" data-opt-id="arsocialshare_posts">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                        </div>
                        <div class="ars_network_list_container <?php echo ($pages_selected !== '' ) ? 'selected' : ''; ?>" style="padding-top:0px !important;padding-bottom:0 !important;" id="arsocialshare_pages">
                            <div class="arsocialshare_option_title">
                                <?php esc_html_e('Page Settings', 'arsocial_lite'); ?>
                            </div>
                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_display_locker_page_exclude" id="arsocialshare_page_excludes" value="<?php echo isset($displays['pages']['exclude']) ? $displays['pages']['exclude'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>
                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="padding-right:15px; text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                            <div class="arsocial_lite_locker_row_seperator"></div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                        </div>
                        <div class="ars_network_list_container <?php echo ( $posts_selected !== '' ) ? 'selected' : ''; ?>" style="padding-top:0px !important;padding-bottom:0 !important;" id="arsocialshare_posts">

                            <div class="arsocialshare_option_title">
                                <?php esc_html_e('Post Settings', 'arsocial_lite'); ?>
                            </div>

                            <div class="arsocialshare_option_container" style="display : none;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Enable Social Icons on Post Excerpt', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <?php
                                    $enable_post_excerpt = isset($displays['posts']['excerpt']) ? $displays['posts']['excerpt'] : 'no';
                                    ?>
                                    <input type="hidden" name="arsocialshare_enable_post_excerpt" id="arsocialshare_enable_post_excerpt" value="<?php echo $enable_post_excerpt; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($enable_post_excerpt === 'yes' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_post_excerpt">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Posts', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_posts_excludes" id="arsocialshare_page_excludes" value="<?php echo isset($displays['posts']['exclude']) ? $displays['posts']['exclude'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>
                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="padding-right:15px; text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Posts', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>
                        </div>
                        <div class="arsocialshare_clear">&nbsp;</div>
                    </div>
                    <div class="arsocialshare_title_belt">
                        <div class="arsocialshare_title_belt_number">5</div>
                        <div class="arsocialshare_belt_title"><?php esc_html_e('Custom CSS', 'arsocial_lite'); ?>&nbsp;&nbsp;<span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                    </div>
                    <div class="ars_network_list_container selected" style="width:100%;">
                        <div class="arsocialshare_option_container ars_column ars_no_border" style="width:100%; padding-top:0;  ">
                            <div class="arsocialshare_option_row" style="padding-bottom: 0px;">
                                <div class="arsocialshare_option_label" style="width: 12%; line-height: 25px;"><?php esc_html_e('Enter Custom CSS', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input arsocial_lite_custom_css_global_restricted" style="width: 88%;">
                                    <div class="arshare_opt_checkbox_row">
                                        <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%">
                                            <textarea name="arsocial_lite_locker_customcss" id="arsocial_lite_locker_customcss" class="ars_display_option_input" style="width:700px;height:200px;padding:5px 10px !important;" readonly="readonly"></textarea>
                                        </div>
                                        <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%; margin-top:10px; ">
                                            <span class='arsocial_lite_locker_note' style="width: 100%;">
                                                <?php echo "eg: .arsocial_lite_locker_wrapper { background-color: #d1d1d1; }"; ?>
                                            </span>
                                            <span class='arsocial_lite_locker_note' style="float:left;">
                                                <?php esc_html_e('For CSS Class information related to sharing buttons,', 'arsocial_lite'); ?>
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
        <div class="arsocial_lite_share_button_wrapper">
            <button type='button' style="margin:15px 0px 0px 60px;" id="update_arsocial_lite_locker_display_settings" class="arsocialshare_save_display_settings"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
            <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="arsocialshare_save_loader" />
        </div>
        
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
    </div>
</form>