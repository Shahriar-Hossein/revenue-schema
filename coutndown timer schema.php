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
$context = array('view', 'edit');
$base_product_schema = array(
    'type'       => 'object',
    'required'   => array('product_id', 'quantity'),
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
    'required'   => array('discount_value', 'discount_type'),
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
    'required'   => array('product_id', 'quantity', 'discount_value', 'discount_type'),
    'properties' => array(
        'product_id' => $base_product_schema['properties']['product_id'],
        'product_name' => $base_product_schema['properties']['product_name'],
        'quantity'   => $base_product_schema['properties']['quantity'],
        'discount_value' => $offer_schema['properties']['discount_value'],
        'discount_type' => $offer_schema['properties']['discount_type'],
    ),
);

$animation_types = array(
    'wobble' => __('Wobble', 'revenue'),
    'shake'  => __('Shake', 'revenue'),
    'zoom'   => __('Zoom', 'revenue'),
    'pulse'  => __('Pulse', 'revenue'),
);

// starts with campaign. ( the main object )
$countdown_timer_schema = array(
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
            'enum'        => array('draft', 'published'),
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
                'products',
                'products_plus_specific_products',
                'products_plus_specific_category',
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

        'excluded_trigger_product_ids'      => array(
            'description' => __('List of product IDs to exclude from triggers', 'revenue'),
            'type'        => 'array',
            'context'     => $context,
            'items'       => array(
                'type' => 'integer',
            ),
        ),

        // only for cart and shop page
        'progressbar_enabled' => array(
            'description' => __('Whether to show progress bar based on cart items', 'revenue'),
            'type'        => 'boolean',
            'default'     => false,
            'context'     => $context,
        ),

        'countdown_type' => array(
            'description' => __('Type of countdown timer', 'revenue'),
            'type'        => 'string',
            'enum'        => array('static', 'evergreen', 'daily_recurring'),
            'context'     => $context,
        ),

        // simpler to use with condition and know when to use start time.
        'countdown_start_type' => array(
            'description' => __('When the countdown timer starts', 'revenue'),
            'type'        => 'string',
            'enum'        => array('start_now', 'schedule_for_later'),
            'context'     => $context,
        ),

        // static - start ------------------------------

        // start might be empty
        'countdown_start_date' => array(
            'description' => __('Start date for static countdown timer', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
        ),
        'countdown_start_time' => array(
            'description' => __('Start time for static countdown timer', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
        ),

        'countdown_end_date' => array(
            'description' => __('End date for static countdown timer', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
        ),
        'countdown_end_time' => array(
            'description' => __('End time for static countdown timer', 'revenue'),
            'type'        => 'string',
            'context'     => $context,
        ),

        'timer_end_behavior' => array(
            'description' => __('Behavior when countdown timer ends', 'revenue'),
            'type'        => 'string',
            'enum'        => array('hide_countdown', 'do_nothing'),
            'context'     => $context,
        ),
        // static - end ------------------------------

        // recurring - start ------------------------------

        'recurring_type' => array(
            'description' => __('Type of recurring countdown', 'revenue'),
            'type'        => 'string',
            'enum'        => array('daily', 'weekly'),
            'context'     => $context,
        ),
        'daily_timeslots' => array(
            'description' => __('Time slots for daily recurring countdown', 'revenue'),
            'type'        => 'array',
            'context'     => $context,
            'items'       => array(
                'type' => 'object',
                'properties' => array(
                    'start_time' => array('type' => 'string'),
                    'end_time' => array('type' => 'string'),
                ),
            ),
        ),

        'weekly_timeslots' => array(
            'description' => __('Time slots for weekly recurring countdown', 'revenue'),
            'type'        => 'array',
            'context'     => $context,
            'items'       => array(
                'type' => 'object',
                'properties' => array(
                    'day_of_week' => array('type' => 'string', 'enum' => array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')),
                    'daily_timeslots' => array(
                        'description' => __('Time slots for daily recurring countdown of a specific day', 'revenue'),
                        'type'        => 'array',
                        'context'     => $context,
                        'items'       => array(
                            'type' => 'object',
                            'properties' => array(
                                'start_time' => array('type' => 'string'),
                                'end_time' => array('type' => 'string'),
                            ),
                        ),
                    ),
                ),
            ),
        ),

        // recurring - end ------------------------------

        // evergreen - start ------------------------------

        'evergreen_settings' => array(
            'description' => __('Settings for evergreen countdown timer', 'revenue'),
            'type'        => 'object',
            'context'     => $context,
            'properties'  => array(
                'repeat' => array(
                    'description' => __('Duration of the evergreen countdown in seconds', 'revenue'),
                    'type'        => 'boolean',
                    'context'     => $context,
                ),
                'days' => array(
                    'description' => __('Days for the evergreen countdown', 'revenue'),
                    'type'        => 'integer',
                    'context'     => $context,
                ),
                'hours' => array(
                    'description' => __('Hours for the evergreen countdown', 'revenue'),
                    'type'        => 'integer',
                    'context'     => $context,
                ),
                'minutes' => array(
                    'description' => __('Minutes for the evergreen countdown', 'revenue'),
                    'type'        => 'integer',
                    'context'     => $context,
                ),
                'seconds' => array(
                    'description' => __('Seconds for the evergreen countdown', 'revenue'),
                    'type'        => 'integer',
                    'context'     => $context,
                ),
            ),
            // evergreen - end ------------------------------


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
                ),
            ),

            // this is mainly for product page, for other pages, need to add more.
            'placement_settings' => array(
                'description' => __('Placement Settings', 'revenue'),
                'type'        => 'object',
                'context'     => $context,
                'properties'  => array(
                    'position' => array('enum' => array('before_add_to_cart', 'after_add_to_cart', 'before_product', 'after_product_summary')),
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
                        'enum'        => array('light', 'dark'),
                        'context'     => $context,
                    ),
                    'template_size' => array(
                        'description' => __('Template size', 'revenue'),
                        'type'        => 'string',
                        'enum'        => array('small', 'medium', 'large'),
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
    )
);
