<?php

// function remove_menus () {
//     if (current_user_can('administrator')) { //管理者ではない場合
//         remove_menu_page( 'index.php' );                  // ダッシュボードを非表示
//         remove_menu_page( 'edit.php' );                   // 投稿を非表示
//         remove_menu_page( 'upload.php' );                 // メディアを非表示
//         remove_menu_page( 'edit.php?post_type=page' );    // 固定ページを非表示
//         remove_menu_page( 'edit-comments.php' );          // コメントを非表示
//         remove_menu_page( 'themes.php' );                 // 外観を非表示
//         remove_menu_page( 'plugins.php' );                // プラグインを非表示
//         remove_menu_page( 'users.php' );                  // ユーザーを非表示
//         remove_menu_page( 'tools.php' );                  // ツールを非表示
//         remove_menu_page( 'options-general.php' );        // 設定を非表示
//     }
// }
// add_action('admin_menu', 'remove_menus');

// function remove_menus () {
//     if (current_user_can('administrator')) { //管理者ではない場合
//         global $menu;
//         unset($menu[2]);  // ダッシュボード
//         unset($menu[4]);  // メニューの線1
//         unset($menu[5]);  // 投稿
//         unset($menu[10]); // メディア
//         unset($menu[15]); // リンク
//         unset($menu[20]); // ページ
//         unset($menu[25]); // コメント
//         unset($menu[59]); // メニューの線2
//         unset($menu[60]); // テーマ
//         unset($menu[65]); // プラグイン
//         unset($menu[70]); // プロフィール
//         unset($menu[75]); // ツール
//         unset($menu[80]); // 設定
//         unset($menu[90]); // メニューの線3
//     }
// }
// add_action('admin_menu', 'remove_menus');


//=================================================
// 不要な表示オプションを非表示にする
//=================================================
// function my_remove_meta_boxes() {
//   remove_meta_box('authordiv', 'post', 'normal'); // オーサー
//   remove_meta_box('categorydiv', 'post', 'normal'); // カテゴリー
//   remove_meta_box('commentstatusdiv', 'post', 'normal'); // ディスカッション
//   remove_meta_box('commentsdiv', 'post', 'normal'); // コメント
//   remove_meta_box('formatdiv', 'post', 'normal'); // フォーマット
//   remove_meta_box('pageparentdiv', 'post', 'normal'); // ページ属性
//   remove_meta_box('postcustom', 'post', 'normal'); // カスタムフィールド
//   remove_meta_box('postexcerpt', 'post', 'normal'); // 抜粋
//   remove_meta_box('postimagediv', 'post', 'normal'); // アイキャッチ
//   remove_meta_box('revisionsdiv', 'post', 'normal'); // リビジョン
//   remove_meta_box('slugdiv', 'post', 'normal'); // スラッグ
//   remove_meta_box('tagsdiv-post_tag', 'post', 'normal'); // タグ
//   remove_meta_box('trackbacksdiv', 'post', 'normal'); // トラックバック
// }
// add_action('admin_menu', 'my_remove_meta_boxes');


//=================================================
// 投稿編集画面で不要な項目を非表示にする
//=================================================
function custom_remove_post_support() {
	if ( ! current_user_can( 'administrator' ) ) {
	  // remove_post_type_support('post','title');           // タイトル
	  // remove_post_type_support('post','editor');          // 本文
	  // remove_post_type_support('post','author');          // 作成者
	  // remove_post_type_support('post','thumbnail');       // アイキャッチ画像
		remove_post_type_support('post','excerpt');         // 抜粋
	//   remove_post_type_support('post','trackbacks');      // トラックバック
	//   remove_post_type_support('post','custom-fields');   // カスタムフィールド
	//   remove_post_type_support('post','comments');        // コメント
	//   remove_post_type_support('post','revisions');       // リビジョン
	//   remove_post_type_support('post','page-attributes'); // 表示順
	//   remove_post_type_support('post','post-formats');    // 投稿フォーマット
		// unregister_taxonomy_for_object_type( 'category', 'post' ); // カテゴリー
		unregister_taxonomy_for_object_type( 'post_tag', 'post' ); // タグ
	}
}
add_action('init','custom_remove_post_support');

