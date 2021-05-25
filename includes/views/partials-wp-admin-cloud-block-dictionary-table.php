<div class="wrap">
    <h2><?php _e( 'Cloud Block Dictionary', 'planet4-gpch-plugin-blocks' ); ?></h2>
    <div id="nds-wp-list-table-demo">
        <form method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $this->search_box( __( 'Find', 'planet4-gpch-plugin-blocks'  ), 'cloud-words-find'); ?>
			<?php $this->display(); ?>
        </form>
    </div>
</div>
