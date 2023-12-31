<?php

$all_plugins = get_plugins();
$active_plugins = get_option('active_plugins');
$license_status = WPWHPRO()->settings->get_license('status');
$extensions_list = WPWHPRO()->api->get_extension_list();
$plugin_update_list = get_site_transient( 'update_plugins' );
if( isset( $plugin_update_list->response ) ){
    $plugin_update_list = $plugin_update_list->response;
}

if( ! is_array( $plugin_update_list ) ){
    $plugin_update_list = array();
}

?>
<div class="wpwh-container">
    <div class="wpwh-title-area mb-4">
        <h2><?php echo __( 'Extensions for WP Webhooks Pro', 'wp-webhooks' ); ?></h2>
        <?php if( WPWHPRO()->whitelabel->is_active() && ! empty( WPWHPRO()->whitelabel->get_setting( 'wpwhpro_whitelabel_custom_text_extensions' ) ) ) : ?>
            <p><?php echo __( WPWHPRO()->whitelabel->get_setting( 'wpwhpro_whitelabel_custom_text_extensions' ), 'wp-webhooks' ); ?></p>
        <?php else : ?>
            <p><?php echo sprintf( __( 'This page contains all approved extensions for WP Webhooks Pro. You will be able to fully manage each of the extensions right within this plugin.', 'wp-webhooks' ), WPWHPRO()->settings->get_page_title() ); ?></p>
        <?php endif; ?>
    </div>

    <div class="row">
        <?php if( ! empty( $extensions_list ) ) : ?>
            <?php foreach( $extensions_list as $slug => $data ) :

            //Hide deprecated extensions
            if( isset( $data['extension_deprecated'] ) && ! empty( $data['extension_deprecated'] ) ){
                continue;
            }

            $plugin_installed = WPWHPRO()->helpers->is_plugin_installed( $data['extension_plugin_slug'] );
            $plugin_active = ( in_array( $data['extension_plugin_slug'], $active_plugins ) ) ? true : false;
            $plugin_premium = ( $data['type'] === 'premium' ) ? true : false;

            $plugin_version = 0;
            if( isset( $all_plugins[ $data['extension_plugin_slug'] ] ) ){
                $plugin_version = $all_plugins[ $data['extension_plugin_slug'] ]['Version'];
            }

            //MAke sure we only show the update button if the plugin is recognized already by the WP related logic
            $available_version = $plugin_version;
            if( isset( $plugin_update_list[ $data['extension_plugin_slug'] ] ) ){
                if( isset( $plugin_update_list[ $data['extension_plugin_slug'] ]->new_version ) ){
                    $available_version = $plugin_update_list[ $data['extension_plugin_slug'] ]->new_version;
                }
            }

            ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="wpwh-card">
                        <div class="wpwh-card__featured">
                            <img src="<?php echo esc_url( $data['thumbnail'] ); ?>" alt="<?php echo sanitize_text_field( $data['name'] ); ?>">
                        </div>
                        <div class="wpwh-card__body">
                            <h4 class="wpwh-card__title"><?php echo sanitize_text_field( $data['name'] ); ?></h4>
                            <p class="wpwh-card__subtitle">v<?php echo sanitize_text_field( $data['version'] ); ?></p>
                            <div class="wpwh-card__text">
                                <?php echo wpautop( sanitize_text_field( $data['description'] ) ); ?>
                            </div>
                            <div class="wpwh-card__actions">
                                <?php if( $plugin_installed ) : ?>
                                    <?php if( version_compare( (string) $available_version, (string) $plugin_version, '>') ) : ?>

                                        <?php if( $plugin_premium && ( $license_status === false || $license_status !== 'valid' ) ) : ?>
                                            <a
                                                class="text-primary wpwh-extension-manage"
                                                href="<?php echo get_admin_url(); ?>options-general.php?page=wp-webhooks-pro&wpwhprovrs=license"
                                                title="<?php echo __( 'Activate your licene first', 'wp-webhooks' ); ?>"
                                            >
                                                <?php echo __( 'License', 'wp-webhooks' ); ?>
                                            </a>
                                        <?php else :

                                        $update_status = ( $plugin_active ) ? 'update_active' : 'update_deactive';

                                        ?>
                                            <a
                                                href="#"
                                                class="text-primary wpwh-extension-manage"
                                                title="<?php echo sprintf( __( 'Upgrade from your current version %1$s to version %2$s', 'wp-webhooks' ), $plugin_version, $available_version ); ?>"
                                                data-wpwh-extension-id="<?php echo intval( $data['item_id'] ); ?>"
                                                data-wpwh-extension-version="<?php echo sanitize_text_field( $available_version ); ?>"
                                                data-wpwh-extension-status="<?php echo $update_status; ?>"
                                                data-wpwh-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>"
                                                data-wpwh-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>"
                                            >
                                                <span><?php echo __( 'Update', 'wp-webhooks' ); ?></span>
                                            </a>
                                        <?php endif; ?>

                                    <?php else : ?>

                                        <?php if( $plugin_active ) : ?>
                                            <a
                                                href="#"
                                                class="text-warning wpwh-extension-manage"
                                                data-wpwh-extension-status="activated"
                                                data-wpwh-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>"
                                                data-wpwh-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>"
                                            >
                                                <span><?php echo __( 'Deactivate', 'wp-webhooks' ); ?></span>
                                            </a>
                                        <?php else : ?>
                                            <a
                                                href="#"
                                                class="text-green wpwh-extension-manage"
                                                data-wpwh-extension-status="deactivated"
                                                data-wpwh-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>"
                                                data-wpwh-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>"
                                            >
                                                <span><?php echo __( 'Activate', 'wp-webhooks' ); ?></span>
                                            </a>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if( $plugin_premium && ( $license_status === false || $license_status !== 'valid' ) ) : ?>
                                        <a
                                            class="text-primary"
                                            href="<?php echo get_admin_url(); ?>options-general.php?page=wp-webhooks-pro&wpwhprovrs=license"
                                            title="<?php echo __( 'Activate your licene first', 'wp-webhooks' ); ?>"
                                        >
                                            <?php echo __( 'License', 'wp-webhooks' ); ?>
                                        </a>
                                    <?php else : ?>
                                        <a
                                            href="#"
                                            class="text-secondary wpwh-extension-manage"
                                            data-wpwh-extension="install"
                                            data-wpwh-extension-id="<?php echo intval( $data['item_id'] ); ?>"
                                            data-wpwh-extension-version="<?php echo sanitize_text_field( $data['version'] ); ?>"
                                            data-wpwh-extension-status="uninstalled"
                                            data-wpwh-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>"
                                            data-wpwh-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>"
                                        >
                                            <span><?php echo __( 'INSTALL', 'wp-webhooks' ); ?></span>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <a href="<?php echo esc_url( $data['extension_info_url'] ); ?>" target="_blank" class="text-success"><?php echo __( 'MORE INFO', 'wp-webhooks' ); ?></a>
                                <?php if( $plugin_installed ) : ?>
                                    <a
                                        href="#"
                                        class="text-danger wpwh-extension-manage text-uppercase"
                                        data-wpwh-extension="delete"
                                        data-wpwh-extension-status="delete"
                                        data-wpwh-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>"
                                        data-wpwh-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>"
                                    >
                                        <span><?php echo __( 'Delete', 'wp-webhooks' ); ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="wpwhpro-empty">
                <?php echo __( 'There are currently no extensions available.', 'wp-webhooks' ); ?>
            </div>
        <?php endif; ?>
    </div>
</div>