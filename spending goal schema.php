<?php
$schema = array(
	'$schema'    => 'http://json-schema.org/draft-04/schema#',
	'title'      => $this->post_type,
	'type'       => 'object',
	'properties' => array(
		'id'                                   => array(
			'description' => __( 'Unique identifier for campaign.', 'revenue' ),
			'type'        => 'integer',
			'context'     => array( 'view', 'edit' ),
			'readonly'    => true,
		),

		'name'                        => array(
			'description' => __( 'Campaign name.', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		'type'                        => array(
			'description' => __( 'campaign type.', 'revenue' ),
			'type'        => 'string',
			'default'     => 'bundle',
			'context'     => array( 'view', 'edit' ),
		),

		'status'                      => array(
			'description' => __( 'campaign status', 'revenue' ),
			'type'        => 'string',
			'default'     => 'draft',
			'enum'        => array( 'draft', 'published' ),
			'context'     => array( 'view', 'edit' ),
		),

		'created_at_gmt'                     => array(
			'description' => __( 'The date the campaign was created, as GMT.', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
			'readonly'    => true,
		),

		'updated_at_gmt'                    => array(
			'description' => __( 'The date the campaign was last modified, as GMT.', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
			'readonly'    => true,
		),
		'required_spending_amount' => array(
            'description' => __( 'Required spending amount to trigger the campaign', 'revenue' ),
            'type'        => 'number',
            'context'     => array( 'view', 'edit' ),
        ),
        'required_spending_amount_type' => array(
            'description' => __( 'Type of required spending amount', 'revenue' ),
            'type'        => 'string',
            // cart total including tax and shipping, or just the product subtotal ( total of product price excluding other charges ex: tax, shipping ).
            'enum'        => array( 'cart_total', 'subtotal' ),
            'context'     => array( 'view', 'edit' ),
        ),

        'is_display_goal_icon_enabled' => array(
            'description' => __( 'Enable progress bar display', 'revenue' ),
            'type'        => 'boolean',
            'default'     => false,
            'context'     => array( 'view', 'edit' ),
        ),

        'is_confetti_enabled' => array(
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
		'products'                               => array(
			'description' => __( 'List of Offered products (one entry per product)', 'revenue' ),
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
						'description' => __( 'Quantity for this offered product', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
						'default'     => 1,
						'minimum'     => 1,
					),
                    'discount_type' => array(
                        'description' => __( 'Type of discount applied to this extra product', 'revenue' ),
                        'type'        => 'string',
                        'enum'        => array( 'percentage', 'fixed_amount', 'free' ),
                        'context'     => array( 'view', 'edit' ),
                    ),
                    'discount_value' => array(
                        'description' => __( 'Discount value applied to this extra product', 'revenue' ),
                        'type'        => 'number',
                        'context'     => array( 'view', 'edit' ),
                    ),
				),
			),
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
			'description' => __( 'Campaign Time Schedule End Time status', 'revenue' ),
			'type'        => 'boolean',
			'default'     => false,
			'context'     => array( 'view', 'edit' ),
		),
		'schedule_start_date' => array(
			'description' => __( 'Campaign Schedule start date', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'schedule_start_time' => array(
			'description' => __( 'Campaign Schedule start time', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'schedule_end_date' => array(
			'description' => __( 'Campaign Schedule end date', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'schedule_end_time' => array(
			'description' => __( 'Campaign Schedule end time', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),

		// Cart / product interaction settings
		'skip_add_to_cart' => array(
			'description' => __( 'Skip Add to cart button for offered products', 'revenue' ),
			'type'        => 'boolean',
			'default'     => false,
			'context'     => array( 'view', 'edit' ),
		),
		'quantity_selector_enabled' => array(
			'description' => __( 'Enabled Quantity selector for offered products', 'revenue' ),
			'type'        => 'boolean',
			'default'     => false,
			'context'     => array( 'view', 'edit' ),
		),

		'offered_product_click_action' => array(
			'description' => __( 'Action if click on product title or image', 'revenue' ),
			'type'        => 'string',
			'enum'        => array( 'go_to_product_page', 'do_nothing' ),
			'context'     => array( 'view', 'edit' ),
		),
		'additional_id' => array(
			'description' => __( 'Additional CSS id', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'additional_class' => array(
			'description' => __( 'Additional CSS class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		// Design settings
		'design_settings' => array(
			'description' => __( 'Design and theme settings for the bundle display', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
			'properties'  => array(
				'template_type' => array(
					'description' => __( 'Template style', 'revenue' ),
					'type'        => 'string',
					'enum'        => array( 'light', 'dark' ),
					'context'     => array( 'view', 'edit' ),
				),
				'template_size' => array(
					'description' => __( 'Template size', 'revenue' ),
					'type'        => 'string',
					'enum'        => array( 'small', 'medium', 'large' ),
					'context'     => array( 'view', 'edit' ),
				),
				'theme_colors' => array(
					'description' => __( 'Color code (hex or rgb)', 'revenue' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
			),
		),
	),
);
