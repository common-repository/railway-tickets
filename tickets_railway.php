<?php
/*
Plugin Name: Railway Tickets Plugin
Plugin URI: http://tickets.ua/
Description: quick search of railway tickets
Author: Salyga Sasha
Version: 1.0
*/ 

function tickets_plugin($args) {
    extract($args, EXTR_SKIP);
    $options = get_option('tickets_plugin');
    $title = empty($options['title']) ? 'Заказать ЖД Билеты' : $options['title'];    
	$wid = empty($options['wid']) ? '255' : $options['wid'];  
?>
        <?php echo $before_widget; ?>
            <?php echo $before_title . $title . $after_title; ?>
			<div>
				<iframe src="http://widgets.tickets.ua/rail.php" width="<?php echo $wid;?>" height="192" scrolling="no" style="position:relative;z-index:2;"></iframe>
				<div style="z-index:1;position:relative;margin-top:-42px;clear:both;white-space:nowrap;font: 11px Tahoma;line-height:1em;margin-left:<?php echo $wid-110; ?>px">
					Powered by <a href="http://tickets.ua" target="_blank" style="font-weight:normal">tickets.ua</a>
				</div>
			</div>
			<br />
            <ul>
                <?php wp_register() ?>
                <li><?php wp_loginout() ?></li>
                <?php wp_meta() ?>
            </ul>
        <?php echo $after_widget; ?>
<?php
}

function tickets_plugin_control() {
    $options = $newoptions = get_option('tickets_plugin');
    if ( $_POST["tickets_plugin-submit"] ) {
        $newoptions['title'] = strip_tags(stripslashes($_POST["tickets_plugin-title"]));
		$newoptions['wid'] = strip_tags(stripslashes($_POST["tickets_plugin-wid"]));
    }
    if ( $options != $newoptions ) {
        $options = $newoptions;
        update_option('tickets_plugin', $options);
    }
    $title = htmlspecialchars($options['title'], ENT_QUOTES);
	$wid = htmlspecialchars($options['wid'], ENT_QUOTES);
?>
            <p>
            	<label for="tickets_plugin-title">
            		<?php _e('Title:'); ?> 
            	<input style="width: 250px;" id="tickets_plugin-title" name="tickets_plugin-title" type="text" value="<?php echo $title; ?>" /></label>
            </p>
			<p>
            	<label for="tickets_plugin-wid">
            		<?php _e('Ширина блока (минимально: 257):'); ?> 
            	<input style="width: 250px;" id="tickets_plugin-wid" name="tickets_plugin-wid" type="text" value="<?php echo $wid; ?>" /></label>
            </p>
            <input type="hidden" id="tickets_plugin-submit" name="tickets_plugin-submit" value="2" />
<?php
}

function tickets_plugin_init() {
    register_sidebar_widget('Railway Tickets', 'tickets_plugin');
    register_widget_control('Railway Tickets', 'tickets_plugin_control', 300, 90);
}

add_action('init', 'tickets_plugin_init');
?>