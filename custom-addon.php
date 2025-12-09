<?php
/**
 * Plugin name: Custom Addon v1.2.0
 * Description: Arkheをカスタマイズするための雛形プラグイン。※Rev Control,Custom Post Order,Menu-Remove追加
 * Version: 1.2.0
 * License: GPL2 or later
 *
 * このプラグインはあくまでただの雛形です。自由に編集してお使いください。
 */
defined( 'ABSPATH' ) || exit;


//=================================================
// Arkhe以外のテーマでは無効
//=================================================
	if ( 'arkhe' !== get_template() ) {
		return;
	}


//=================================================
// 定数定義
//=================================================
	define( 'CUSTOM_ADDON_URL', plugins_url( '/', __FILE__ ) ); // 末尾に「/」が付きます。
	define( 'CUSTOM_ADDON_PATH', plugin_dir_path( __FILE__ ) ); // 末尾に「/」が付きます。


//=================================================
// ファイルの読み込み（フロント用）
// ※ jquery を使用する時は、依存指定するか wp_enqueue_script('jquery') を記述してください。
//=================================================
	// add_action( 'wp_enqueue_scripts', function() {

	// 	// custom_style.css 読み込み
	// 	$time_stamp = date( 'Ymdgis', filemtime( CUSTOM_ADDON_PATH . 'assets/css/addon_style.css' ) );
	// 	wp_enqueue_style( 'addon-style', CUSTOM_ADDON_URL . 'assets/css/addon_style.css', [], $time_stamp );

	// 	// custom_script.js 読み込み
	// 	$time_stamp = date( 'Ymdgis', filemtime( CUSTOM_ADDON_PATH . 'assets/js/addon_script.js' ) );
	// 	wp_enqueue_script( 'addon-script', CUSTOM_ADDON_URL . 'assets/js/addon_script.js', [], $time_stamp, true );

	// }, 20 );


//=================================================
// ファイルの読み込み（ブロックエディター用）
//=================================================
	add_action( 'enqueue_block_editor_assets', function() {
		// addon_editor_style.css 読み込み
		$time_stamp = date( 'Ymdgis', filemtime( CUSTOM_ADDON_PATH . 'dist/css/addon_editor_style.css' ) );
		wp_enqueue_style( 'addon-editor-style', CUSTOM_ADDON_URL . 'dist/css/addon_editor_style.css', [], $time_stamp );
	}, 20 );

	add_action( 'admin_enqueue_scripts', function() {
		// addon_admin_style.css 読み込み
		$time_stamp = date( 'Ymdgis', filemtime( CUSTOM_ADDON_PATH . 'dist/css/addon_admin_style.css' ) );
		wp_enqueue_style( 'addon-admin-style', CUSTOM_ADDON_URL . 'dist/css/addon_admin_style.css', [], $time_stamp );
	}, 20 );


//=================================================
// 拡張機能読み込み
//=================================================
	// require_once __DIR__ . '/libs/rev-control/rev-control.php';   // リビジョン数制限
	// require_once __DIR__ . '/libs/custom-post-order/custom-post-order.php';   // 投稿並び替え
	require_once __DIR__ . '/libs/admin-menu/admin-menu.php';   // 管理画面メニューの非表示
	require_once __DIR__ . '/libs/blocks-animation/blocks-animation.php';   // アニメーションスタイルの追加


//=================================================
// 管理画面に「お知らせ通知アラート」を表示する
//=================================================
	// add_action('admin_notices', function() {
	//   echo <<<EOF
	//
	// <div class="notice notice-info is-dismissible">
	// 	<p>Custom Addon Ver.2を使用中</p>
	// </div>
	//
	// EOF;
	// });
