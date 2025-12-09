<?php

/**
 *
 * 管理画面設定
 *
 */

//=================================================
// ダッシュボードのカラム設定　※デフォルト
//=================================================
// カラム数選択を表示させる
function custom_screen_layout_columns( $columns ) {
	$columns['dashboard'] = 3;
	return $columns;
}
add_filter('screen_layout_columns','custom_screen_layout_columns');

// コラム数のデフォルトを2にする
function columns_layout_dashboard(){
	return 2;
}
add_filter('get_user_option_screen_layout_dashboard', 'columns_layout_dashboard');


//=================================================
// ツールバーに項目を追加する
//=================================================
function add_adminbar_menu($wp_admin_bar) {
	// Booking Package追加
  $wp_admin_bar->add_node( array(
    'id'    => 'booking-package_top_bar',        // 任意のid
    'title' => '<span class="add-icon ab-icon dashicons-calendar-alt" aria-hidden="true"></span><span class="ab-label">予約管理</span>',
  ));
	// 制作事例追加
  $wp_admin_bar->add_node( array(
    'id'    => 'menu-posts-result',        // 任意のid
    'title' => '<span class="add-icon ab-icon dashicons-buddicons-topics" aria-hidden="true"></span><span class="ab-label">制作事例</span>',
		'href'  => 'edit.php?post_type=result' //URL
  ));

//   //サブメニュー
//   $wp_admin_bar->add_menu(array(
//     'parent' => 'bar_new_menu',   // 親となるメニューid
//     'id'     => 'new_menu_child', // サブメニューid
//     'title'  => 'サブメニュー01', // 表示するテキスト
//     'href'   => 'https://example.com/' //URL
//   ));
}
add_action('admin_bar_menu', 'add_adminbar_menu', 500);


//=================================================
// ダッシュボードにウィジェットを追加する
//=================================================
//
// よく使う機能を追加　※カスタマイザー(未実装)
// 
function add_custom_widget() {
  if ( is_user_logged_in() && current_user_can('level_10') ){ //管理者ユーザがログインしている場合
    echo 
		'<ul class="custom_widget" style="margin-left: auto;margin-right: auto;">
			<li><a href="edit.php"><div class="dashicons dashicons-edit"></div><p>投稿</p></a></li>
			<li><a href="plugin-install.php"><div class="dashicons dashicons-admin-plugins"></div><p>プラグイン追加</p></a></li>
			<li><a href="theme-editor.php"><div class="dashicons dashicons-code-standards"></div><p>テーマエディタ</p></a></li>
			<li><a href="customize.php"><div class="dashicons dashicons-welcome-widgets-menus"></div><p>カスタマイズ</p></a></li>
    </ul>';
  }
}

function add_my_widget() {
  wp_add_dashboard_widget( 'custom_widget', 'よく使う機能', 'add_custom_widget' );
}
add_action( 'wp_dashboard_setup', 'add_my_widget' );

// 
// カスタムウィジェットを追加　※カスタマイザー(未実装)
// 
function custom_add_dashboard_widgets() {
	wp_add_dashboard_widget(
	'custom_dashboard_widget',
	'タイトルを記入する',
	'custom_dashboard_widget_function'
	);
}
function custom_dashboard_widget_function() {
	echo '
	<h1>ここに内容を記入する</h1>
	<p>HTMLで自由な内容を書けます。</p>
	';
}
add_action('wp_dashboard_setup', 'custom_add_dashboard_widgets');

// 
// WordPress/PHP/プラグインの情報をダッシュボードに追加　※デフォルト
// 
add_action( 'wp_dashboard_setup', function() {
	if ( current_user_can( 'manage_options' ) ) {
		wp_add_dashboard_widget(
			'swell-site-status',
			'サイト情報',
			__NAMESPACE__ . '\dashboard_site_status',
			null,
			null,
			'normal',
			'high'
		);
	}
} );
function dashboard_site_status() {
	echo '<h3>' . esc_html( 'バージョン情報') . '</h3>';
	echo '<div class="__row"><span>WordPress</span>: <b>' . esc_html( get_bloginfo( 'version' ) ) . '</b></div>';

	echo '<div class="__row"><span>PHP</span>: <b>' . esc_html( phpversion() ) . '</b></div>';

	echo '<hr>';
	echo '<h3>' . esc_html( '有効化中のプラグイン一覧' ) . '</h3>';
	
	// require_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( ! function_exists( 'get_plugins' ) ) return;
	
	$_active_plugins=array();
	
	$plugins = get_plugins();
	foreach ( $plugins as $path => $plugin ) {
		if ( is_plugin_active( $path ) ) {
			$_active_plugins[ $path ] = [
				'name' => $plugin['Name'],
				'ver'  => $plugin['Version'],
			];
		}
	}
	
	if ( empty( $_active_plugins ) ) {
		echo esc_html__( '有効なプラグインはありません。', 'swell' );
	} else {
		$all = '';
		foreach ( $_active_plugins as $path => $plugin ) {
			$all .= '<div class="__plugin">' . $plugin['name'] . ' <small>(v.' . $plugin['ver'] . ')</small></div>';
		}
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $all;
	}
}

// 
// ダッシュボードのアクティビティに投稿、固定ページ、カスタム投稿を含める　※カスタマイザー(未実装)
// 
function custom_dashboard_recent_posts_query_args($query_args) {
  $query_args['post_type'] = array('post'); // array('post','page','カスタム投稿名')
  if ($query_args['post_status'] === 'publish') {
    $query_args['posts_per_page'] = 5;
  }
  return $query_args;
}
add_filter('dashboard_recent_posts_query_args', 'custom_dashboard_recent_posts_query_args', 10, 1);

// 
// ダッシュボードのウィジェット名を変更する　※デフォルト
// 
function custom_dashboard_widget_names() {
	global $wp_meta_boxes;

	// ウィジェット1の変更
	$dashboard_position_1 = 'dashboard';
	$target_widget_name_1 = 'dashboard_activity';
	$new_widget_name_1 = '最近の投稿記事';
	$wp_meta_boxes[$dashboard_position_1]['normal']['core'][$target_widget_name_1]['title'] = $new_widget_name_1;

	// ウィジェット2の変更
	// $dashboard_position_2 = 'dashboard';
	// $target_widget_name_2 = 'wc_admin_dashboard_setup';
	// $new_widget_name_2 = 'ショップ設定';
	// $wp_meta_boxes[$dashboard_position_2]['normal']['core'][$target_widget_name_2]['title'] = $new_widget_name_2;
}
add_action('wp_dashboard_setup', 'custom_dashboard_widget_names');

