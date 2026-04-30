<?php

$offer_type_enum = array(
    'percentage',
    'fixed_unit_discount',
    'fixed_total_discount',
    'fixed_unit_price',
    'fixed_total_price',
    'no_discount',
    'free',
);
$context = array( 'view', 'edit' );
$base_product_schema = array(
	'type'       => 'object',
	'required'   => array( 'product_id', 'quantity' ),
	'context'     => $context,
	'properties' => array(
		'product_id' => array(
			'description' => __('Product ID.', 'revenue'),
			'type'        => 'integer',
			'context'     => $context,
		),
		'product_name' => array(
			'description' => __('Editable product name.', 'revenue'),
			'type'        => 'string',
			'context'     => $context,
		),
		'quantity'   => array(
			'description' => __('Product quantity.', 'revenue'),
			'type'        => 'integer',
			'context'     => $context,
			'default'     => 1,
			'minimum'     => 1,
		),
	),
);

$offer_schema = array(
    'type'       => 'object',
    'required'   => array( 'discount_value', 'discount_type' ),
	'context'     => $context,
    'properties' => array(
        'discount_value' => array(
            'description' => __('Offer value applied to all products', 'revenue'),
            'type'        => 'number',
            'context'     => $context,
        ),
        'discount_type' => array(
            'description' => __('Offer type applied to all products', 'revenue'),
            'type'        => 'string',
            'enum'        => $offer_type_enum,
            'context'     => $context,
        ),
    ),
);

