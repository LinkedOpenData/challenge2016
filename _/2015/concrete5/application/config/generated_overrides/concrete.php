<?php

/**
 * -----------------------------------------------------------------------------
 * Generated 2016-09-30T21:26:38+09:00
 *
 * @item      misc.latest_version
 * @group     concrete
 * @namespace null
 * -----------------------------------------------------------------------------
 */
return array(
    'locale' => 'ja_JP',
    'site' => 'Linked Open Data Challenge 2015',
    'version_installed' => '5.7.5.1',
    'misc' => array(
        'access_entity_updated' => 1442549717,
        'latest_version' => '5.7.5.9',
        'do_page_reindex_check' => false,
        'favicon_fid' => '31',
        'iphone_home_screen_thumbnail_fid' => '34',
        'modern_tile_thumbnail_fid' => '33',
        'modern_tile_thumbnail_bgcolor' => '',
    ),
    'permissions' => array(
        'model' => 'advanced',
    ),
    'user' => array(
        'registration' => array(
            'email_registration' => false,
            'type' => 'manual_approve',
            'captcha' => true,
            'enabled' => true,
            'approval' => true,
            'validate_email' => false,
            'notification' => '1',
            'notification_email' => 'lod-challenge@sfc.keio.ac.jp',
        ),
    ),
    'i18n' => array(
        'choose_language_login' => '1',
    ),
    'seo' => array(
        'canonical_url' => 'http://lodc.jp/2015',
        'canonical_ssl_url' => '',
        'redirect_to_canonical_url' => 1,
        'url_rewriting' => 1,
    ),
    'debug' => array(
        'detail' => 'message',
        'display_errors' => true,
    ),
    'editor' => array(
        'concrete' => array(
            'enable_filemanager' => '1',
            'enable_sitemap' => '1',
        ),
        'plugins' => array(
            'selected' => array(
                'undoredo',
                'underline',
                'concrete5lightbox',
                'specialcharacters',
                'table',
                'fontfamily',
                'fontsize',
                'fontcolor',
                'awesome',
            ),
        ),
    ),
    'accessibility' => array(
        'toolbar_titles' => true,
        'toolbar_large_font' => true,
        'display_help_system' => true,
    ),
    'cache' => array(
        'blocks' => true,
        'assets' => true,
        'theme_css' => true,
        'overrides' => true,
        'pages' => 'all',
        'full_page_lifetime' => 'default',
        'full_page_lifetime_value' => null,
    ),
    'theme' => array(
        'compress_preprocessor_output' => true,
    ),
    'mail' => array(
        'method' => 'php_mail',
    ),
);