// 投稿のメタボックスを非表示にする
function custom_remove_post_metabox() {
	if ( ! current_user_can( 'administrator' ) ) {
		// remove_meta_box( 'submitdiv', 'page', 'side' ); // 公開
		// remove_meta_box( 'postcustom','page','normal' ); // カスタムフィールド
		remove_meta_box( 'commentstatusdiv','post','normal' ); // ディスカッション
		remove_meta_box( 'slugdiv','post','normal' ); // スラッグ
		remove_meta_box( 'authordiv','post','normal' ); // 投稿者
		remove_meta_box( 'pageparentdiv', 'post', 'normal' ); // ページ属性
		remove_meta_box( 'revisionsdiv-rev-ctl','post','normal' ); // リビジョン
	}
}
add_action('add_meta_boxes','custom_remove_post_metabox');



//=================================================
// ブロックエディター（Gutenberg）で特定のメタボックスや要素を非表示にする
//=================================================
function custom_admin_styles() {
	if ( ! current_user_can( 'administrator' ) ) {
    echo 
		'<style>
			/* 以下に非表示にしたい要素のCSSクラスやIDを指定 */
			#arkhe_toolkit_meta__side,
			#arkhe_toolkit_meta__code {
				display: none !important;
			}
    </style>';
	}
}
add_action('admin_head', 'custom_admin_styles');


//=================================================
// ツールバー全体の非表示
//=================================================
// add_filter( 'show_admin_bar', '__return_false' );


//=================================================
// ツールバーの項目を非表示にする
//=================================================
function remove_adminbar($wp_admin_bar) {
		$wp_admin_bar->remove_menu('wp-logo'); // WPロゴ
		$wp_admin_bar->remove_menu('comments'); // コメント
		$wp_admin_bar->remove_menu('new-content'); // 新規
  if ( ! current_user_can( 'administrator' ) ) {
		$wp_admin_bar->remove_menu('customize'); // カスタマイズ
    $wp_admin_bar->remove_menu('arkhe_blocks'); // ARKHE BLOCKS
    $wp_admin_bar->remove_menu('arkhe_toolkit'); // ARKHE TOOLKIT
    $wp_admin_bar->remove_menu('booking-package_top_bar_schedule'); // Booking Package カレンダーアカウント
    $wp_admin_bar->remove_menu('booking-package_top_bar_setting'); // Booking Package 一般設定
    // $wp_admin_bar->remove_menu('edit-profile'); // プロフィールを編集
  }
}
add_action('admin_bar_menu', 'remove_adminbar', 500);


//=================================================
// ダッシュボードの項目を非表示にする
//=================================================
function remove_dashboard_widget() {
    remove_action( 'welcome_panel', 'wp_welcome_panel' ); // ウェルカムパネル
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // クイックドラフト
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // WordPress イベントとニュース
		// remove_meta_box( 'booking-package', 'dashboard', 'normal' ); // Booking Package
    // remove_meta_box( 'custom_dashboard_widget', 'dashboard', 'normal' ); // カスタムウィジェット
	if ( ! current_user_can( 'administrator' ) ) {
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // 概要
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // アクティビティ
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'side' ); // サイトヘルスステータス
  }
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widget' );


//=================================================
// WP更新の通知を非表示　※デフォルト
//=================================================
function no_update_notice() {
  if ( ! current_user_can('administrator' ) ) {
    remove_action( 'admin_notices', 'update_nag', 3 );
  }
}
add_action( 'admin_init', 'no_update_notice' );


//=================================================
// プラグイン更新の通知を非表示　※デフォルト
//=================================================
function custom_admin_menu() {
  if ( ! current_user_can( 'administrator' ) ) {
    remove_submenu_page( 'index.php', 'update-core.php' ); // 更新
  }
}
add_action( 'admin_menu', 'custom_admin_menu' );


//=================================================
// ヘッダー,フッターの非表示
//=================================================
// add_filter( 'arkhe_part_path__header', function() {
//   return '';
// } );

// add_filter( 'arkhe_part_path__footer', function() {
//   return '';
// } );













/**
 *
 * メニューの表示非表示
 * 管理者
 *
 */

