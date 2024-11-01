<?php

global $arslite_newdbversion, $wpdb, $arsocial_lite, $arsocial_lite_forms;
if (version_compare($arslite_newdbversion, '1.2', '<')) {
    $share_global_settings = maybe_unserialize(get_option('arslite_networks_display_setting'));
    if (isset($share_global_settings['display']['sidebar'])) {
        $sidebar_skin = isset($share_global_settings['display']['sidebar']['skin']) ? $share_global_settings['display']['sidebar']['skin'] : 'default';
        switch ($sidebar_skin) {
            case 'default':
                $share_global_settings['display']['sidebar']['skin'] = 'lite_default';
                break;
            case 'square':
                $share_global_settings['display']['sidebar']['skin'] = 'lite_square';
                break;
        }
    }
    if (isset($share_global_settings['display']['top_bottom_bar'])) {
        $top_bottom_bar_skin = isset($share_global_settings['display']['top_bottom_bar']['skin']) ? $share_global_settings['display']['top_bottom_bar']['skin'] : 'default';
        switch ($top_bottom_bar_skin) {
            case 'default':
                $share_global_settings['display']['top_bottom_bar']['skin'] = 'lite_default';
                break;
            case 'square':
                $share_global_settings['display']['top_bottom_bar']['skin'] = 'lite_square';
                break;
        }
    }
    if (isset($share_global_settings['display']['page'])) {
        $page_skin = isset($share_global_settings['display']['page']['skin']) ? $share_global_settings['display']['page']['skin'] : 'default';
        switch ($page_skin) {
            case 'default':
                $share_global_settings['display']['page']['skin'] = 'lite_default';
                break;
            case 'square':
                $share_global_settings['display']['page']['skin'] = 'lite_square';
                break;
        }
    }
    if (isset($share_global_settings['display']['post'])) {
        $post_skin = isset($share_global_settings['display']['post']['skin']) ? $share_global_settings['display']['post']['skin'] : 'default';
        switch ($post_skin) {
            case 'default':
                $share_global_settings['display']['post']['skin'] = 'lite_default';
                break;
            case 'square':
                $share_global_settings['display']['post']['skin'] = 'lite_square';
                break;
        }
    }
    update_option('arslite_networks_display_setting', maybe_serialize($share_global_settings));
    $table = $arsocial_lite->arslite_networks;
    $results = $wpdb->get_results("SELECT * FROM `$table`");
    if (isset($results) && !empty($results)) {
        foreach ($results as $key => $value) {
            $display_settings = maybe_unserialize($value->display_settings);
            $updated_date = current_time('mysql');
            $display_type = isset($display_settings['arsocialshare_display_type']) ? $display_settings['arsocialshare_display_type'] : 'on_page';
            $selected_skin = isset($display_settings['arsocialshare_share_settings_skins']) ? $display_settings['arsocialshare_share_settings_skins'] : 'default';
            switch ($selected_skin) {
                case 'default':
                    $display_settings['arsocialshare_share_settings_skins'] = 'lite_default';
                    break;
                case 'square':
                    $display_settings['arsocialshare_share_settings_skins'] = 'lite_square';
                    break;
            }
            $query = $wpdb->prepare("UPDATE `$table` SET  display_settings = '" . maybe_serialize($display_settings) . "', last_updated_date='" . $updated_date . "' WHERE network_id = %d", $value->network_id);
            $wpdb->query($query);

        }
    }
$old_square_theme = ARSOCIAL_LITE_THEME_CSS_DIR .'/arsocialshare_theme-square.css';
unlink($old_square_theme);
}
if( version_compare($arslite_version,'1.3','<')){
    global $arsocial_lite;
    $args = array(
        'role' => 'administrator',
        'fields' => 'id'
    );
    $users = get_users($args);
    if( count($users) > 0 ){
        foreach($users as $key => $user_id ){
            
            $arsshare_role = $arsocial_lite->ARSocialShareCapabilities();
    
            $userObj = new WP_User($user_id);
            foreach ($arsshare_role as $arsrole => $arsroledescription){
                $userObj->add_cap($arsrole);
            }
            unset($arsrole);
            unset($arsroles);
            unset($arsroledescription);
        }
    }
}
if( version_compare( $arslite_version, '1.4', '<') ){
    global $arsocial_lite, $wpdb;

    $arsocial_lite_settings = maybe_unserialize( get_option('arslite_settings') );

    if( !empty( $arsocial_lite_settings ) ){
        if( !empty( $arsocial_lite_settings['network']['goolgeplus'] ) ){
            unset( $arsocial_lite_settings['network']['goolgeplus'] );
        }
        if( !empty( $arsocial_lite_settings['network']['dig'] ) ){
            unset( $arsocial_lite_settings['network']['dig'] );
        }
        if( !empty( $arsocial_lite_settings['network']['stumbleupon'] ) ){
            unset( $arsocial_lite_settings['network']['stumbleupon'] );
        }
        if( !empty( $arsocial_lite_settings['network']['citeulike'] ) ){
            unset( $arsocial_lite_settings['network']['citeulike'] );
        }
        if( !empty( $arsocial_lite_settings['network']['delicious'] ) ){
            unset( $arsocial_lite_settings['network']['delicious'] );
        }

        $arsocial_lite_settings['networks']['mix'] = array(
            'enable' => 0,
            'displayname' => 'Mix',
            'display_order' => 6,
            'custom_name' => 'Mix',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );

        $new_socialshare_settings = maybe_serialize( $arsocial_lite_settings );

        update_option( 'arslite_settings', $new_socialshare_settings );
    }

    $arslite_global_settings = maybe_unserialize( get_option( 'arslite_global_settings' ) );

    if( !empty( $arslite_global_settings ) ){
            
        if( !empty( $arslite_global_settings['google'] ) ){
            unset( $arslite_global_settings['google'] );
        }

        $new_arslite_global_settings = maybe_serialize( $arslite_global_settings );

        update_option( 'arslite_global_settings', $new_arslite_global_settings );
    }

    $arslite_order = get_option( 'arslite_global_like_order' );

    if( !empty( $arslite_order ) ){

        foreach( $arslite_order as $k => $v ){
            if( 'googleplus' == $v || 'googleplus_follow' == $v ){
                unset( $arslite_order[$k] );
            }
        }

        $new_arslite_order = array_values( $arslite_order );

        update_option( 'arslite_global_like_order', $new_arslite_order );
    }

    $arslite_display_settings = maybe_unserialize( get_option( 'arslite_like_display_settings' ) );

    if( !empty( $arslite_display_settings ) ){

        if( isset( $arslite_display_settings['googleplus'] ) ){
            unset( $arslite_display_settings['googleplus'] );
        }
        if( isset( $arslite_display_settings['googleplus_follow'] ) ){
            unset( $arslite_display_settings['googleplus_follow'] );
        }

        $new_arslite_display_settings = maybe_serialize( $arslite_display_settings );

        update_option( 'arslite_like_display_settings', $new_arslite_display_settings );
    }

    $arslite_locker_display_settings = maybe_unserialize( get_option( 'arslite_locker_display_settings' ) );

    if( !empty( $arslite_locker_display_settings ) ){

        if( isset( $arslite_locker_display_settings['social']['is_gp_locker'] ) ) { $arslite_locker_display_settings['social']['is_gp_locker']; }
        if( isset( $arslite_locker_display_settings['social']['is_gp_counter'] ) ) { $arslite_locker_display_settings['social']['is_gp_counter']; }
        if( isset( $arslite_locker_display_settings['social']['gp_url'] ) ) { $arslite_locker_display_settings['social']['igp_url']; }
        if( isset( $arslite_locker_display_settings['social']['is_gp_share'] ) ) { $arslite_locker_display_settings['social']['is_gp_share']; }
        if( isset( $arslite_locker_display_settings['social']['gp_url_share'] ) ) { $arslite_locker_display_settings['social']['gp_url_share']; }
        if( isset( $arslite_locker_display_settings['social']['is_gp_share_counter'] ) ) { $arslite_locker_display_settings['social']['is_gp_share_counter']; }
        if( isset( $arslite_locker_display_settings['social']['is_gp_signin'] ) ) { $arslite_locker_display_settings['social']['is_gp_signin']; }
        if( isset( $arslite_locker_display_settings['social']['is_gp_save_email'] ) ) { $arslite_locker_display_settings['social']['is_gp_save_email']; }
        if( isset( $arslite_locker_display_settings['social']['is_gp_create_account'] ) ) { $arslite_locker_display_settings['social']['is_gp_create_account']; }

        $new_arslite_locker_display_settings = maybe_serialize( $arslite_locker_display_settings );

        update_option( 'arslite_locker_display_settings', $new_arslite_locker_display_settings );
    }

    $arslite_fan_counter_order = get_option( 'arslite_global_fancounter_order' );
    if( !empty( $arslite_fan_counter_order ) ){
        foreach( $arslite_fan_counter_order as $k => $network_name ){
            if( 'google_plus' == $network_name || 'delicious' == $network_name || 'vine' == $network_name ){
                unset( $arslite_fan_counter_order[$k] );
            }
        }
        $new_arslite_fan_order = array_values( $arslite_fan_counter_order );

        update_option( 'arslite_global_fancounter_order', $new_arslite_fan_order );
    }

    $arslite_fan_display_settings = maybe_unserialize( get_option( 'arslite_fan_display_settings' ) );
    if( !empty( $arslite_fan_display_settings ) ){
        if( isset( $arslite_fan_display_settings['google_plus'] ) ){
            unset( $arslite_fan_display_settings['google_plus'] );
        }

        foreach( $arslite_fan_display_settings['display']['active_network'] as $ki => $network_name ){
            if( 'googleplus' == $network_name ){
                unset( $arslite_fan_display_settings['display']['active_network'][$ki] );
            }
        }
    }

    $share_global_settings = maybe_unserialize( get_option( 'arslite_networks_display_setting' ) );
    if( !empty( $share_global_settings ) ){

        foreach( $share_global_settings['networks'] as $k => $network_name ){
            if( 'googleplus' == $network_name || 'dig' == $network_name || 'delicious' == $network_name ){
                unset( $share_global_settings['networks'][$k] );
            }
        }

        if( isset( $share_global_settings['network_display_name']['googleplus'] ) ){ unset( $share_global_settings['network_display_name']['googleplus'] ); }
        if( isset( $share_global_settings['network_display_name']['digg'] ) ){ unset( $share_global_settings['network_display_name']['digg'] ); }
        if( isset( $share_global_settings['network_display_name']['delicious'] ) ){ unset( $share_global_settings['network_display_name']['delicious'] ); }
        if( isset( $share_global_settings['network_display_name']['stumbleupon'] ) ){ unset( $share_global_settings['network_display_name']['stumbleupon'] ); }
        if( isset( $share_global_settings['network_display_name']['citeulike'] ) ){ unset( $share_global_settings['network_display_name']['citeulike'] ); }

        $share_global_settings['network_display_name']['mix'] = 'Mix';

        update_option( 'arslite_networks_display_setting', maybe_serialize( $share_global_settings ) );

    }

    $share_tables = $wpdb->get_results( "SELECT network_id, network_settings FROM `" . $arsocial_lite->arslite_networks . "` ORDER BY network_id DESC" );

    $share_unset_networks = array( 'googleplus', 'digg', 'delicious', 'stumbleupon', 'citeulike' );

    if( !empty( $share_tables ) ){
        foreach( $share_tables as $k => $share_table_data ){
            $network_id = $share_table_data->network_id;

            $network_settings = maybe_unserialize( $share_table_data->network_settings );

            foreach( $network_settings['enabled_network'] as $ki => $network_name ){
                if( in_array( $network_name, $share_unset_networks ) ){
                    unset( $network_settings['enabled_network'][$ki] );
                }
            }

            if( !empty( $network_settings['custom_name']['gooleplus'] ) ){
                unset( $network_settings['custom_name']['gooleplus'] );
            }
            if( !empty( $network_settings['custom_name']['digg'] ) ){
                unset( $network_settings['custom_name']['digg'] );
            }
            if( !empty( $network_settings['custom_name']['delicious'] ) ){
                unset( $network_settings['custom_name']['delicious'] );
            }
            if( !empty( $network_settings['custom_name']['stumbleupon'] ) ){
                unset( $network_settings['custom_name']['stumbleupon'] );
            }
            if( !empty( $network_settings['custom_name']['citeulike'] ) ){
                unset( $network_settings['custom_name']['citeulike'] );
            }

            $network_settings['custom_name']['mix'] = 'Mix';

            $sorted_order = explode( ',', $network_settings['sort_order'] );

            foreach( $sorted_order as $kj => $network_name ){
                if( in_array( $network_name, $share_unset_networks ) ){
                    unset( $sorted_order[$kj] );
                }
            }

            $new_sorted_order = array_values( $sorted_order );

            $network_settings['sort_order'] = implode( ',' , $new_sorted_order );

            $new_network_settings = maybe_serialize( $network_settings );

            $wpdb->update(
                $arsocial_lite->arslite_networks,
                array(
                    'network_settings' => $new_network_settings
                ),
                array(
                    'network_id' => $network_id
                )
            );

        }
    }

    $locker_tables = $wpdb->get_results( "SELECT ID, locker_options FROM `" . $arsocial_lite->arslite_locker . "` ORDER BY ID DESC" );

    if( !empty( $locker_tables ) ){
        foreach( $locker_tables as $k => $locker_table_data ){
            $locker_id = $locker_table_data->ID;

            $locker_options = maybe_unserialize( $locker_table_data->locker_options );

            if( isset( $locker_options['social']['is_gp_locker'] ) ){
                unset( $locker_options['social']['is_gp_locker'] );
            }

            if( isset( $locker_options['social']['gp_url'] ) ){
                unset( $locker_options['social']['gp_url'] );
            }

            if( isset( $locker_options['social']['is_gp_counter'] ) ){
                unset( $locker_options['social']['is_gp_counter'] );
            }

            if( isset( $locker_options['social']['is_gp_share'] ) ){
                unset( $locker_options['social']['is_gp_share'] );
            }

            if( isset( $locker_options['social']['gp_url_share'] ) ){
                unset( $locker_options['social']['gp_url_share'] );
            }

            if( isset( $locker_options['social']['is_gp_share_counter'] ) ){
                unset( $locker_options['social']['is_gp_share_counter'] );
            }

            if( isset( $locker_options['social']['is_gp_signin'] ) ){
                unset( $locker_options['social']['is_gp_signin'] );
            }

            if( isset( $locker_options['social']['is_gp_save_email'] ) ){
                unset( $locker_options['social']['is_gp_save_email'] );
            }

            if( isset( $locker_options['social']['is_gp_create_account'] ) ){
                unset( $locker_options['social']['is_gp_create_account'] );
            }

            foreach( $locker_options['display']['selected_network'] as $ki => $network_name ){
                if( 'googleplus' == $network_name ){
                    unset( $locker_options['display']['selected_network'][$ki] );
                }
            }

            $kjn = 0;
            foreach( $locker_options['display']['arsocial_lite_locker_share_networks'] as $kj => $network_name ){
                if( 'googleplus' == $network_name || 'google_share' == $network_name ){
                    unset( $locker_options['display']['arsocial_lite_locker_share_networks'][$kj] );
                } else {
                    $locker_options['display']['arsocial_lite_locker_share_networks'][$kjn] = $network_name;
                    $kjn++;
                }
            }

            foreach( $locker_options['display']['arsocial_lite_locker_signin_networks'] as $kk => $network_name ){
                if( 'arsocial_lite_locker_option_box_wrapper_gp' == $network_name ){
                    unset( $locker_options['display']['arsocial_lite_locker_signin_networks'][$kk] );
                } else {
                    $locker_options['display']['arsocial_lite_locker_signin_networks'][$kjn] = $network_name;
                    $kjn++;
                }
            }

            $new_locker_options = maybe_serialize( $locker_options );

            $wpdb->update(
                $arsocial_lite->arslite_locker,
                array(
                    'locker_options' => $new_locker_options
                ),
                array(
                    'ID' => $locker_id
                )
            );
        }
    }

    $like_tables = $wpdb->get_results( "SELECT ID, content FROM `" . $arsocial_lite->arslite_like . "` ORDER BY ID DESC");

    if( !empty( $like_tables ) ){
        foreach( $like_tables as $k => $like_table_data ){
            $like_id = $like_table_data->ID;

            $like_options = maybe_unserialize( $like_table_data->content );

            if( !empty( $like_options['googleplus'] ) ){
                $like_options['googleplus'];
            }

            if( !empty( $like_options['googleplus_follow'] ) ){
                $like_options['googleplus_follow'];
            }

            foreach( $like_options['display']['selected_network'] as $ki => $network_name ){
                if( 'googleplus' == $network_name || 'googleplus_follow' == $network_name ){
                    unset( $like_options['display']['selected_network'][$ki] );
                }
            }

            $new_like_display_network = array_values( $like_options['display']['selected_network'] );

            $like_options['display']['selected_network'] = $new_like_display_network;

            foreach( $like_options['display']['network_order'] as $kj => $network_name ){
                if( 'googleplus' == $network_name || 'googleplus_follow' == $network_name ){
                    unset( $like_options['display']['network_order'][$kj] );
                }
            }

            $new_like_network_order = array_values( $like_options['display']['network_order'] );

            $like_options['display']['network_order'] = $new_like_network_order;

            $new_like_options = maybe_serialize( $like_options );

            $wpdb->update(
                $arsocial_lite->arslite_like,
                array(
                    'content' => $new_like_options
                ),
                array(
                    'ID' => $locker_id
                )
            );
        }
    }

    $fan_tables = $wpdb->get_results( "SELECT ID, content FROM `" . $arsocial_lite->arslite_fan . "` ORDER BY ID DESC " );

    if( !empty( $fan_tables ) ){
        foreach( $fan_tables as $k => $fan_table_data ){
            $fan_id = $fan_table_data->ID;

            $fan_options = maybe_unserialize( $fan_table_data->content );

            if( isset( $fan_options['google_plus'] ) ){
                unset( $fan_options['google_plus'] );
            }

            foreach( $fan_options['display']['active_network'] as $ki => $network_name ){
                if( 'googleplus' == $network_name ){
                    unset( $fan_options['display']['active_network'][$ki] );
                }
            }

            $fan_options['display']['active_network'] = array_values( $fan_options['display']['active_network'] );

            foreach( $fan_options['display']['fan_network_order'] as $kj => $network_name ){
                if( 'google_plus' == $network_name || 'delicious' == $network_name || 'vine' == $network_name ){
                    unset( $fan_options['display']['fan_network_order'][$kj] );
                }
            }

            $fan_options['display']['fan_network_order'] = array_values( $fan_options['display']['fan_network_order'] );

            $new_fan_options = maybe_serialize( $fan_options );

            $wpdb->update(
                $arsocial_lite->arslite_fan,
                array(
                    'content' => $new_fan_options
                ),
                array(
                    'ID' => $fan_id
                )
            );

        }
    }
}


$arslite_newdbversion = '1.4.1';
update_option('arslite_version', $arslite_newdbversion);
update_option('arsociallite_updated_date_' . $arslite_newdbversion, current_time( 'mysql' ) );
?>