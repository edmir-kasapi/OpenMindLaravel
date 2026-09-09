@props(['type'])

<span class="badge

    @switch($type)
        @case('Electronics')
        @case('Software')
        @case('Digital Products')
            text-bg-primary
            @break

        @case('Clothing')
        @case('Footwear')
        @case('Accessories')
        @case('Jewelry')
        @case('Watches')
        @case('Beauty & Personal Care')
            text-bg-danger
            @break

        @case('Home & Kitchen')
        @case('Furniture')
        @case('Garden & Outdoor')
        @case('Tools & Hardware')
            text-bg-success
            @break

        @case('Health & Wellness')
        @case('Food & Beverages')
        @case('Pet Supplies')
        @case('Baby Products')
            text-bg-warning
            @break

        @case('Sports & Outdoors')
        @case('Toys & Games')
        @case('Art & Crafts')
        @case('Musical Instruments')
            text-bg-info
            @break

        @case('Books')
        @case('Office Supplies')
            text-bg-secondary
            @break

        @case('Automotive')
            text-bg-dark
            @break

        @case('Gift Cards')
            text-bg-light text-dark
            @break

        @default
            text-bg-secondary
    @endswitch

    ">
    {{ strtoupper($type) }}
</span>