//=================================================
// メニューを非表示にする
//=================================================

	// function remove_menus () {
	// 		// remove_menu_page ('index.php'); // ダッシュボード
	// 		// remove_menu_page ('edit.php'); // 投稿
	// 		// remove_menu_page ('upload.php'); // メディア
	// 		// remove_menu_page( 'edit.php?post_type=page' ); // 固定ページ
	// 		// remove_menu_page ('edit-comments.php'); // コメント
	// 		// remove_menu_page ('themes.php'); // 外観
	// 		// remove_menu_page ('plugins.php'); // プラグイン
	// 		// remove_menu_page ('users.php'); // ユーザー
	// 		// remove_menu_page ('tools.php'); // ツール
	// 		// remove_menu_page ('options-general.php'); // 設定
	// 		}
	// add_action('admin_menu', 'remove_menus');

	// function remove_plugin_menus () {
	// 		// remove_menu_page ('arkhe_toolkit_settings'); // Arkhe Toolkit
	// 		// remove_menu_page ('arkhe_blocks_settings'); // Arkhe Block
	// 		// remove_menu_page ('edit.php?post_type=wp_block'); // 再利用ブロック
	// 		// remove_menu_page ('ssp_main_setting'); // SEO SIMPLE PACK
	// 		// remove_menu_page( 'wpcf7' ); // Contact Form 7. メインメニュー.
	// 		// remove_menu_page( 'edit.php?post_type=acf-field-group' ); // Advanced Custom Fields. メインメニュー.
	// 		// remove_menu_page( 'cptui_main_menu' ); // Custom Post Type UI. メインメニュー.
	// 		// remove_submenu_page( 'options-general.php', 'duplicatepost' ); // Duplicate Post. 設定.
	// 		// remove_menu_page ('filebird-settings'); // FileBird
	// 		// remove_menu_page ('ai1wm_export'); // All-in-One WP Migration
	// 	}
	// add_action('admin_menu', 'remove_plugin_menus');


//=================================================
// 投稿画面の項目を非表示にする
//=================================================
	// function remove_meta_boxes_post() {
	// 		// remove_meta_box( 'categorydiv','post','side'); // カテゴリー
	// 		// remove_meta_box( 'postcustom' , 'post' , 'normal' ); // カスタムフィールド
	// 		// remove_meta_box( 'postexcerpt' , 'post' , 'normal' ); // 抜粋
	// 		// remove_meta_box( 'commentsdiv' , 'post' , 'normal' ); // コメント
	// 		// remove_meta_box( 'tagsdiv-post_tag' , 'post' , 'side' ); // タグ
	// 		// remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' ); // トラックバック
	// 		// remove_meta_box( 'commentstatusdiv' , 'post' , 'normal' ); // ディスカッション
	// 		// remove_meta_box( 'slugdiv','post','normal'); // スラッグ
	// 		// remove_meta_box( 'authordiv','post','normal' ); // 作成者
	// 		// remove_meta_box( 'revisionsdiv','post','normal' ); // リビジョン
	// 	}
	// add_action( 'admin_menu' , 'remove_meta_boxes_post' );

//=================================================
// 固定ページの項目を非表示にする
//=================================================
	// function remove_meta_boxes_page() {
	// 		 // remove_meta_box( 'postcustom' , 'page' , 'normal' ); // カスタムフィールド
	// 		 // remove_meta_box( 'postexcerpt' , 'page' , 'normal' ); // 抜粋
	// 		 // remove_meta_box( 'commentsdiv' , 'page' , 'normal' ); // コメント
	// 		 // remove_meta_box( 'tagsdiv-post_tag' , 'page' , 'side' ); // タグ
	// 		 // remove_meta_box( 'trackbacksdiv' , 'page' , 'normal' ); // トラックバック
	// 		 // remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' ); // ディスカッション
	// 		 // remove_meta_box( 'slugdiv','page','normal'); // スラッグ
	// 		 // remove_meta_box( 'authordiv','page','normal' ); // 作成者
	// 		 // remove_meta_box( 'revisionsdiv','page','normal' ); // リビジョン
	// 		 // remove_meta_box( 'pageparentdiv','page','side'); // ページ属性
	// 	 }
	//  add_action( 'admin_menu' , 'remove_meta_boxes_page' );
