<?php
global $arsocial_lite;
$arsFonts = $arsocial_lite->ars_get_fonts();
if (isset($_POST['update_arsocialshare_gs'])) {

    $fb_app_id = isset($_POST['fb_app_id']) ? $_POST['fb_app_id'] : '';
    $fb_app_secret = isset($_POST['fb_app_secret']) ? $_POST['fb_app_secret'] : '';
    $fb_access_token = isset($_POST['fb_access_token']) ? $_POST['fb_access_token'] : '';
    $fb_access_token_expiry = isset($_POST['ars_fb_access_token_expiry']) ? $_POST['ars_fb_access_token_expiry'] : time(date('Y-m-d H:i:s', strtotime('+60 day')));
    update_option('ars_fb_extended_token_validity', $fb_access_token_expiry);
    $fb_app_ver = isset($_POST['fb_app_ver']) ? $_POST['fb_app_ver'] : '';

    $linkedin_api_key = isset($_POST['linkedin_api_key']) ? $_POST['linkedin_api_key'] : '';
    $linkedin_client_secret = isset($_POST['linkedin_client_secret']) ? $_POST['linkedin_client_secret'] : '';

    $twitter_api_key = isset($_POST['twitter_api_key']) ? $_POST['twitter_api_key'] : '';
    $twitter_api_secret = isset($_POST['twitter_api_secret']) ? $_POST['twitter_api_secret'] : '';
    $twitter_access_token = isset($_POST['twitter_access_token']) ? $_POST['twitter_access_token'] : '';
    $twitter_access_token_secret = isset($_POST['twitter_access_token_secret']) ? $_POST['twitter_access_token_secret'] : '';

    $more_button = isset($_POST['display_more_button']) ? $_POST['display_more_button'] : 5;
    $more_btn_style = isset($_POST['fly_more_btn_style']) ? $_POST['fly_more_btn_style'] : 'plus_icon';

    $after_share_enable = isset($_POST['after_share_enable']) ? $_POST['after_share_enable'] : '';
    $after_share_action = isset($_POST['after_share_action']) ? $_POST['after_share_action'] : '';
    $arsocialshare_after_share_content = isset($_POST['arsocialshare_after_share_content']) ? $_POST['arsocialshare_after_share_content'] : '';

    $global_settings = array();

    $global_settings['facebook']['app_id'] = $fb_app_id;
    $global_settings['facebook']['app_secret'] = $fb_app_secret;
    $global_settings['facebook']['access_token'] = $fb_access_token;
    $global_settings['facebook']['app_version'] = $fb_app_ver;
    
    $global_settings['linkedin']['linkedin_api_key'] = $linkedin_api_key;
    $global_settings['linkedin']['linkedin_client_secret'] = $linkedin_client_secret;

    $global_settings['twitter']['twitter_api_key'] = $twitter_api_key;
    $global_settings['twitter']['twitter_api_secret'] = $twitter_api_secret;
    $global_settings['twitter']['twitter_access_token'] = $twitter_access_token;
    $global_settings['twitter']['twitter_access_token_secret'] = $twitter_access_token_secret;

    $global_settings['after_share_enable'] = $after_share_enable;
    $global_settings['after_share'] = $after_share_action;
    $global_settings['after_share_content'] = $arsocialshare_after_share_content;

    $global_settings['share_fonts'] = isset($_POST['share_fonts']) ? $_POST['share_fonts'] : 'Helvetica';
    $global_settings['like_fonts'] = isset($_POST['like_fonts']) ? $_POST['like_fonts'] : 'Helvetica';
    $global_settings['fan_fonts'] = isset($_POST['fan_fonts']) ? $_POST['fan_fonts'] : 'Helvetica';
    $global_settings['locker_fonts'] = isset($_POST['locker_fonts']) ? $_POST['locker_fonts'] : 'Helvetica';

    $global_settings['fan_counter_update_data'] = isset($_POST['fancounter_update_data']) ? $_POST['fancounter_update_data'] : '15';

    $global_settings['global_share_assets'] = isset($_POST['global_share_assets']) ? $_POST['global_share_assets'] : 0;
    $global_settings['global_like_assets'] = isset($_POST['global_like_assets']) ? $_POST['global_like_assets'] : 0;
    $global_settings['global_fan_assets'] = isset($_POST['global_fan_assets']) ? $_POST['global_fan_assets'] : 0;
    $global_settings['global_locker_assets'] = isset($_POST['global_locker_assets']) ? $_POST['global_locker_assets'] : 0;

    update_option('arslite_global_settings', maybe_serialize($global_settings));
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function (e) {
            jQuery('#success-message').animate({width: 'toggle'}, 'slow');
            jQuery(window.opera ? 'html' : 'html, body').animate('slow');
            jQuery('#success-message').delay(3000).animate({width: 'toggle'}, 'slow');
        });
    </script>
    <?php
}
$options = get_option('arslite_global_settings');
$gs_options = maybe_unserialize($options);

