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

		// Core part - start

		'sections'                               => array(
			'description' => __( 'Sections containing groups of offered products', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'title' => array(
                        'description' => __( 'Section title/label', 'revenue' ),
                        'type'        => 'string',
                        'context'     => array( 'view', 'edit' ),
                    ),
                    'description' => array(
                        'description' => __( 'Section description', 'revenue' ),
                        'type'        => 'string',
                        'context'     => array( 'view', 'edit' ),
                    ),
                    // 'image' => array(
                    //     'description' => __( 'Section image URL', 'revenue' ),
                    //     'type'        => 'string',
                    //     'context'     => array( 'view', 'edit' ),
                    // ),
                    'products' => array(
						'description' => __( 'List of Offered products (one entry per product) within this section', 'revenue' ),
						'type'        => 'array',
						'context'     => array( 'view', 'edit' ),
						'items'       => $base_product_schema,
					),
					'discount_rule' => array(
						'description' => __( 'Optional discount rules for this section. If not provided, the main offer applies to products in this section.', 'revenue' ),
						'type'        => 'object',
						'context'     => array( 'view', 'edit' ),
						'oneOf'       => array(
							array(
								'properties' => array(
									'rule_type' => array(
										'description' => __( 'Type of discount rule', 'revenue' ),
										'type'        => 'string',
										'enum'        => array( 'fixed_quantity' ),
										'context'     => array( 'view', 'edit' ),
									),
									'quantity' => array(
										'description' => __( 'Fixed quantity required to trigger the discount', 'revenue' ),
										'type'        => 'integer',
										'minimum'     => 1,
										'context'     => array( 'view', 'edit' ),
									),
									'description' => array(
										'description' => __( 'Description for this rule', 'revenue' ),
										'type'        => 'string',
										'context'     => array( 'view', 'edit' ),
									),
								),
								'required' => array( 'rule_type', 'quantity' ),
							),
							array(
								'properties' => array(
									'rule_type' => array(
										'description' => __( 'Type of discount rule', 'revenue' ),
										'type'        => 'string',
										'enum'        => array( 'range_quantity' ),
										'context'     => array( 'view', 'edit' ),
									),
									'min' => array(
										'description' => __( 'Minimum quantity for range rule', 'revenue' ),
										'type'        => 'integer',
										'minimum'     => 1,
										'context'     => array( 'view', 'edit' ),
									),
									'max' => array(
										'description' => __( 'Maximum quantity for range rule', 'revenue' ),
										'type'        => 'integer',
										'minimum'     => 1,
										'context'     => array( 'view', 'edit' ),
									),
									'description' => array(
										'description' => __( 'Description for this rule', 'revenue' ),
										'type'        => 'string',
										'context'     => array( 'view', 'edit' ),
									),
								),
								'required' => array( 'rule_type', 'min', 'max' ),
							),
                            
						),
					),
					// will only be available wehn 
                    'discount_type' => array(
                        'description' => __( 'Discount type for this section', 'revenue' ),
                        'type'        => 'string',
                        'enum'        => array( 'percentage', 'fixed', 'fixed_price' ),
                        'context'     => array( 'view', 'edit' ),
                    ),
                    'discount_value' => array(
                        'description' => __( 'Discount value for this section', 'revenue' ),
                        'type'        => 'number',
                        'context'     => array( 'view', 'edit' ),
                    ),
                ),
            ),
		),


		'offer' => array(
			'description' => __( 'Offer configuration for campaign', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
			'oneOf'       => array(
				array(
					'properties' => array(
						'offer_type' => array(
							'description' => __( 'Offer mode', 'revenue' ),
							'type'        => 'string',
							'enum'        => array( 'global_discount' ),
							'context'     => array( 'view', 'edit' ),
						),
						'discount_type' => array(
							'description' => __( 'Discount type for the global offer', 'revenue' ),
							'type'        => 'string',
							'enum'        => array( 'percentage', 'fixed', 'fixed_price' ),
							'context'     => array( 'view', 'edit' ),
						),
						'discount_value' => array(
							'description' => __( 'Discount value for the global offer', 'revenue' ),
							'type'        => 'number',
							'context'     => array( 'view', 'edit' ),
						),
						
						'free_gifts' => array(
							'description' => __( 'Extra products for global offer', 'revenue' ),
							'type'        => 'array',
							'context'     => array( 'view', 'edit' ),
							'items'       => $base_product_schema,
						),
					),
				),
				array(
					'properties' => array(
						'offer_type' => array(
							'description' => __( 'Offer mode', 'revenue' ),
							'type'        => 'string',
							'enum'        => array( 'section' ),
							'context'     => array( 'view', 'edit' ),
						),
						'free_gifts' => array(
							'description' => __( 'Extra products for section offer', 'revenue' ),
							'type'        => 'array',
							'context'     => array( 'view', 'edit' ),
							'items'       => $base_product_schema,
						),
					),
				),
				array(
					'properties' => array(
						'offer_type' => array(
							'description' => __( 'Offer mode', 'revenue' ),
							'type'        => 'string',
							'enum'        => array( 'tiered_discount' ),
							'context'     => array( 'view', 'edit' ),
						),
						'tier_type' => array(
							'description' => __( 'Tiering type', 'revenue' ),
							'type'        => 'string',
							'enum'        => array( 'fixed_quantity', 'range_quantity', 'order_value' ),
							'context'     => array( 'view', 'edit' ),
						),
						'tiers' => array(
							'description' => __( 'List of tiers', 'revenue' ),
							'type'        => 'array',
							'context'     => array( 'view', 'edit' ),
							'items'       => array(
								'type'       => 'object',
								'oneOf'      => array(
									array(
										'properties' => array(
											'tier_type' => array( 'enum' => array( 'fixed_quantity' ) ),
											'quantity'  => array( 'type' => 'integer', 'minimum' => 1 ),
										),
										'required' => array( 'tier_type', 'quantity' ),
									),
									array(
										'properties' => array(
											'tier_type' => array( 'enum' => array( 'range_quantity' ) ),
											'min'  => array( 'type' => 'integer', 'minimum' => 1 ),
											'max'  => array( 'type' => 'integer', 'minimum' => 1 ),
										),
										'required' => array( 'tier_type', 'min', 'max' ),
									),
									array(
										'properties' => array(
											'tier_type' => array( 'enum' => array( 'order_value' ) ),
											'order_value'  => array( 'type' => 'number', 'minimum' => 0 ),
										),
										'required' => array( 'tier_type', 'order_value' ),
									),
								),
								'properties' => array(
									'discount_type' => array('type'=>'string','enum'=>array('percentage','fixed','fixed_price'),'context'=>array('view','edit')),
									'discount_value' => array('type'=>'number','context'=>array('view','edit')),
									'free_gifts' => $base_product_schema,
								),
							),
						),
					),
				),
			),
		),

		// Core part - end

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
);
