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

							),
						),
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
						'extra_products_type' => array(
							'description' => __( 'Extra products mode for global offer', 'revenue' ),
							'type'        => 'string',
							'enum'        => array( 'none', 'free_gift', 'upsell' ),
							'context'     => array( 'view', 'edit' ),
						),
						'extra_products' => array(
							'description' => __( 'Extra products for global offer', 'revenue' ),
							'type'        => 'array',
							'context'     => array( 'view', 'edit' ),
							'items'       => array(
								'type'       => 'object',
								'properties' => array(
									'id' => array(
										'description' => __( 'Product id (used to fetch product from DB)', 'revenue' ),
										'type'        => 'integer',
										'context'     => array( 'view', 'edit' ),
									),
									'name'  => array(
										'description' => __( 'Editable label/name shown to customers', 'revenue' ),
										'type'        => 'string',
										'context'     => array( 'view', 'edit' ),
									),
									'quantity'   => array(
										'description' => __( 'Quantity for this extra product', 'revenue' ),
										'type'        => 'integer',
										'context'     => array( 'view', 'edit' ),
										'default'     => 1,
									),
									'discount_value' => array(
										'description' => __( 'Discount value applied to this extra product', 'revenue' ),
										'type'        => 'number',
										'context'     => array( 'view', 'edit' ),
									),
									'discount_type' => array(
										'description' => __( 'Discount type for this extra product', 'revenue' ),
										'type'        => 'string',
										'enum'        => array( 'percentage', 'fixed', 'fixed_price' ),
										'context'     => array( 'view', 'edit' ),
									),
								),
							),
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
						'extra_products_type' => array(
							'description' => __( 'Extra products mode for section offer', 'revenue' ),
							'type'        => 'string',
							'enum'        => array( 'none', 'free_gift', 'upsell' ),
							'context'     => array( 'view', 'edit' ),
						),
						'extra_products' => array(
							'description' => __( 'Extra products for section offer', 'revenue' ),
							'type'        => 'array',
							'context'     => array( 'view', 'edit' ),
							'items'       => array(
								'type'       => 'object',
								'properties' => array(
									'id' => array('description'=>__( 'Product id (used to fetch product from DB)', 'revenue' ),'type'=>'integer','context'=>array('view','edit')),
									'name' => array('description'=>__( 'Editable label/name shown to customers', 'revenue' ),'type'=>'string','context'=>array('view','edit')),
									'quantity' => array('description'=>__( 'Quantity for this extra product', 'revenue' ),'type'=>'integer','context'=>array('view','edit'),'default'=>1),
									'discount_value' => array('description'=>__( 'Discount value applied to this extra product', 'revenue' ),'type'=>'number','context'=>array('view','edit')),
									'discount_type' => array('description'=>__( 'Discount type for this extra product', 'revenue' ),'type'=>'string','enum'=>array('percentage','fixed','fixed_price'),'context'=>array('view','edit')),
								),
							),
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
									'extra_products_type' => array('type'=>'string','enum'=>array('none','free_gift','upsell'),'context'=>array('view','edit')),
									'extra_products' => array('type'=>'array','context'=>array('view','edit'),'items'=>array('type'=>'object','properties'=>array('id'=>array('type'=>'integer','context'=>array('view','edit')),'name'=>array('type'=>'string','context'=>array('view','edit')),'quantity'=>array('type'=>'integer','default'=>1,'context'=>array('view','edit')),'discount_type'=>array('type'=>'string','enum'=>array('percentage','fixed','fixed_price'),'context'=>array('view','edit')),'discount_value'=>array('type'=>'number','context'=>array('view','edit'))))),
								),
							),
						),
					),
				),
			),
		),

		'offer_on_main_products_enabled'                             => array(
			'description' => __( 'Offer on main product enabled', 'revenue' ),
			'type'        => 'boolean',
			'default'     => false,
			'context'     => array( 'view', 'edit' ),
		),

		'extra_products_type'                    => array(
			'description' => __( 'Bundle offer mode: none, free_gift, or upsell. Items also carry a `type`.', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'default'     => 'none',
			'enum'        => array( 'none', 'free_gift', 'upsell' ),
		),

		'extra_products'                         => array(
			'description' => __( 'List of bundle items (both free gifts and upsells). Each item keeps product_id and allows editable name and quantity.', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'id' => array(
						'description' => __( 'Product id (used to fetch product from DB)', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
					),
					'name'  => array(
						'description' => __( 'Editable label/name shown to customers', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'quantity'   => array(
						'description' => __( 'Quantity for this bundle item', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
						'default'     => 1,
					),
					// should only be available when extra_products_type is upsell,
					// but we keep it here for simplicity and flexibility.
					// We will handle the validation in the code.
					'discount_value' => array(
                        'description' => __( 'Discount value applied to this extra product', 'revenue' ),
                        'type'        => 'number',
                        'context'     => array( 'view', 'edit' ),
                    ),
                    'discount_type' => array(
                        'description' => __( 'Discount type for this extra product', 'revenue' ),
                        'type'        => 'string',
                        'enum'        => array( 'percentage', 'fixed', 'fixed_price' ),
                        'context'     => array( 'view', 'edit' ),
                    ),
				),
			),
		),

		'extra_products_min_quantity_required' => array(
			'description' => __( 'Minimum quantity of (normal) products required to activate the offer', 'revenue' ),
			'type'        => 'integer',
			'context'     => array( 'view', 'edit' ),
			'default'     => 1,
			'minimum'     => 1,
		),

		// Additional and Advanced settings.

		'text_settings' => array(
			'description' => __( 'Text settings for bundle display', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
			'properties'  => array(
				'heading' => array(
					'description' => __( 'Main heading text', 'revenue' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				'subheading' => array(
					'description' => __( 'Subheading text', 'revenue' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				'button_text' => array(
					'description' => __( 'Call-to-action button text', 'revenue' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				'badge_text' => array(
					'description' => __( 'Optional badge label text', 'revenue' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				'countdown_message' => array(
					'description' => __( 'Message displayed with countdown timer', 'revenue' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				// Note: The following fields are reserved for future use and not currently editable,
				// but we keep them in the schema for reference and potential future expansion.
				// PE said not needed, we will give custom work for specific user for this.
				// 'free_shipping_message' => array(
				// 	'description' => __( 'Free shipping message shown to customers', 'revenue' ),
				// 	'type'        => 'string',
				// 	'context'     => array( 'view', 'edit' ),
				// ),
				// 'upsell_product_message' => array(
				// 	'description' => __( 'Message shown for upsell products', 'revenue' ),
				// 	'type'        => 'string',
				// 	'context'     => array( 'view', 'edit' ),
				// ),
				// 'free_gift_message' => array(
				// 	'description' => __( 'Message shown for free gift items', 'revenue' ),
				// 	'type'        => 'string',
				// 	'context'     => array( 'view', 'edit' ),
				// ),
			),
		),

		'countdown_settings' => array(
			'description' => __( 'Countdown timer settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
			'properties'  => array(
				'enabled' => array(
					'description' => __( 'Whether countdown is enabled', 'revenue' ),
					'type'        => 'boolean',
					'default'     => false,
					'context'     => array( 'view', 'edit' ),
				),
				'duration_minutes' => array(
					'description' => __( 'Countdown duration in minutes', 'revenue' ),
					'type'        => 'integer',
					'context'     => array( 'view', 'edit' ),
				),
				'is_evergreen' => array(
					'description' => __( 'Whether the timer is evergreen (per-user)', 'revenue' ),
					'type'        => 'boolean',
					'default'     => false,
					'context'     => array( 'view', 'edit' ),
				),
			),
		),
		'placement_settings' => array(
			'description' => __( 'Placement Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
			'properties'  => array(
				'placement_type' => array(
					'description' => __( 'Placement type: in_page or popup', 'revenue' ),
					'type'        => 'string',
					'enum'        => array( 'in_page', 'popup' ),
					'context'     => array( 'view', 'edit' ),
				),
				'position' => array(
					'description' => __( 'Placement position (depends on placement_type)', 'revenue' ),
					'type'        => 'string',
					'enum'        => array(
						'before_add_to_cart',
						'after_add_to_cart',
						'before_product',
						'after_product_summary',
						'after_click_add_to_cart',
						'after_x_time',
					),
					'context'     => array( 'view', 'edit' ),
				),
				'delay_seconds' => array(
					'description' => __( 'Delay in seconds (required when position is after_x_time)', 'revenue' ),
					'type'        => 'integer',
					'context'     => array( 'view', 'edit' ),
				),
			),
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
		'offered_product_on_cart_action' => array(
			'description' => __( 'If the offered products are already in cart action', 'revenue' ),
			'type'        => 'string',
			'enum'        => array( 'do_nothing', 'hide' ),
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

		// Animated Add to Cart settings
		'add_to_cart_animation_type' => array(
			'description' => __( 'Campaign animated add to cart animation type', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array_keys( revenue()->get_campaign_animated_add_to_cart_animation_types() ),
		),
		'delay_between_loop' => array(
			'description' => __( 'Delay between animation loops', 'revenue' ),
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
