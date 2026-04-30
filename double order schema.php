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

$animation_types = array(
	'wobble' => __( 'Wobble', 'revenue' ),
	'shake'  => __( 'Shake', 'revenue' ),
	'zoom'   => __( 'Zoom', 'revenue' ),
	'pulse'  => __( 'Pulse', 'revenue' ),
);
$double_order_schema = array(
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
                'checkout',
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

         'tiers' => array(
            'description' => __('List of tiers for the campaign', 'revenue'),
            'type'        => 'array',
            'context'     => $context,
            'items'       => array(
                'type'       => 'object',
                'properties' => array(
                    'order_count' => array(
                        'description' => __('Number of products required to trigger this tier', 'revenue'),
                        'type'        => 'integer',
                        'context'     => $context,
                    ),
                    'discount_type' => array(
                        'description' => __('Discount type for this tier', 'revenue'),
                        'type'        => 'string',
                        'enum'        => $offer_type_enum,
                        'context'     => $context,
                    ),
                    'discount_value' => array(
                        'description' => __('Discount value for this tier', 'revenue'),
                        'type'        => 'number',
                        'context'     => $context,
                    ),
                    // will have smart tags like {discount_value}, {qty} - order count.
                    'discount_message' => array(
                        'description' => __('Message to display for this tier discount', 'revenue'),
                        'type'        => 'string',
                        'context'     => $context,
                    ),
                ),
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
                'duration_seconds' => array(
                    'description' => __('Countdown duration in seconds', 'revenue'),
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
            'required' => array( 'placement_type', 'position' ),
            'properties' => array(
                'position' => array(
                    'enum' => array(
                        'before_place_order_button',
                        'before_payment_gateways',
                        'after_billing_form',
                    )
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
);
