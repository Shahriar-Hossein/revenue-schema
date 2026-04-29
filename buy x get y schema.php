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
$product_discount_schema = array(
    'type'       => 'object',
    'required'   => array( 'product_id', 'product_name', 'quantity', 'discount_value', 'discount_type' ),
	'context'     => $context,
    'properties' => array(
        'product_id' => $base_product_schema['properties']['product_id'],
        'product_name' => $base_product_schema['properties']['product_name'],
        'quantity'   => $base_product_schema['properties']['quantity'],
        'discount_value' => $offer_schema['properties']['discount_value'],
        'discount_type' => $offer_schema['properties']['discount_type'],
    ),
);


$animation_types = array(
	'wobble' => __( 'Wobble', 'revenue' ),
	'shake'  => __( 'Shake', 'revenue' ),
	'zoom'   => __( 'Zoom', 'revenue' ),
	'pulse'  => __( 'Pulse', 'revenue' ),
);

$bxgy_schema = array(
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
            'default'     => 'bundle',
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
                'x_products',
                'x_products_plus_specific_products',
                'x_products_plus_specific_category',
                'specific_products',
                'specific_category',
                'all_products',
            ),
            'context'     => $context,
        ),

        'trigger_product_ids' => array(
            'description' => __('List of product IDs that trigger the campaign', 'revenue'),
            'type'        => 'array',
            'context'     => $context,
            'items'       => array(
                'type' => 'integer',
            ),
        ),

		// will have values when categories or all product is selected from the trigger type.
        'excluded_trigger_product_ids'      => array(
            'description' => __('List of product IDs to exclude from triggers', 'revenue'),
            'type'        => 'array',
            'context'     => $context,
            'items'       => array(
                'type' => 'integer',
            ),
        ),

		// x products.
		'x_products'                               => array(
			'description' => __( 'List of x products (one entry per product)', 'revenue' ),
			'type'        => 'array',
			'context'     => $context,
			'items'       => $base_product_schema,
		),

		// will only work for y products.
		'offer_scope'                             => array(
			'description' => __( 'Offer on', 'revenue' ),
			'type'        => 'string',
			'context'     => $context,
			'enum'        => array( 'all_product', 'specific_product' ),
		),
		// Global offer used when 'offer_on' === 'all_product'
		'offer_all' => $offer_schema,
		// conditions applied in one_of below,
		// might include discount_value and discount_type if offer_scope is specific_product level.
		'y_products' => array(
			'description' => __( 'List of Y products (one entry per product)', 'revenue' ),
			'type'        => 'array',
			'context'     => $context,
			'items'       =>  $base_product_schema,
		),

		// additional and advanced settings.
        'text_settings' => array(
            'description' => __('Text settings for bundle display', 'revenue'),
            'type'        => 'object',
            'context'     => $context,
            'properties'  => array(
                'heading' => array(
                    'description' => __('Main heading text', 'revenue'),
                    'type'        => 'string',
                    'context'     => $context,
                ),
                'subheading' => array(
                    'description' => __('Subheading text', 'revenue'),
                    'type'        => 'string',
                    'context'     => $context,
                ),
                'button_text' => array(
                    'description' => __('Call-to-action button text', 'revenue'),
                    'type'        => 'string',
                    'context'     => $context,
                ),

                // Note: The following fields are reserved for future use and not currently editable,
                // but we keep them in the schema for reference and potential future expansion.
                // PE said not needed, we will give custom work for specific user for this.
                // 'free_shipping_message' => array(
                //     'description' => __( 'Free shipping message shown to customers', 'revenue' ),
                //     'type'        => 'string',
                //     'context'     => array( 'view', 'edit' ),
                // ),
                // 'upsell_product_message' => array(
                //     'description' => __( 'Message shown for upsell products', 'revenue' ),
                //     'type'        => 'string',
                //     'context'     => array( 'view', 'edit' ),
                // ),
                // 'free_gift_message' => array(
                //     'description' => __( 'Message shown for free gift items', 'revenue' ),
                //     'type'        => 'string',
                //     'context'     => array( 'view', 'edit' ),
                // ),
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
            'oneOf' => array(
                array(
                    'properties' => array(
                        'placement_type' => array( 'enum' => array( 'in_page' ) ),
                        'position' => array( 'enum' => array( 'before_add_to_cart', 'after_add_to_cart', 'before_product', 'after_product_summary' ) ),
                    ),
                    'required' => array( 'placement_type', 'position' ),
                ),
                array(
                    'properties' => array(
                        'placement_type' => array( 'enum' => array( 'popup' ) ),
                        'position' => array( 'enum' => array( 'after_click_add_to_cart', 'after_x_time' ) ),
                        'delay_seconds' => array( 'type' => 'integer' ),
                    ),
                    'required' => array( 'placement_type', 'position', 'delay_seconds' ),
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
		'disable_coupon_field' => array(
			'description' => __('Whether to disable coupon field when this bundle is applied', 'revenue' ),
			'type'=> 'boolean',
			'default'     => false,
			'context'     => $context,
		),
		'limit_free_gift_per_order' => array(
			'description' => __('Whether to limit free gift to one per order', 'revenue' ),
			'type'        => 'boolean',
			'default'     => false,
			'context'     => $context,
		),
	),
	'oneOf' => array(
		array(
			'properties' => array(
				'offer_scope' => array(
					'enum' => array( 'specific_product' ),
				),
				'y_products' => array(
					'type' => 'array',
					'items' => $product_discount_schema,
				),
			),
			'required' => array( 'offer_scope', 'y_products' ),
		),
		array(
			'properties' => array(
				'offer_scope' => array(
					'enum' => array( 'all_product' ),
				),
				'offer_all' => $offer_schema,
				'y_products' => array(
					'type' => 'array',
					'items' => $base_product_schema
				),
			),
			'required' => array( 'offer_scope', 'offer_all', 'y_products' ),
		),
	),
);
