<?php
if (!defined('FW'))
    die('Forbidden');

$sp_counters 	= !empty($atts['sp_counters']) ? $atts['sp_counters'] : array();
$color 			= !empty($atts['color']) ? $atts['color'] : '';
$flag 			= rand(999, 999999);

$txtcolor	= !empty( $color ) ? 'style=color:'.$color : '';
?>
<div class="sp-sc-counter tg-haslayout">
    <?php if (!empty($sp_counters)) { ?>
        <div id="tg-counters-<?php echo esc_attr($flag); ?>" class="tg-counters">
            <?php
            foreach ($sp_counters as $key => $counter) {
                $counter_title = !empty($counter['counter_title']) ? $counter['counter_title'] : '0';
                $counter_value_from = !empty($counter['counter_value_from']) ? $counter['counter_value_from'] : '0';
                $counter_value_to = !empty($counter['counter_value_to']) ? $counter['counter_value_to'] : '0';
                $counter_speed = !empty($counter['counter_speed']) ? $counter['counter_speed'] : '0';
                $counter_interval = !empty($counter['counter_interval']) ? $counter['counter_interval'] : '0';
                ?>
                <div class="tg-countercontent">
                    <?php if (!empty($counter_value_from) || !empty($counter_value_to) && !empty($counter_interval) && !empty($counter_speed)) { ?>
                        <h3 <?php echo esc_attr( $txtcolor );?> data-from="<?php echo intval($counter_value_from); ?>" data-to="<?php echo intval($counter_value_to); ?>" data-speed="<?php echo intval($counter_speed); ?>" data-refresh-interval="<?php echo intval($counter_interval); ?>"></h3>
                    <?php } ?>
                    <?php if (!empty($counter_title)) { ?>
                        <h4 <?php echo esc_attr( $txtcolor );?>><?php echo esc_html($counter_title); ?></h4>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php
        $script = "
            jQuery('#tg-counters-".esc_js($flag)."').appear(function () {
                jQuery('.tg-countercontent h3').countTo({
                 formatter: function (value, options) {
                  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                 }
                });
            });
        ";
        wp_add_inline_script('listingo_callbacks', $script, 'after');
        ?>
    <?php } ?>
</div>