$animation_types = array(
	'wobble' => __( 'Wobble', 'revenue' ),
	'shake'  => __( 'Shake', 'revenue' ),
	'zoom'   => __( 'Zoom', 'revenue' ),
	'pulse'  => __( 'Pulse', 'revenue' ),
);
$stock_scarcity_schema = array(
	'$schema'    => 'http://json-schema.org/draft-04/schema#',
	'title'      => $this->post_type,
	'type'       => 'object',
	'properties' => array(
		'id'                                   => array(
            'description' => __('Unique identifier for campaign.', 'revenue'),
            'type'        => 'integer',
            'context'     => $context,
            'readonly'    => true,
        ),

        'name'                        => array(
            'description' => __('Campaign name.', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
        ),

        'type'                        => array(
            'description' => __('campaign type.', 'revenue'),
            'type'        => 'string',
            'default'     => 'stock_scarcity',
            'context'     => $context,
        ),

        'status'                      => array(
            'description' => __('campaign status', 'revenue'),
            'type'        => 'string',
            'default'     => 'draft',
            'enum'        => array( 'draft', 'published' ),
            'context'     => $context,
        ),

        'target_page' => array(
            'description' => __('Where the campaign will be displayed', 'revenue'),
            'type'        => 'string',
            'enum'        => array(
                'product',
                'cart',
                'checkout',
                'thank_you',
                'my_account',
                'shop',
                'home',
                'custom',
            ),
            'context'     => $context,
        ),

        // optional if target_page is 'custom', used to store the custom page ID.
        // Future extension: We can consider allowing multiple custom pages in the future,
        // in which case this could be an array of page IDs instead of a single integer.
        'custom_page_id' => array(
            'description' => __('Page ID when target_page is custom', 'revenue'),
            'type'        => 'integer',
            'context'     => $context,
        ),

        'created_at_gmt'                     => array(
            'description' => __('The date the campaign was created, as GMT.', 'revenue'),
            'type'        => 'date-time',
            'context'     => $context,
            'readonly'    => true,
        ),

        'updated_at_gmt'                    => array(
            'description' => __('The date the campaign was last modified, as GMT.', 'revenue'),
            'type'        => 'date-time',
            'context'     => $context,
            'readonly'    => true,
        ),

        'trigger_type'                => array(
            'description' => __('campaign trigger type', 'revenue'),
            'type'        => 'string',
            'enum'        => array(
                'specific_products',
                'specific_category',
                'all_products',
            ),
            'context'     => $context,
        ),

        'trigger_ids' => array(
            'description' => __('List of product IDs that trigger the campaign', 'revenue'),
            'type'        => 'array',
            'context'     => $context,
            'items'       => array(
                'type' => 'integer',
            ),
        ),

		// will have values when categories or all product is selected from the trigger type.
        'excluded_product_ids'      => array(
            'description' => __('List of product IDs to exclude from triggers', 'revenue'),
            'type'        => 'array',
            'context'     => $context,
            'items'       => array(
                'type' => 'integer',
            ),
        ),

        'stock_scarcity_settings' => array(
            'description' => __('Stock scarcity display and behavior settings', 'revenue'),
            'type'        => 'object',
            'context'     => $context,
            'properties'  => array(
                'message_type' => array(
                    'description' => __('Stock scarcity message type', 'revenue'),
                    'type'        => 'string',
                    'enum'        => array( 'general', 'flip' ),
                    'context'     => $context,
                ),
                'in_stock_message' => array(
                    'description' => __('In stock message', 'revenue'),
                    'type'        => 'string',
                    'context'     => $context,
                ),
                'enable_fake_stock' => array(
                    'description' => __('Enable fake stock values', 'revenue'),
                    'type'        => 'boolean',
                    'default'     => false,
                    'context'     => $context,
                ),
                'fake_stock_quantity' => array(
                    'description' => __('Fake stock quantity used when fake stock is enabled', 'revenue'),
                    'type'        => 'integer',
                    'minimum'     => 0,
                    'context'     => $context,
                ),
                
                'enable_stock_bar' => array(
                    'description' => __('Enable stock bar display', 'revenue'),
                    'type'        => 'boolean',
                    'default'     => false,
                    'context'     => $context,
                ),
                'should_repeat' => array(
                    'description' => __('Interval for stock value updates (e.g., "5s" for 5 seconds)', 'revenue'),
                    'type'        => 'string',
                    'context'     => $context,
                ),
                'general_message_settings' => array(
                    'description' => __('General message settings for stock scarcity', 'revenue'),
                    'type'        => 'object',
                    'context'     => $context,
                    'properties'  => array(
                        'low_stock_alert_enabled'    => array( 'description' => __('Enable low stock alert', 'revenue'),    'type' => 'boolean', 'default' => false, 'context' => $context ),
                        'low_stock_message'          => array( 'description' => __('Low stock alert message', 'revenue'),   'type' => 'string',  'context' => $context ),
                        'low_stock_quantity'         => array( 'description' => __('Low stock threshold quantity', 'revenue'), 'type' => 'integer', 'minimum' => 0, 'context' => $context ),
                        'urgent_stock_alert_enabled' => array( 'description' => __('Enable urgent stock alert', 'revenue'), 'type' => 'boolean', 'default' => false, 'context' => $context ),
                        'urgent_stock_alert_message' => array( 'description' => __('Urgent stock alert message', 'revenue'), 'type' => 'string', 'context' => $context ),
                        'urgent_stock_alert_quantity'=> array( 'description' => __('Urgent stock alert threshold quantity', 'revenue'), 'type' => 'integer', 'minimum' => 0, 'context' => $context ),
                    ),
                    // If low_stock_alert_enabled is true, message and quantity are required.
                    // If urgent_stock_alert_enabled is true, message and quantity are required.
                    'allOf' => array(
                        array( 'oneOf' => array(
                            array( 'properties' => array( 'low_stock_alert_enabled' => array( 'enum' => array( false ) ) ) ),
                            array( 'properties' => array( 'low_stock_alert_enabled' => array( 'enum' => array( true ) ) ), 'required' => array( 'low_stock_message', 'low_stock_quantity' ) ),
                        ) ),
                        array( 'oneOf' => array(
                            array( 'properties' => array( 'urgent_stock_alert_enabled' => array( 'enum' => array( false ) ) ) ),
                            array( 'properties' => array( 'urgent_stock_alert_enabled' => array( 'enum' => array( true ) ) ), 'required' => array( 'urgent_stock_alert_message', 'urgent_stock_alert_quantity' ) ),
                        ) ),
                    ),
                ),
                'flip_message_settings' => array(
                    'description' => __('Flip message settings for stock scarcity', 'revenue'),
                    'type'        => 'object',
                    'context'     => $context,
                    'required'    => array( 'first_message_type', 'first_message', 'second_message_type', 'second_message' ),
                    'properties'  => array(
                        'first_message_type'  => array( 'description' => __('First flip message type', 'revenue'),  'type' => 'string', 'enum' => array( 'stock_number', 'view_number', 'shopper_number' ), 'context' => $context ),
                        'first_message'       => array( 'description' => __('First flip message', 'revenue'),       'type' => 'string', 'context' => $context ),
                        'second_message_type' => array( 'description' => __('Second flip message type', 'revenue'), 'type' => 'string', 'enum' => array( 'stock_number', 'sales_number', 'view_number' ), 'context' => $context ),
                        'second_message'      => array( 'description' => __('Second flip message', 'revenue'),      'type' => 'string', 'context' => $context ),
                    ),
                ),
            ),
            // Conditional required fields based on message_type and enable_fake_stock.
            'allOf' => array(
                array( 'oneOf' => array(
                    array( 'properties' => array( 'message_type' => array( 'enum' => array( 'general' ) ) ), 'required' => array( 'message_type', 'enable_fake_stock', 'general_message_settings' ) ),
                    array( 'properties' => array( 'message_type' => array( 'enum' => array( 'flip' ) ) ),    'required' => array( 'message_type', 'enable_fake_stock', 'flip_message_settings' ) ),
                ) ),
                array( 'oneOf' => array(
                    array( 'properties' => array( 'enable_fake_stock' => array( 'enum' => array( false ) ) ) ),
                    array( 'properties' => array( 'enable_fake_stock' => array( 'enum' => array( true ) ) ), 'required' => array( 'fake_stock_quantity' ) ),
                ) ),
            ),
        ),

        'countdown_settings' => array(
            'description' => __('Countdown timer settings', 'revenue'),
            'type'        => 'object',
            'context'     => $context,
            'properties'  => array(
                'is_enabled' => array(
                    'description' => __('Whether countdown is enabled', 'revenue'),
                    'type'        => 'boolean',
                    'default'     => false,
                    'context'     => $context,
                ),
                'duration_minutes' => array(
                    'description' => __('Countdown duration in minutes', 'revenue'),
                    'type'        => 'integer',
                    'context'     => $context,
                ),
                'is_evergreen' => array(
                    'description' => __('Whether the timer is evergreen (per-user)', 'revenue'),
                    'type'        => 'boolean',
                    'default'     => false,
                    'context'     => $context,
                ),
                'message' => array(
                    'description' => __('Message displayed with the countdown timer', 'revenue'),
                    'type'        => 'string',
                    'context'     => $context,
                ),
            ),
        ),
        'placement_settings' => array(
            'description' => __('Placement Settings', 'revenue'),
            'type'        => 'object',
            'context'     => $context,
            'required'    => array( 'position' ),
            'properties'  => array(
                'position' => array(
                    'description' => __('Position where the widget is displayed', 'revenue'),
                    'type'        => 'string',
                    'context'     => $context,
                ),
            ),
        ),

        // Schedule settings
        'schedule_end_time_enabled' => array(
            'description' => __('Campaign Time Schedule End Time status', 'revenue'),
            'type'        => 'boolean',
            'default'     => false,
            'context'     => $context,
        ),
        'schedule_start_date' => array(
            'description' => __('Campaign Schedule start date', 'revenue'),
            'type'        => 'date-time',
            'context'     => $context,
        ),
        'schedule_start_time' => array(
            'description' => __('Campaign Schedule start time', 'revenue'),
            'type'        => 'date-time',
            'context'     => $context,
        ),
        'schedule_end_date' => array(
            'description' => __('Campaign Schedule end date', 'revenue'),
            'type'        => 'date-time',
            'context'     => $context,
        ),
        'schedule_end_time' => array(
            'description' => __('Campaign Schedule end time', 'revenue'),
            'type'        => 'date-time',
            'context'     => $context,
        ),

        // Cart / product interaction settings
        'skip_add_to_cart' => array(
            'description' => __('Skip Add to cart button for offered products', 'revenue'),
            'type'        => 'boolean',
            'default'     => false,
            'context'     => $context,
        ),
        'allow_quantity' => array(
            'description' => __('Enabled Quantity selector for offered products', 'revenue'),
            'type'        => 'boolean',
            'default'     => false,
            'context'     => $context,
        ),
        'in_cart_behavior' => array(
            'description' => __('If the offered products are already in cart action', 'revenue'),
            'type'        => 'string',
            'enum'        => array( 'do_nothing', 'hide' ),
            'context'     => $context,
        ),
        'product_click_action' => array(
            'description' => __('Action if click on product title or image', 'revenue'),
            'type'        => 'string',
            'enum'        => array( 'go_to_product_page', 'do_nothing' ),
            'context'     => $context,
        ),
        'css_id' => array(
            'description' => __('Additional CSS id', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
        ),
        'css_class' => array(
            'description' => __('Additional CSS class', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
        ),

        // Animated Add to Cart settings
        'add_to_cart_animation' => array(
            'description' => __('Campaign animated add to cart animation type', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
            'enum'        => array_keys($animation_types),
        ),
        'animation_loop_delay' => array(
            'description' => __('Delay between animation loops', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
        ),

        // Design settings
        'design_settings' => array(
            'description' => __('Design and theme settings for the bundle display', 'revenue'),
            'type'        => 'object',
            'context'     => $context,
            'properties'  => array(
                'template_type' => array(
                    'description' => __('Template style', 'revenue'),
                    'type'        => 'string',
                    'enum'        => array( 'light', 'dark' ),
                    'context'     => $context,
                ),
                'template_size' => array(
                    'description' => __('Template size', 'revenue'),
                    'type'        => 'string',
                    'enum'        => array( 'small', 'medium', 'large' ),
                    'context'     => $context,
                ),
                'theme_colors' => array(
                    'description' => __('Color code (hex or rgb)', 'revenue'),
                    'type'        => 'string',
                    'context'     => $context,
                ),
            ),
        ),
	),
    // Restrict position options based on target_page.
    'allOf' => array(
        array(
            'oneOf' => array(
                array(
                    'properties' => array(
                        'target_page' => array( 'enum' => array( 'product' ) ),
                        'placement_settings' => array(
                            'properties' => array(
                                'position' => array( 'enum' => array( 'below_product_title', 'below_price', 'before_add_to_cart_button' ) ),
                            ),
                        ),
                    ),
                ),
                array(
                    'properties' => array(
                        'target_page' => array(
                            'enum' => array( 'cart', 'checkout', 'thank_you', 'my_account', 'shop', 'home', 'custom' ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
