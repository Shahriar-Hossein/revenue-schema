<?php


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
		'id'                                              => array(
			'description' => __( 'Unique identifier for campaign.', 'revenue' ),
			'type'        => 'integer',
			'context'     => array( 'view', 'edit' ),
			'readonly'    => true,
		),
		'campaign_name'                                   => array(
			'description' => __( 'Campaign name.', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'date_created'                                    => array(
			'description' => __( "The date the campaign was created, in the site's timezone.", 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
			'readonly'    => true,
		),
		'date_created_gmt'                                => array(
			'description' => __( 'The date the campaign was created, as GMT.', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
			'readonly'    => true,
		),
		'date_modified'                                   => array(
			'description' => __( "The date the campaign was last modified, in the site's timezone.", 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
			'readonly'    => true,
		),
		'date_modified_gmt'                               => array(
			'description' => __( 'The date the campaign was last modified, as GMT.', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
			'readonly'    => true,
		),
		'campaign_type'                                   => array(
			'description' => __( 'campaign type.', 'revenue' ),
			'type'        => 'string',
			'default'     => 'simple',
			'enum'        => array_keys( revenue()->get_campaign_types() ),
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_status'                                 => array(
			'description' => __( 'campaign status', 'revenue' ),
			'type'        => 'string',
			'default'     => 'draft',
			'enum'        => array_keys( revenue()->get_campaign_statuses() ),
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_trigger_type'                           => array(
			'description' => __( 'campaign trigger type', 'revenue' ),
			'type'        => 'string',
			// 'enum'        => array( 'all_products', 'products', 'category' ),
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_trigger_items'                          => array(
			'description' => __( 'Trigger items', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'item_id'       => array(
						'description' => __( 'Item Description', 'revenue' ),
						'type'        => 'mixed',
						'context'     => array( 'view', 'edit' ),
					),
					'item_name'     => array(
						'description' => __( 'Item Name', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'item_quantity' => array(
						'description' => __( 'Item quantity', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
					),
				),
			),

		),
		'campaign_trigger_exclude_items'                  => array(
			'description' => __( 'Trigger exclude items', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'item_id'   => array(
						'description' => __( 'Item Description', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
					),
					'item_name' => array(
						'description' => __( 'Item Name', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
				),
			),

		),
		'placement_settings'                              => array(
			'description' => __( 'Placement Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'page'                     => array(
						'description' => __( 'Page Name', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'status'                   => array(
						'description' => __( 'Page Status', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'display_style'            => array(
						'description' => __( 'Campaign display types', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
						'enum'        => array_keys( revenue()->get_campaign_display_types() ),
					),
					'inpage_position'          => array(
						'description' => __( 'In page display position', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'builder_view'             => array(
						'description' => __( 'In page display position', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'popup_animation'          => array(
						'description' => __( 'In page campaign popup animation', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
						'enum'        => array_keys( revenue()->get_campaign_popup_animation_types() ),
					),
					'popup_animation_delay'    => array(
						'description' => __( 'campaign popup animation trigger delay in second', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
					),
					'floating_position'        => array(
						'description' => __( 'Floating positon', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
						'enum'        => array_keys( revenue()->get_campaign_floating_positions() ),
					),
					'floating_animation_delay' => array(
						'description' => __( 'campaign floating animation trigger delay in second', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
				),
			),

		),
		'campaign_placement'                              => array(
			'description' => __( 'campaign placement', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_display_style'                          => array(
			'description' => __( 'Campaign display types', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_inpage_position'                        => array(
			'description' => __( 'In page display position', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_popup_animation'                        => array(
			'description' => __( 'In page campaign popup animation', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array_keys( revenue()->get_campaign_popup_animation_types() ),
		),
		'campaign_popup_animation_delay'                  => array(
			'description' => __( 'campaign popup animation trigger delay in second', 'revenue' ),
			'type'        => 'integer',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_floating_position'                      => array(
			'description' => __( 'Floating positon', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array_keys( revenue()->get_campaign_floating_positions() ),
		),
		'campaign_floating_animation_delay'               => array(
			'description' => __( 'campaign popup animation trigger delay in second', 'revenue' ),
			'type'        => 'integer',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_behavior'                               => array(
			'description' => __( 'Campaign behavior', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array( 'cross_sell', 'upsell', 'downsell' ),
		),
		'campaign_recommendation'                         => array(
			'description' => __( 'Campaign recommendation', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array( 'manual', 'automatic' ),
		),
		'offer_on'                                        => array(
			'description' => __( 'Offer on', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array( 'all_product', 'specific_product', 'specific_category' ),
		),
		'offers'                                          => array(
			'description' => __( 'List of Offered items', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'id'       => array(
						'description' => __( 'Offers Row ID.', 'revenue' ),
						'type'        => 'mixed',
						'context'     => array( 'view', 'edit' ),
					),
					'products' => array(
						'description' => __( 'Offered Products.', 'revenue' ),
						'type'        => 'array',
						'context'     => array( 'view', 'edit' ),
					),
					'quantity' => array(
						'description' => __( 'Offer quantity', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
					),
					'value'    => array(
						'description' => __( 'Offer value', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'type'     => array(
						'description' => __( 'Offer type.', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'tags'     => array(
						'description' => __( 'Offer tags', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'desc'     => array(
						'description' => __( 'Offer description', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),

				),
			),
		),
		'spending_goal_upsell_discount_configuration'     => array(
			'description' => __( 'List of Offered items', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'id'       => array(
						'description' => __( 'Offers Row ID.', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
					),
					'products' => array(
						'description' => __( 'Offered Products.', 'revenue' ),
						'type'        => 'array',
						'context'     => array( 'view', 'edit' ),
					),
					'quantity' => array(
						'description' => __( 'Offer quantity', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
					),
					'value'    => array(
						'description' => __( 'Offer value', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'type'     => array(
						'description' => __( 'Offer type.', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'tags'     => array(
						'description' => __( 'Offer tags', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'desc'     => array(
						'description' => __( 'Offer description', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),

				),
			),
		),

		// Normal Discount - No Settings.

		// Buy X Get Y - No Settings.

		// Frequenty Bought Together - No Settings.

		// Bundle Discount Settings.
	'bundle_with_trigger_products_enabled'                => array(
		'description' => __( 'Bundle discount campaign allow bundle with trigger product', 'revenue' ),
		'type'        => 'string',
		'context'     => array( 'view', 'edit' ),
	),

		// Volume Discount Settings.
		'allow_more_than_required_quantity'               => array(
			'description' => __( 'Volumne Discount Campaign Allow more than required quantity', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		// Mix & Match Settings.
		'is_required_products'                            => array(
			'description' => __( 'Mix Match Campaign Is Required Products', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'initial_product_selection'                       => array(
			'description' => __( 'Mix Match Campaign Initial Products Selection', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array( 'all_product', 'no_product' ),
		),

		// Spending Goal Settings.
		'reward_type'                                     => array(
			'description' => __( 'Spending Goal Campaign Reward Type', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array( 'free_shipping', 'discount' ),
		),
		'spending_goal'                                   => array(
			'description' => __( 'Spending Goal', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'spending_goal_upsell_product_selection_strategy' => array(
			'description' => __( 'Spending Goal', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'spending_goal_on_cta_click'                      => array(
			'description' => __( 'Spending Goal', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'spending_goal_calculate_based_on'                => array(
			'description' => __( 'Spending Goal calculate based on', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'spending_goal_discount_type'                     => array(
			'description' => __( 'Spending Goal Discount Type', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'spending_goal_discount_value'                    => array(
			'description' => __( 'Spending Goal Discount Value', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		// Banner Heading and Subheading.
		'banner_heading'                                  => array(
			'description' => __( 'Campaign Banner heading', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'banner_subheading'                               => array(
			'description' => __( 'Campaign Banner sub heading', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		// Stock Scarcity.
		'stock_scarcity_enabled'                          => array(
			'description' => __( 'Campaign stock scarcity enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		'stock_scarcity_actions'                          => array(
			'description' => __( 'Campaign stock scarcity actions', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'id'            => array(
						'description' => __( 'Stock scarcity actions Row ID.', 'revenue' ),
						'type'        => 'integer',
						'context'     => array( 'view', 'edit' ),
					),
					'action'        => array(
						'description' => __( 'Stock scarcity row action.', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'stock_status'  => array(
						'description' => __( 'Stock scarcity action stock status', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'stock_message' => array(
						'description' => __( 'Stock scarcity action message.', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'stock_value'   => array(
						'description' => __( 'Stock scarcity action stock value.', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
				),
			),
			'maxItems'    => 3,
		),
		'spending_goal_free_shipping_progress_messages'   => array(
			'description' => __( 'Campaign spending progress messages', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'status'  => array(
						'description' => __( 'Spending Progress Status', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'message' => array(
						'description' => __( 'Spending Progress message', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
				),
			),
			'maxItems'    => 3,
		),
		'spending_goal_discount_progress_messages'        => array(
			'description' => __( 'Campaign spending progress messages', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'status'  => array(
						'description' => __( 'Spending Progress Status', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
					'message' => array(
						'description' => __( 'Spending Progress message', 'revenue' ),
						'type'        => 'string',
						'context'     => array( 'view', 'edit' ),
					),
				),
			),
			'maxItems'    => 3,
		),

		// Countdown Timer.
		'countdown_timer_enabled'                         => array(
			'description' => __( 'Campaign countdown timer enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'spending_goal_is_upsell_enable'                  => array(
			'description' => __( 'Is spending goal upsell enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_start_time_status'                     => array(
			'description' => __( 'Does campaign coundown start right now ot schedule to later', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array( 'right_now', 'schedule_to_later' ),
		),
		'countdown_start_date'                            => array(
			'description' => __( 'Campaign countdown start date', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_start_time'                            => array(
			'description' => __( 'Campaign countdown start time', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_end_date'                              => array(
			'description' => __( 'Campaign countdown end date', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_end_time'                              => array(
			'description' => __( 'Campaign countdown end time', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),

		// Animated Add to cart.
		'animated_add_to_cart_enabled'                    => array(
			'description' => __( 'Campaign animated add to cart enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'add_to_cart_animation_trigger_type'              => array(
			'description' => __( 'Campaign animated add to cart animation trigger type', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array( 'loop', 'on_hover' ),
		),
		'add_to_cart_animation_type'                      => array(
			'description' => __( 'Campaign animated add to cart animation type', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
			'enum'        => array_keys( $animation_types ),
		),
		'add_to_cart_animation_start_delay'               => array(
			'description' => __( 'Campaign animated add to cart animation start delay', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		// Free shipping.
		'free_shipping_enabled'                           => array(
			'description' => __( 'Campaign free shipping enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		// Time Schedule Settings.
		'schedule_end_time_enabled'                       => array(
			'description' => __( 'Campaign Time Schedule End Time status', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'schedule_start_date'                             => array(
			'description' => __( 'Campaign Schedule start date', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'schedule_start_time'                             => array(
			'description' => __( 'Campaign Schedule start time', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'schedule_end_date'                               => array(
			'description' => __( 'Campaign Schedule end date', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),
		'schedule_end_time'                               => array(
			'description' => __( 'Campaign Schedule end time', 'revenue' ),
			'type'        => 'date-time',
			'context'     => array( 'view', 'edit' ),
		),

		// Additional Settings.
		'skip_add_to_cart'                                => array(
			'description' => __( 'Skip Add to cart button for offered products', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'quantity_selector_enabled'                       => array(
			'description' => __( 'Enabled Quantity selector for offered products', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'multiple_variation_selection_enabled'            => array(
			'description' => __( 'Allow users to choose the variations of items based on selected quantity', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'offered_product_on_cart_action'                  => array(
			'description' => __( 'If the offered products are already in cart action', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'offered_product_click_action'                    => array(
			'description' => __( 'action if click on product title or image', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'multiple_variation_selection_enabled'            => array(
			'description' => __( 'Allow users to choose the variations of items based on selected quantity', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'builder'                                         => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'builderdata'                                     => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'buildeMobileData'                                => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_builder_view'                           => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'product_tag_text'                                => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'save_discount_ext'                               => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'bundle_label_badge'                              => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'no_thanks_button_text'                           => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'add_to_cart_btn_text'                            => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'checkout_btn_text'                               => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'total_price_text'                                => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'mix_match_is_required_products'                  => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'mix_match_initial_product_selection'             => array(
			'description' => __( 'Builder Data', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'mix_match_required_products'                     => array(
			'description' => __( 'Trigger items', 'revenue' ),
			'type'        => 'array',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_view_id'                                => array(
			'description' => __( 'Builder unique id', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_view_class'                             => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'buy_x_get_y_trigger_qty_status'                  => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'fbt_is_trigger_product_required'                 => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_prefix'                          => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'double_order_animation_type'                     => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'double_order_animation_delay_between'            => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'double_order_animation_enabled'                  => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'double_order_success_message'                    => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'double_order_countdown_duration'                 => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'free_shipping_label'                             => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),

		'spending_goal_upsell_products'                   => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'mixed',
			'context'     => array( 'view', 'edit' ),
		),
		'spending_goal_upsell_product_status'             => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'upsell_products'                                 => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'mixed',
			'context'     => array( 'view', 'edit' ),
		),
		'upsell_products_status'                          => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'show_confetti'                                   => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'spending_goal_progress_show_icon'                => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'is_show_free_shipping_bar'                       => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'show_close_icon'                                 => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'enable_cta_button'                               => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'cta_button_text'                                 => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'all_goals_complete_message'                      => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'css'                                             => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'drawer_css'                                      => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'inpage_css'                                      => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'floating_css'                                    => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'popup_css'                                       => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'top_css'                                         => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'bottom_css'                                      => array(
			'description' => __( 'Builder view class', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_type'                            => array(
			'description' => __( 'Countdown Timer Campaign Countdown Type', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_static_settings'                 => array(
			'description' => __( 'Countdown Timer Campaign Static Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_evergreen_settings'              => array(
			'description' => __( 'Countdown Timer Campaign EverGreen Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_daily_recurring_settings'        => array(
			'description' => __( 'Countdown Timer Campaign Daily Recurring Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_shop_progress_bar'               => array(
			'description' => __( 'Countdown Timer Campaign Shop page progress Bar', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_cart_progress_bar'               => array(
			'description' => __( 'Countdown Timer Campaign Cart page progress Bar', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_entire_site_action_type'         => array(
			'description' => __( 'Countdown Timer Campaign Entire Site Action Type', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_entire_site_action_link'         => array(
			'description' => __( 'Countdown Timer Campaign Entire Site Action Link', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_entire_site_action_enable'       => array(
			'description' => __( 'Countdown Timer Campaign Entire Site Action Enable', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'countdown_timer_enable_close_button'             => array(
			'description' => __( 'Countdown Timer Campaign Entire Site Enable Close Button', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'animation_settings_enable'                       => array(
			'description' => __( 'Campaign countdown timer enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'animation_type'                                  => array(
			'description' => __( 'Campaign countdown timer enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'animation_duration'                              => array(
			'description' => __( 'Campaign countdown timer enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'delay_between_loop'                              => array(
			'description' => __( 'Campaign countdown timer enabled or not', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'stock_scarcity_message_type'                     => array(
			'description' => __( 'Stock Scarcity Message Type', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'stock_scarcity_enable_fake_stock'                => array(
			'description' => __( 'Stock Scarcity Enable Fake Stock', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'stock_scarcity_general_message_settings'         => array(
			'description' => __( 'Stock Scarcity General Message Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'stock_scarcity_flip_message_settings'            => array(
			'description' => __( 'Stock Scarcity Flip Message Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'stock_scarcity_animation_settings'               => array(
			'description' => __( 'Stock Scarcity Animation Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'revx_next_order_coupon'                          => array(
			'description' => __( 'Next Order Coupon Settings', 'revenue' ),
			'type'        => 'object',
			'context'     => array( 'view', 'edit' ),
		),
		'activeTemplate'                                  => array(
			'description' => __( 'Active Template', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
		'campaign_version'                                => array(
			'description' => __( 'Campaign Version', 'revenue' ),
			'type'        => 'string',
			'context'     => array( 'view', 'edit' ),
		),
	),
);