?>
<div class="success-message" id="success-message"><?php esc_html_e('Settings Saved Successfully.', 'arsocial_lite'); ?></div>
<form name="arsocialshare_global_settings" id="arsocialshare_global_settings" method="post">
    <div class="arsocialshare_main_wrapper">
        <div class="arsocialshare_title_wrapper">
            <label class="arsocialshare_page_title"><?php esc_html_e('General Settings', 'arsocial_lite'); ?></label>
        </div>		

        <div class="arsocialshare_inner_wrapper" style="padding:0;">
            <div class="arsocialshare_networks">

                <div class="arsocialshare_networks_inner_wrapper arsocialshare_networks_gs_inner_wrapper">

                    <div class="arsocialshare_gs_page_sub_title"><?php esc_html_e('Social Network Configuration', 'arsocial_lite'); ?></div>
                    <div class="arsocialshare_inner_container arsocialshare_gs_inner_container">
                        <div class="arsocialshare_social_setting_box">
                            <div class="arsocialshare_social_setting_title">
                                <span class="arsocialshare_network_icon facebook"></span>&nbsp;
                                <label class="arsocialshare_container_box_title"><?php esc_html_e('Facebook', 'arsocial_lite'); ?></label>
                            </div>
                            <div class="arsocialshare_inner_content_container arsocialshare_gs_inner_content_container">
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('App Id', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="fb_app_id" class="arsocialshare_input_box" id="fb_app_id" value="<?php echo isset($gs_options['facebook']['app_id']) ? $gs_options['facebook']['app_id'] : ''; ?>" data-validation_msg='<?php echo json_encode(array('empty' => esc_html__('Please enter Facebook APP id.', 'arsocial_lite'))) ?>'>
                                        <?php
                                        $ars_facebook_api_title = esc_html__("To get more information about Facebook API Configuration, Please", 'arsocial_lite') . " <a id='ars_documentation_tooltip_link' href='".ARSOCIAL_LITE_URL ."/documentation/#arsocialapi_facebook' target='_blank'>" . esc_html__('Click Here', 'arsocial_lite') . "</a>";
                                        ?>
                                        <span class="arsocialshare_tooltip ars_documentation_tooltip" title="<?php echo $ars_facebook_api_title; ?>">(?)</span>
                                    </div>
                                </div>
                                
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('App Secret', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="fb_app_secret" class="arsocialshare_input_box" id="fb_app_secret" value="<?php echo isset($gs_options['facebook']['app_secret']) ? $gs_options['facebook']['app_secret'] : ''; ?>"  data-validation_msg='<?php echo json_encode(array('empty' => esc_html__('Please enter Facebook App Secret.', 'arsocial_lite'))) ?>' />&nbsp;<button type="button" id="generate_fb_access_token" class="ars_generate_token_button"><?php esc_html_e('Generate Token', 'arsocial_lite'); ?></button>&nbsp;<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="ars_generate_access_token_loader" width="20" height="20" style="margin-top:7px;" />
                                    </div>
                                </div>

                                <div class="arsocialshare_social_row" style="margin-bottom:5px;">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Access Token', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="fb_access_token" class="arsocialshare_input_box" id="fb_access_token" readonly="readonly" value="<?php echo isset($gs_options['facebook']['access_token']) ? $gs_options['facebook']['access_token'] : ''; ?>" />
                                        <?php
                                        $token_validity = get_option('ars_fb_extended_token_validity');
                                        $current_timestamp = current_time('timestamp');
                                        $token_notice = "";
                                        if ($token_validity != '') {
                                            if($current_timestamp > $token_validity ) {
                                                $token_notice = esc_html__('Your token is expired. Please re-generate it.', 'arsocial_lite');
                                            } else {
                                                $token_notice = esc_html__('Your token will be expire on', 'arsocial_lite') . ' <span id="ars_formatted_date">' . date(get_option('date_format'), get_option('ars_fb_extended_token_validity')).'</span>';
                                            }
                                            ?>
                                            <span class="arsocialshare_notice"><?php echo $token_notice; ?></span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div id="fb-root"></div>
                                    <input type="hidden" id="ars_fb_access_token_expiry" name="ars_fb_access_token_expiry" value="<?php echo get_option('ars_fb_extended_token_validity'); ?>" />
                                </div>

                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box"><?php esc_html_e('Version', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <?php
                                            $gs_options['facebook']['app_version'] = isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : '7.0';
                                        ?>

                                        <?php 
                                            $currentDate = date('Y-m-d');

                                            $current_time = current_time( 'timestamp' );
                                            $fb_v6_end_time = strtotime( '2022-05-06 00:00:00');

                                            if( $fb_v6_end_time > $current_time ){ ?>
                                                <input type="radio" name="fb_app_ver" id="fb_app_v6.0" value="6.0" class="arsocialshare_radio_input ars_hide_radio" <?php checked(isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : "", '6.0'); ?>>
                                                <label for="fb_app_v6.0" class="arsocialshare_radio_input_lable"><span></span>&nbsp;v6.0</label>
                                        <?php } ?>
                                        
                                        <input type="radio" name="fb_app_ver" id="fb_app_v7.0" value="7.0" class="arsocialshare_radio_input ars_hide_radio" <?php checked(isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : "", '7.0'); ?>>
                                        <label for="fb_app_v7.0" class="arsocialshare_radio_input_lable"><span></span>&nbsp;v7.0</label>

                                        <input type="radio" name="fb_app_ver" id="fb_app_v8.0" value="8.0" class="arsocialshare_radio_input ars_hide_radio" <?php checked(isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : "", '8.0'); ?>>
                                        <label for="fb_app_v8.0" class="arsocialshare_radio_input_lable"><span></span>&nbsp;v8.0</label>

                                        <input type="radio" name="fb_app_ver" id="fb_app_v9.0" value="9.0" class="arsocialshare_radio_input ars_hide_radio" <?php checked(isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : "", '9.0'); ?>>
                                        <label for="fb_app_v9.0" class="arsocialshare_radio_input_lable"><span></span>&nbsp;v9.0</label>
                                        
                                        <input type="radio" name="fb_app_ver" id="fb_app_v10.0" value="10.0" class="arsocialshare_radio_input ars_hide_radio" <?php checked(isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : "", '10.0'); ?>>
                                        <label for="fb_app_v10.0" class="arsocialshare_radio_input_lable"><span></span>&nbsp;v10.0</label>

                                        <input type="radio" name="fb_app_ver" id="fb_app_v11.0" value="11.0" class="arsocialshare_radio_input ars_hide_radio" <?php checked(isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : "", '11.0'); ?>>
                                        <label for="fb_app_v11.0" class="arsocialshare_radio_input_lable"><span></span>&nbsp;v11.0</label>

                                        <input type="radio" name="fb_app_ver" id="fb_app_v12.0" value="12.0" class="arsocialshare_radio_input ars_hide_radio" <?php checked(isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : "", '12.0'); ?>>
                                        <label for="fb_app_v12.0" class="arsocialshare_radio_input_lable"><span></span>&nbsp;v12.0</label>

                                        <input type="radio" name="fb_app_ver" id="fb_app_v13.0" value="13.0" class="arsocialshare_radio_input ars_hide_radio" <?php checked(isset($gs_options['facebook']['app_version']) ? $gs_options['facebook']['app_version'] : "", '13.0'); ?>>
                                        <label for="fb_app_v13.0" class="arsocialshare_radio_input_lable"><span></span>&nbsp;v13.0</label>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="arsocialshare_social_setting_box">
                            <div class="arsocialshare_social_setting_title">
                                <span class="arsocialshare_network_icon twitter"></span>&nbsp;
                                <label class="arsocialshare_container_box_title"><?php esc_html_e('Twitter', 'arsocial_lite') ?></label>
                            </div>
                            <div class="arsocialshare_inner_content_container arsocialshare_gs_inner_content_container">
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Consumer Key', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="twitter_api_key" class="arsocialshare_input_box" id="twitter_api_key" value="<?php echo isset($gs_options['twitter']['twitter_api_key']) ? $gs_options['twitter']['twitter_api_key'] : ''; ?>"/>
                                        <?php
                                        $ars_twitter_api_title = esc_html__("To get more information about Twitter API Configuration, Please", 'arsocial_lite') . " <a id='ars_documentation_tooltip_link' href='".ARSOCIAL_LITE_URL ."/documentation/#arsocialapi_twitter' target='_blank'>" . esc_html__('Click Here', 'arsocial_lite') . "</a> ";
                                        ?>
                                        <span class="arsocialshare_tooltip ars_documentation_tooltip" title="<?php echo $ars_twitter_api_title; ?>">(?)</span>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Consumer Secret', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="twitter_api_secret" class="arsocialshare_input_box" id="twitter_api_secret" value="<?php echo isset($gs_options['twitter']['twitter_api_secret']) ? $gs_options['twitter']['twitter_api_secret'] : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Access Token', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="twitter_access_token" class="arsocialshare_input_box" id="twitter_access_token" value="<?php echo isset($gs_options['twitter']['twitter_access_token']) ? $gs_options['twitter']['twitter_access_token'] : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Token Secret', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="twitter_access_token_secret" class="arsocialshare_input_box" id="twitter_access_token_secret" value="<?php echo isset($gs_options['twitter']['twitter_access_token_secret']) ? $gs_options['twitter']['twitter_access_token_secret'] : ''; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="arsocialshare_social_setting_box">
                            <div class="arsocialshare_social_setting_title">
                                <span class="arsocialshare_network_icon linkedin"></span>&nbsp;
                                <label class="arsocialshare_container_box_title"><?php esc_html_e('LinkedIn', 'arsocial_lite'); ?></label>
                            </div>
                            <div class="arsocialshare_inner_content_container arsocialshare_gs_inner_content_container">
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Client ID', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="linkedin_api_key" class="arsocialshare_input_box" id="linkedin_api_key" value="<?php echo isset($gs_options['linkedin']['linkedin_api_key']) ? $gs_options['linkedin']['linkedin_api_key'] : ''; ?>" />
                                        <?php
                                        $ars_linkedin_api_title = esc_html__("To get more information about LinkedIn API Configuration, Please", 'arsocial_lite') . " <a id='ars_documentation_tooltip_link' href='" . ARSOCIAL_LITE_URL . "/documentation/#arsocialapi_linkedin' target='_blank'>" . esc_html__('Click Here', 'arsocial_lite') . "</a> ";
                                        ?>
                                        <span class="arsocialshare_tooltip ars_documentation_tooltip" title="<?php echo $ars_linkedin_api_title; ?>">(?)</span>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Client Secret', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <input type="text" name="linkedin_client_secret" class="arsocialshare_input_box" id="linkedin_client_secret" value="<?php echo isset($gs_options['linkedin']['linkedin_client_secret']) ? $gs_options['linkedin']['linkedin_client_secret'] : ''; ?>" />
                                    </div>
                                </div>
                                <input type="hidden" id="ars_linkedin_callback_url" value="<?php echo home_url().'?action=ars_linkedin_callback'; ?>" />
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label">&nbsp;</div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <div class="arsocialshare_gs_note" style="font-size:14px;"><?php printf(esc_html__('Please set %s as Redirect URLs in your LinkedIn application Auth settings.','arsocial_lite'),'<strong>'.home_url().'?action=ars_linkedin_callback</strong>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>        
                        <div class="arsocialshare_social_setting_box">
                            <div class="arsocialshare_social_setting_title">
                                <span class="arsocialshare_network_icon vk"></span>&nbsp;
                                <label class='arsocialshare_container_box_title'><?php esc_html_e('VK', 'arsocial_lite'); ?></label>
                                <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                            </div>
                            <div class="arsocialshare_inner_content_container arsocialshare_gs_inner_content_container">
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('App Id', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box arsocial_lite_general_settings_restricted">
                                        <input type="text" name="vk_app_id" class="arsocialshare_input_box" id="vk_app_id" value="" readonly="readonly">
                                        <?php
                                        $ars_vk_api_title = esc_html__("To get more information about VK API Configuration, Please", 'arsocial_lite') . "<a id='ars_documentation_tooltip_link' href='" . ARSOCIAL_LITE_URL . "/documentation/#arsocialapi_vkontakte' target='_blank'>" . esc_html__('Click Here', 'arsocial_lite') . "</a> ";
                                        ?>
                                        <span class="arsocialshare_tooltip ars_documentation_tooltip" title="<?php echo $ars_vk_api_title; ?>">(?)</span>
                                    </div>
                                </div>

                            </div>
                        </div>                        
                        <div class="arsocialshare_social_setting_box">
                            <div class="arsocialshare_social_setting_title">
                                <span class="arsocialshare_network_icon bitly"></span>&nbsp;
                                <label class="arsocialshare_container_box_title"><?php esc_html_e('Bitly', 'arsocial_lite'); ?></label>
                                <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                            </div>
                            <div class="arsocialshare_inner_content_container arsocialshare_gs_inner_content_container">
                                <?php
                                $ars_bitly_api_title = esc_html__("To get more information about Bitly API Configuration, Please", 'arsocial_lite') . "<a id='ars_documentation_tooltip_link' href='" . ARSOCIAL_LITE_URL . "/documentation/#arsocialapi_bitly' target='_blank'>" . esc_html__('Click Here', 'arsocial_lite') . "</a> ";
                                ?>
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Access Token', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box arsocial_lite_general_settings_restricted">
                                        <input type="text" name="bitly_api_key" class="arsocialshare_input_box" id="bitly_api_key" value="" readonly="readonly" />

                                        <span class="arsocialshare_tooltip ars_documentation_tooltip" title="<?php echo $ars_bitly_api_title; ?>">(?)</span>

                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="arsocialshare_clear"></div>
                    <div class="arsocial_lite_locker_row_seperator"></div>
                    <div class="arsocialshare_gs_page_sub_title"><?php esc_html_e("Fan Counter Update", 'arsocial_lite'); ?></div>
                    <div class="arsocialshare_inner_container arsocialshare_gs_inner_container">
                        <div class="arsocialshare_social_setting_box">
                            <div class="arsocialshare_inner_content_container arsocialshare_gs_inner_content_container">
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label" style="line-height:normal;"><?php esc_html_e('After x Minutes update counter from live', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box" style="padding-top:3px;">
                                        <input type="text" name="fancounter_update_data" class="arsocialshare_input_box" id="fancounter_update_data" value="<?php echo isset($gs_options['fan_counter_update_data']) ? $gs_options['fan_counter_update_data'] : '15'; ?>">

                                        <span style="font-style:italic;position:relative;left:7px;"><?php esc_html_e('in minutes', 'arsocial_lite'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="arsocialshare_clear"></div>
                    <div class="arsocial_lite_locker_row_seperator"></div>
                    <div class="arsocialshare_gs_page_sub_title"><?php esc_html_e('URL Shortner', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                    <div class="arsocialshare_inner_container arsocialshare_gs_inner_container arsocial_lite_general_settings_restricted">
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box"><?php esc_html_e('Enable URL Short Name', 'arsocial_lite'); ?></div>

                        </div>

                        <div class="arsocialshare_social_row enable_url_short_name_container" style="">
                            <div class="arsocialshare_social_label inner_container_box"></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <input type="radio" name="short_url_type" id="wordpress" value="wordpress" class="arsocialshare_radio_input ars_hide_radio" checked="checked">
                                <label for="wordpress" class="arsocialshare_radio_input_lable arsocialshare_first_radio_lable"><span></span>&nbsp;&nbsp;<?php esc_html_e('Built in WordPress function', 'arsocial_lite'); ?></label>
                                <input type="radio" name="short_url_type" id="bitly" value="bitly" class="arsocialshare_radio_input ars_hide_radio"> 
                                <label for="bitly" class="arsocialshare_radio_input_lable"><span></span>&nbsp;&nbsp;<?php esc_html_e('Bit.ly (Bitly)', 'arsocial_lite'); ?></label>

                            </div>
                        </div>
                        <div class="arsocialshare_social_row" id="ars_bitylt_note" style="">
                            <div class="arsocialshare_social_label inner_container_box"></div>
                            <div class="arsocialshare_social_input inner_container_box ars_url_shortner">
                                <span class="arsocialshare_bitly_note ars_url_shortner">
                                    <?php esc_html_e('Please configure above Bitly API detail.', 'arsocial_lite'); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="arsocialshare_clear"></div>
                    <div class="arsocial_lite_locker_row_seperator"></div>
                    <div class="arsocialshare_gs_page_sub_title"><?php esc_html_e('Email Configuration', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                    <div class="arsocialshare_inner_container arsocialshare_gs_inner_container arsocial_lite_general_settings_restricted">
                        <div class="arsocialshare_social_setting_box">
                            <div class="arsocialshare_inner_content_container arsocialshare_gs_inner_content_container">
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Email Method', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <select class="arsocialshare_dropdown" id="arsocialshare_email_method" name="arsocialshare_email_method">
                                            <?php
                                            $gs_email_method = 'wp_method';
                                            ?>
                                            <option <?php selected($gs_email_method, 'wp_method'); ?> value="wp_method"><?php esc_html_e('Use wordpress mail function', 'arsocial_lite'); ?></option>
                                            <option <?php selected($gs_email_method, 'php_method'); ?> value="php_method"><?php esc_html_e('Use PHP mail function', 'arsocial_lite'); ?></option>
                                        </select> &nbsp;
                                        <span class="arsocialshare_tooltip" title="<?php esc_html_e('Choose the default function you will use to send mails.', 'arsocial_lite'); ?>">(?)</span>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Email Button Function', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <select class="arsocialshare_dropdown" id="arsocialshare_email_operator" name="arsocialshare_email_operator">
                                            <?php
                                            $gs_email_operate = 'popup';
                                            
                                            ?>
                                            <option <?php selected($gs_email_operate, 'popup'); ?> value="popup"><?php esc_html_e('Using Popup', 'arsocial_lite'); ?></option>
                                            <option <?php selected($gs_email_operate, 'mailtolink'); ?> value="mailtolink"><?php esc_html_e('Using Default Mail Client', 'arsocial_lite'); ?></option>
                                        </select>&nbsp;
                                        <span class="arsocialshare_tooltip" title="<?php esc_html_e('Choose the way you want to operate mail button.', 'arsocial_lite'); ?>">(?)</span>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box"><?php esc_html_e('Edit mail message', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        
                                        <input type="hidden" name="edit_mail" id="edit_mail" value="" />
                                        <div class="arsocialshare_switch" data-id="edit_mail">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="1"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="0"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                        &nbsp;&nbsp<span class="arsocialshare_tooltip" title="<?php esc_html_e('Allow user to change email body', 'arsocial_lite'); ?>">(?)</span>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Default Email subject', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <?php
                                        $default_subject = "Visit this site [site_url]";
                                        
                                        ?>
                                        <input type="text" name="email_default_subject" class="arsocialshare_input_box" id="email_default_subject" value="<?php echo $default_subject; ?>" readonly="readonly"/>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row" style="height:200px;">
                                    <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_textarea_label"><?php esc_html_e('Default Email body', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <?php
                                        $default_body = "Hi. This may be interesting you: [site_title]! Here is the link [site_permalink]";
                                        
                                        ?>
                                        <textarea id="email_default_body" class="arsocialshare_social_textarea" cols="30" rows="8" name="email_default_body" readonly="readonly"><?php echo $default_body; ?></textarea>&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('You can customize text to display when visitors share your content by mail button. You can use following variables.', 'arsocial_lite'); ?>">(?)</span>
                                    </div>
                                </div>
                                <div class="arsocialshare_social_row" style="height:90px;">
                                    <div class="arsocialshare_social_label inner_container_box">&nbsp;</div>
                                    <div class="arsocialshare_social_input inner_container_box">
                                        <div class="arsocialshare_gs_note">
                                            <code class="arm_code_content">[site_url] - <?php esc_html_e('display site url,', 'arsocial_lite'); ?></code></div><div class="arsocialshare_clear"></div>
                                        <div class="arsocialshare_gs_note"><code class="arm_code_content">[site_title] - <?php esc_html_e('display site title,', 'arsocial_lite'); ?></code></div><div class="arsocialshare_clear"></div>
                                        <div class="arsocialshare_gs_note"><code class="arm_code_content">[site_permalink] - <?php esc_html_e('display current page url.', 'arsocial_lite'); ?></code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="arsocialshare_clear"></div>
                    <div class="arsocial_lite_locker_row_seperator"></div>
                    <div class="arsocialshare_gs_page_sub_title"><?php esc_html_e('Front-end Font Settings', 'arsocial_lite'); ?></div>
                    <div class="arsocialshare_inner_container arsocialshare_gs_inner_container">
                        <?php
                        $share_fonts = isset($gs_options['share_fonts']) ? $gs_options['share_fonts'] : 'Helvetica';
                        $like_fonts = isset($gs_options['like_fonts']) ? $gs_options['like_fonts'] : 'Helvetica';
                        $fan_fonts = isset($gs_options['fan_fonts']) ? $gs_options['fan_fonts'] : 'Helvetica';
                        $locker_fonts = isset($gs_options['locker_fonts']) ? $gs_options['locker_fonts'] : 'Helvetica';
                        ?>
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Share Button Font', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <select class="arsocialshare_dropdown" id="ars_share_fonts" name="share_fonts">
                                    <?php if (!empty($arsFonts)): ?>
                                        <?php foreach ($arsFonts as $fkey => $fdata): 
                                                if($fdata['label'] == 'Default Fonts') {
                                            ?>
                                            <?php // $google_fonts = ( $fdata['label'] == 'Google Fonts' ) ? '<span class=ars_lite_pro_version_info> pro </span>' : ''; ?>
                                            <optgroup label="<?php echo $fdata['label']; ?>">
                                                <?php foreach ($fdata['fonts'] as $key => $font): ?>
                                                    <option value="<?php echo $key; ?>" <?php selected($key, $share_fonts); ?>><?php echo $font; ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php
                                                }
                                        endforeach;
                                        ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Like Button Font', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <select class="arsocialshare_dropdown" id="ars_like_fonts" name="like_fonts">
                                    <?php if (!empty($arsFonts)): ?>
                                        <?php foreach ($arsFonts as $fkey => $fdata):
                                                if($fdata['label'] == 'Default Fonts') {
                                            ?>
                                            <optgroup label="<?php echo $fdata['label']; ?>">
                                                <?php foreach ($fdata['fonts'] as $key => $font): ?>
                                                    <option value="<?php echo $key; ?>" <?php selected($key, $like_fonts); ?>><?php echo $font; ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php 
                                                }
                                        endforeach;
                                        ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Fan Counter Font', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <select class="arsocialshare_dropdown" id="ars_fan_fonts" name="fan_fonts">
                                    <?php if (!empty($arsFonts)): ?>
                                        <?php foreach ($arsFonts as $fkey => $fdata):
                                                if($fdata['label'] == 'Default Fonts') {
                                            ?>
                                            <optgroup label="<?php echo $fdata['label']; ?>">
                                                <?php foreach ($fdata['fonts'] as $key => $font): ?>
                                                    <option value="<?php echo $key; ?>" <?php selected($key, $fan_fonts); ?>><?php echo $font; ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php 
                                                }
                                        endforeach;
                                        ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                     
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Locker Font', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <select class="arsocialshare_dropdown" id="ars_locker_fonts" name="locker_fonts">
                                    <?php if (!empty($arsFonts)): ?>
                                        <?php foreach ($arsFonts as $fkey => $fdata): 
                                                if($fdata['label'] == 'Default Fonts') {
                                            ?>
                                            <optgroup label="<?php echo $fdata['label']; ?>">
                                                <?php foreach ($fdata['fonts'] as $key => $font): ?>
                                                    <option value="<?php echo $key; ?>" <?php selected($key, $locker_fonts); ?>><?php echo $font; ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php 
                                                }
                                            endforeach;
                                            ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="arsocialshare_clear"></div>
                    <div class="arsocial_lite_locker_row_seperator"></div>
                    <div class="arsocialshare_gs_page_sub_title"><?php esc_html_e('Load JS & CSS in all pages', 'arsocial_lite'); ?></div>
                    <div class="arsocialshare_gs_page_sub_title">
                        <span style="font-size:14px;">( <?php echo esc_html__('Not recommended', 'arsocial_lite') . ' - ' . esc_html__('If you have any js/css loading issue in your theme, only in that case you should enable this settings', 'arsocial_lite') ?> )</span>
                    </div>
                    <div class="arsocialshare_inner_container arsocialshare_gs_inner_container">
                        <?php
                        $share_assets = isset($gs_options['global_share_assets']) ? $gs_options['global_share_assets'] : 0;
                        $like_assets = isset($gs_options['global_like_assets']) ? $gs_options['global_like_assets'] : 0;
                        $fan_assets = isset($gs_options['global_fan_assets']) ? $gs_options['global_fan_assets'] : 0;
                        $locker_assets = isset($gs_options['global_locker_assets']) ? $gs_options['global_locker_assets'] : 0;
                        ?>
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Social Share', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <input type="hidden" name="global_share_assets" id="global_share_assets_input" value="<?php echo $share_assets; ?>" />
                                <div class="arsocialshare_switch <?php echo ($share_assets == 1) ? "selected" : ""; ?>" data-id="global_share_assets_input">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="1"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="0"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Social Like', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <input type="hidden" name="global_like_assets" id="global_like_assets_input" value="<?php echo $like_assets; ?>" />
                                <div class="arsocialshare_switch <?php echo ($like_assets == 1) ? "selected" : ""; ?>" data-id="global_like_assets_input">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="1"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="0"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Social Fan Counter', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <input type="hidden" name="global_fan_assets" id="global_fan_assets_input" value="<?php echo $fan_assets; ?>" />
                                <div class="arsocialshare_switch <?php echo ($fan_assets == 1) ? "selected" : ""; ?>" data-id="global_fan_assets_input">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="1"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="0"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="arsocialshare_social_row">
                            <div class="arsocialshare_social_label inner_container_box arsocialshare_gs_label"><?php esc_html_e('Social Locker', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input inner_container_box">
                                <input type="hidden" name="global_locker_assets" id="global_locker_assets_input" value="<?php echo $locker_assets; ?>" />
                                <div class="arsocialshare_switch <?php echo ($locker_assets == 1) ? "selected" : ""; ?>" data-id="global_locker_assets_input">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="1"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="0"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" style="margin:15px 0 0 270px;" name="update_arsocialshare_gs" id="update_arsocialshare_gs" class="arsocialshare_save_display_settings" value="true"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
                <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="arsocialshare_save_loader" />
            </div>
        </div>
    </div>
</form>

<div class="ars_lite_upgrade_modal" id="ars_lite_general_settings_premium_notice" style="display:none;">
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