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
$schema = array(
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

		// core settings - start

		'spending_threshold' => array(
            'description' => __( 'Required spending amount to trigger the campaign', 'revenue' ),
            'type'        => 'number',
            'context'     => array( 'view', 'edit' ),
        ),
        'spending_basis' => array(
            'description' => __( 'Type of required spending amount', 'revenue' ),
            'type'        => 'string',
            // cart total including tax and shipping, or just the product subtotal ( total of product price excluding other charges ex: tax, shipping ).
            'enum'        => array( 'cart_total', 'subtotal' ),
            'context'     => array( 'view', 'edit' ),
        ),

        'display_goal_icon' => array(
            'description' => __( 'Enable progress bar display', 'revenue' ),
            'type'        => 'boolean',
            'default'     => false,
            'context'     => array( 'view', 'edit' ),
        ),

        'show_confetti' => array(
            'description' => __( 'Enable confetti animation on success', 'revenue' ),
            'type'        => 'boolean',
            'default'     => false,
            'context'     => array( 'view', 'edit' ),
        ),

        'tiers' => array(
            'description' => __( 'List of tiers for the campaign', 'revenue' ),
            'type'        => 'array',
            'context'     => array( 'view', 'edit' ),
            'items'       => array(
                'type'       => 'object',
                'properties' => array(
                    'threshold_amount' => array(
                        'description' => __( 'Spending threshold for this tier', 'revenue' ),
                        'type'        => 'number',
                        'context'     => array( 'view', 'edit' ),
                    ),
                    'reward_label' => array(
                        'description' => __( 'Label for the reward', 'revenue' ),
                        'type'        => 'string',
                        'context'     => array( 'view', 'edit' ),
                    ),
                    // will contain multiple smart tags,
                    // e.g. {remaining_amount}, {reward_type}, {discount_value}.
                    'pre_reward_message' => array(
                        'description' => __( 'Message to display when this tier is reached', 'revenue' ),
                        'type'        => 'string',
                        'context'     => array( 'view', 'edit' ),
                    ),
                    // should be used for toast notification on page.
                    'success_message' => array(
                        'description' => __( 'Message to display when this tier reward is successfully applied', 'revenue' ),
                        'type'        => 'string',
                        'context'     => array( 'view', 'edit' ),
                    ),
                ),
                'one_of' => array(
                    array(
                        'reward_type' => array(
                            'description' => __( 'Type of reward for this tier', 'revenue' ),
                            'type'        => 'string',
                            'enum'        => array( 'discount' ),
                            'context'     => array( 'view', 'edit' ),
                        ),
                        'discount_value' => array(
                            'description' => __( 'Discount value for this tier', 'revenue' ),
                            'type'        => 'number',
                            'context'     => array( 'view', 'edit' ),
                        ),
                        'discount_type' => array(
                            'description' => __( 'Discount type for this tier', 'revenue' ),
                            'type'        => 'string',
                            'enum'        => array( 'percentage', 'fixed_amount' ),
                            'context'     => array( 'view', 'edit' ),
                        ),
                    ),
                    array(
                        'reward_type' => array(
                            'description' => __( 'Type of reward for this tier', 'revenue' ),
                            'type'        => 'string',
                            'enum'        => array( 'free_product' ),
                            'context'     => array( 'view', 'edit' ),
                        ),
                        
                        'free_products' => array(
                            'description' => __( 'List of free products for this tier', 'revenue' ),
                            'type'        => 'array',
                            'context'     => array( 'view', 'edit' ),
                            'items'       => array(
                                'type'       => 'object',
                                'properties' => array(
                                    'id' => array(
                                        'description' => __( 'Product ID (used to fetch product from DB)', 'revenue' ),
                                        'type'        => 'integer',
                                        'context'     => array( 'view', 'edit' ),
                                    ),
                                    'title' => array(
                                        'description' => __( 'Product title (editable label)', 'revenue' ),
                                        'type'        => 'string',
                                        'context'     => array( 'view', 'edit' ),
                                    ),
                                    'quantity' => array(
                                        'description' => __( 'Quantity for this free product', 'revenue' ),
                                        'type'        => 'integer',
                                        'context'     => array( 'view', 'edit' ),
                                        'default'     => 1,
                                        'minimum'     => 1,
                                    ),
                                ),
                            ),
                        ),
                        'is_allow_multiple_free_products' => array(
                            'description' => __( 'Whether to allow multiple free products when the tier is triggered multiple times', 'revenue' ),
                            'type'        => 'boolean',
                            'default'     => false,
                            'context'     => array( 'view', 'edit' ),
                        ),
                        'on_hover' => array(
                            'description' => __( 'Additional info to show on hover for this tier reward', 'revenue' ),
                            'type'        => 'string',
                            'default'     => 'preview',
                            'enum'        => array( 'preview', 'none' ),
                            'context'     => array( 'view', 'edit' ),
                        ),
                    ),
                    array(
                        'reward_type' => array(
                            'description' => __( 'Type of reward for this tier', 'revenue' ),
                            'type'        => 'string',
                            'enum'        => array( 'free_shipping' ),
                            'context'     => array( 'view', 'edit' ),
                        ),  
                    ),
                ),
            ),
        ),

                    

        // this is the upsell products list.
		'offer_products'                               => array(
			'description' => __( 'List of Offered products (one entry per product)', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => $product_discount_schema,
		),

        'ultimate_goal_message' => array(
            'description' => __( 'Message to display when the ultimate goal is reached', 'revenue' ),
            'type'        => 'string',
            'context'     => array( 'view', 'edit' ),
        ),
		
		'placement_settings' => array(
			'description' => __( 'Placement Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
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
						'placement_type' => array( 'enum' => array( 'drawer' ) ),
						'position' => array( 'enum' => array( 'top_left', 'top_right', 'bottom_left', 'bottom_right' ) ),
					),
					'required' => array( 'placement_type', 'position' ),
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
);
