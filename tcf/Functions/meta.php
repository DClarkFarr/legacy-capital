<?php

namespace Meta;

function getSiteSchema()
{
    $logo = get_field('logo', 'options');
    $reviews = getReviewsSchema();
    $schema = [
        "@context" => "http://schema.org/",
        "@type" => "LocalBusiness",
        "@id" => home_url(),
        "name" => get_bloginfo('name'),
        "telephone" => get_field('phone', 'options'),
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => get_field('address_1', 'options'),
            "addressLocality" => get_field('city', 'options'),
            "addressRegion" => get_field('state', 'options'),
            "postalCode" => get_field('zip', 'options'),
            "addressCountry" => "US"
        ],
        "aggregateRating" => [
            "@type" => "AggregateRating",
            "ratingValue" => get_field('rating_value', 'options'),
            "ratingCount" => get_field('rating_count', 'options'),
        ],
    ];

    if ($logo) {
        $schema["image"] = [
            $logo['url'],
            $logo['sizes']['medium'],
            $logo['sizes']['large'],
        ];
    }
    if ($reviews) {
        $schema['review'] = $reviews;
    }

    return $schema;
}
function getReviewsSchema()
{
    $posts = (new \WP_Query([
        'post_type' => 'review',
        'posts_per_page' => -1,
        'publish' => 'publish',
    ]))->posts;

    return array_map(function ($post) {
        $date_published = get_field('date_published', $post->ID);
        $author_image_id = get_field('author_image', $post->ID);

        $review = [
            '@type' => 'Review',
            'author' => [
                '@type' => 'Person',
                'name' => get_field('author_name', $post->ID),
            ],
            'description' => get_field('description', $post->ID),
            'name' => get_the_title($post->ID),
            'reviewRating' => [
                '@type' => 'Rating',
                'bestRating' => 5,
                'worstRating' => 1,
                'ratingValue' => get_field('rating', $post->ID),
            ]
        ];

        if ($date_published) {
            $review['datePublished'] = $date_published;
        }

        if ($author_image_id) {
            $review['author']['image'] = wp_get_attachment_image_url($author_image_id, 'review-thumb');
        }

        return $review;
    }, $posts);
}
