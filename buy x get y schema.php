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
    'required'   => array( 'product_id', 'quantity', 'discount_value', 'discount_type' ),
    'properties' => array(
        'product_id' => $base_product_schema['properties']['product_id'],
        'title' => $base_product_schema['properties']['product_name'],
        'quantity'   => $base_product_schema['properties']['quantity'],
        'discount_value' => $offer_schema['properties']['discount_value'],
        'discount_type' => $offer_schema['properties']['discount_type'],
    ),
);

$bxgy_schema = array(
	'$schema'    => 'http://json-schema.org/draft-04/schema#',
	'title'      => $this->post_type,
	'type'       => 'object',
	'properties' => array(
		'id'                                   => array(
			'description' => __( 'Unique identifier for campaign.', 'revenue' ),
			'type'        => 'integer',
			'context'     => $context,
			'readonly'    => true,
		),

		'name'                        => array(
			'description' => __( 'Campaign name.', 'revenue' ),
			'type'        => 'string',
			'context'     => $context,
		),

		'type'                        => array(
			'description' => __( 'campaign type.', 'revenue' ),
			'type'        => 'string',
			'default'     => 'bundle',
			'context'     => $context,
		),

		'status'                      => array(
			'description' => __( 'campaign status', 'revenue' ),
			'type'        => 'string',
			'default'     => 'draft',
			'enum'        => array( 'draft', 'published' ),
			'context'     => $context,
		),

		'created_at_gmt'                     => array(
			'description' => __( 'The date the campaign was created, as GMT.', 'revenue' ),
			'type'        => 'date-time',
			'context'     => $context,
			'readonly'    => true,
		),

		'updated_at_gmt'                    => array(
			'description' => __( 'The date the campaign was last modified, as GMT.', 'revenue' ),
			'type'        => 'date-time',
			'context'     => $context,
			'readonly'    => true,
		),
		// admin panel option - Display In.
		'trigger_type'                => array(
			'description' => __( 'campaign trigger type', 'revenue' ),
			'type'        => 'string',
			'enum'        => array(
				'products',
				'products_plus_specific_products',
				'products_plus_specific_category',
				'specific_products',
				'specific_category',
				'all_products',
			),
			'context'     => $context,
		),

		'trigger_products_id' => array(
			'description' => __( 'List of product IDs that trigger the campaign', 'revenue' ),
			'type'        => 'array',
			'context'     => $context,
			'items'       => array(
				'type' => 'integer',
			),
		),

		'trigger_exclude_products_id'       => array(
			'description' => __( 'List of product IDs to exclude from triggers', 'revenue' ),
			'type'        => 'array',
			'context'     => $context,
			'items'       => array(
				'type' => 'integer',
			),
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

		'offer_scope'                             => array(
			'description' => __( 'Offer on', 'revenue' ),
			'type'        => 'string',
			'context'     => $context,
			'enum'        => array( 'all_product', 'specific_product' ),
		),

		'products'                               => array(
			'description' => __( 'List of Offered products (one entry per product)', 'revenue' ),
			'type'        => 'array',
			'context'     => $context,
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'id' => array(
						'description' => __( 'Product ID (used to fetch product from DB)', 'revenue' ),
						'type'        => 'integer',
						'context'     => $context,
					),
					'title' => array(
						'description' => __( 'Product title (editable label)', 'revenue' ),
						'type'        => 'string',
						'context'     => $context,
					),
					'quantity' => array(
						'description' => __( 'Quantity for this offered product', 'revenue' ),
						'type'        => 'integer',
						'context'     => $context,
						'default'     => 1,
						'minimum'     => 1,
					),
				),
			),
		),

		// Global offer used when 'offer_on' === 'all_product'
		'offer_all' => array(
			'description' => __( 'Offer details when campaign applies to all products', 'revenue' ),
			'type'        => 'object',
			'context'     => $context,
			'properties'  => array(
				'offer_value' => array(
					'description' => __( 'Offer value applied to all products', 'revenue' ),
					'type'        => 'string',
					'context'     => $context,
				),
				'offer_type' => array(
					'description' => __( 'Offer type applied to all products', 'revenue' ),
					'type'        => 'string',
					'enum'        => array( 'percentage', 'fixed', 'fixed_price' ),
					'context'     => $context,
				),
			),
		),
		'y_products' => array(
			'description' => __( 'List of Y products (one entry per product)', 'revenue' ),
			'type'        => 'array',
			'context'     => $context,
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'id' => array(
						'description' => __( 'Product ID (used to fetch product from DB)', 'revenue' ),
						'type'        => 'integer',
						'context'     => $context,
					),
					'title' => array(
						'description' => __( 'Product title (editable label)', 'revenue' ),
						'type'        => 'string',
						'context'     => $context,
					),
					'offered_quantity' => array(
						'description' => __( 'Quantity for this offered product', 'revenue' ),
						'type'        => 'integer',
						'context'     => $context,
						'default'     => 1,
						'minimum'     => 1,
					),
					'offer_value' => array(
						'description' => __( 'Offer value applied to all products', 'revenue' ),
						'type'        => 'string',
						'context'     => $context,
					),
					'offer_type' => array(
						'description' => __( 'Offer type applied to all products', 'revenue' ),
						'type'        => 'string',
						'enum'        => array( 'percentage', 'fixed', 'fixed_price' ),
						'context'     => $context,
					),
				),
			),
		),

		'text_settings' => array(
			'description' => __( 'Text settings for bundle display', 'revenue' ),
			'type'        => 'object',
			'context'     => $context,
			'properties'  => array(
				'heading' => array(
					'description' => __( 'Main heading text', 'revenue' ),
					'type'        => 'string',
					'context'     => $context,
				),
				'subheading' => array(
					'description' => __( 'Subheading text', 'revenue' ),
					'type'        => 'string',
					'context'     => $context,
				),
				'button_text' => array(
					'description' => __( 'Call-to-action button text', 'revenue' ),
					'type'        => 'string',
					'context'     => $context,
				),
				'badge_text' => array(
					'description' => __( 'Optional badge label text', 'revenue' ),
					'type'        => 'string',
					'context'     => $context,
				),
				
				// Note: The following fields are reserved for future use and not currently editable,
				// but we keep them in the schema for reference and potential future expansion.
				// PE said not needed, we will give custom work for specific user for this.
				// 'free_shipping_message' => array(
				// 	'description' => __( 'Free shipping message shown to customers', 'revenue' ),
				// 	'type'        => 'string',
				// 	'context'     => $context,
				// ),
				// 'upsell_product_message' => array(
				// 	'description' => __( 'Message shown for upsell products', 'revenue' ),
				// 	'type'        => 'string',
				// 	'context'     => $context,
				// ),
				// 'free_gift_message' => array(
				// 	'description' => __( 'Message shown for free gift items', 'revenue' ),
				// 	'type'        => 'string',
				// 	'context'     => $context,
				// ),
			),
		),

		'countdown_settings' => array(
			'description' => __( 'Countdown timer settings', 'revenue' ),
			'type'        => 'object',
			'context'     => $context,
			'properties'  => array(
				'enabled' => array(
					'description' => __( 'Whether countdown is enabled', 'revenue' ),
					'type'        => 'boolean',
					'default'     => false,
					'context'     => $context,
				),
				'duration_minutes' => array(
					'description' => __( 'Countdown duration in minutes', 'revenue' ),
					'type'        => 'integer',
					'context'     => $context,
				),
				'is_evergreen' => array(
					'description' => __( 'Whether the timer is evergreen (per-user)', 'revenue' ),
					'type'        => 'boolean',
					'default'     => false,
					'context'     => $context,
				),
				'message' => array(
					'description' => __( 'Message displayed with countdown timer', 'revenue' ),
					'type'        => 'string',
					'context'     => $context,
				),
			),
		),
		'placement_settings' => array(
			'description' => __( 'Placement Settings', 'revenue' ),
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
			'description' => __( 'Campaign Time Schedule End Time status', 'revenue' ),
			'type'        => 'boolean',
			'default'     => false,
			'context'     => $context,
		),
		'schedule_start_date' => array(
			'description' => __( 'Campaign Schedule start date', 'revenue' ),
			'type'        => 'date-time',
			'context'     => $context,
		),
		'schedule_start_time' => array(
			'description' => __( 'Campaign Schedule start time', 'revenue' ),
			'type'        => 'date-time',
			'context'     => $context,
		),
		'schedule_end_date' => array(
			'description' => __( 'Campaign Schedule end date', 'revenue' ),
			'type'        => 'date-time',
			'context'     => $context,
		),
		'schedule_end_time' => array(
			'description' => __( 'Campaign Schedule end time', 'revenue' ),
			'type'        => 'date-time',
			'context'     => $context,
		),

		// Cart / product interaction settings
		'skip_add_to_cart' => array(
			'description' => __( 'Skip Add to cart button for offered products', 'revenue' ),
			'type'        => 'boolean',
			'default'     => false,
			'context'     => $context,
		),
		'is_quantity_selector_enabled' => array(
			'description' => __( 'Enabled Quantity selector for offered products', 'revenue' ),
			'type'        => 'boolean',
			'default'     => false,
			'context'     => $context,
		),
		'offered_product_on_cart_action' => array(
			'description' => __( 'If the offered products are already in cart action', 'revenue' ),
			'type'        => 'string',
			'enum'        => array( 'do_nothing', 'hide' ),
			'context'     => $context,
		),
		'offered_product_click_action' => array(
			'description' => __( 'Action if click on product title or image', 'revenue' ),
			'type'        => 'string',
			'enum'        => array( 'go_to_product_page', 'do_nothing' ),
			'context'     => $context,
		),
		'additional_id' => array(
			'description' => __( 'Additional CSS id', 'revenue' ),
			'type'        => 'string',
			'context'     => $context,
		),
		'additional_class' => array(
			'description' => __( 'Additional CSS class', 'revenue' ),
			'type'        => 'string',
			'context'     => $context,
		),

		// Animated Add to Cart settings
		'add_to_cart_animation_type' => array(
			'description' => __( 'Campaign animated add to cart animation type', 'revenue' ),
			'type'        => 'string',
			'context'     => $context,
			'enum'        => array_keys( revenue()->get_campaign_animated_add_to_cart_animation_types() ),
		),
		'delay_between_loop' => array(
			'description' => __( 'Delay between animation loops', 'revenue' ),
			'type'        => 'string',
			'context'     => $context,
		),

		// Design settings
		'design_settings' => array(
			'description' => __( 'Design and theme settings for the bundle display', 'revenue' ),
			'type'        => 'object',
			'context'     => $context,
			'properties'  => array(
				'template_type' => array(
					'description' => __( 'Template style', 'revenue' ),
					'type'        => 'string',
					'enum'        => array( 'light', 'dark' ),
					'context'     => $context,
				),
				'template_size' => array(
					'description' => __( 'Template size', 'revenue' ),
					'type'        => 'string',
					'enum'        => array( 'small', 'medium', 'large' ),
					'context'     => $context,
				),
				'theme_colors' => array(
					'description' => __( 'Color code (hex or rgb)', 'revenue' ),
					'type'        => 'string',
					'context'     => $context,
				),
			),
		),
	),
	'oneOf' => array(
		array(
			'properties' => array(
				'offer_on' => array(
					'enum' => array( 'specific_product' ),
				),
				'y_products' => array(
					'type' => 'array',
					'items' => array(
						'type' => 'object',
						'required' => array( 'id', 'discount_value', 'discount_type' ),
						'properties' => array(
							'id' => array( 'type' => 'integer' ),
							'discount_value' => array( 'type' => 'number' ),
							'discount_type' => array( 'type' => 'string', 'enum' => array( 'percentage', 'fixed', 'fixed_price' ) ),
						),
					),
				),
			),
			'required' => array( 'offer_on', 'y_products' ),
		),
		array(
			'properties' => array(
				'offer_on' => array(
					'enum' => array( 'all_product' ),
				),
				'offer_all' => array(
					'type' => 'object',
					'required' => array( 'offer_value', 'offer_type' ),
					'properties' => array(
						'offer_value' => array( 'type' => 'string' ),
						'offer_type' => array( 'type' => 'string', 'enum' => array( 'percentage', 'fixed', 'fixed_price' ) ),
					),
				),
			),
			'required' => array( 'offer_on', 'offer_all' ),
		),
	),
);
