<?php
require_once( '../../wp-load.php' );
$xml_header = '<?xml version="1.0"?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"></rss>';
$xml = new SimpleXMLElement($xml_header);
$channel = $xml->addChild('channel');
$channel->addChild('title','Exception Products');
$channel->addChild('link','https://www.exception-group.com/');
$channel->addChild('description','Exception Product List RSS feed');

$args = array(
    'numberposts' => -1,
    'fields'      => 'ids',
    'post_type'   => 'product',
    'post_status' => 'publish',
    'orderby'     => array('meta_value_num' => 'desc', 'date' => 'desc'),
    'order'       => 'desc',
    'suppress_filters' => false,
    'meta_key'    => 'total_sales',
    'tax_query'   => array(
        'relation'       => 'AND',
        array(
            'taxonomy'         => 'product_visibility',
            'terms'            => array('exclude-from-catalog', 'exclude-from-search'),
            'field'            => 'name',
            'operator'         => 'NOT IN',
            'include_children' => false,
        ),
    ),
) ;
$prodQuery =  get_posts($args);
foreach ($prodQuery as $one_product) {

    global $product;
    $product = wc_get_product( $one_product );
    $cats= array();
    foreach ($product->get_category_ids() as $cat) {
        $cats[] = get_term_by('id', $cat, 'product_cat')->name;
    }

    $price = $product->get_price();
    $sale_price = '';
    if($product->is_on_sale()){
        $price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
    }

    $brand = "Exception";//get_the_terms($product_id,'brand')[0]->name;
    //$description = ($product->get_description())? $product->get_description() : $product->get_name();
    $stock = ($product->get_stock_status() == "outofstock")? "out of stock" : "in stock";
    $attachment_ids = $product->get_gallery_image_ids();
    $image_link = ($attachment_ids)? wp_get_attachment_url( $attachment_ids[0] ): get_the_post_thumbnail_url();
    $item = $channel->addChild('item');
    $item->addChild('g:id', $one_product);
    $item->addChild('g:title',str_replace("&","and ",$product->get_name()));
    $item->addChild('g:google_product_category','Food, Beverages &amp; Tobacco &gt; Food Items &gt; Bakery');
    $item->addChild('g:product_type', implode(',', $cats));
    $item->addChild('g:description',str_replace("&nbsp;"," ", strip_tags($product->get_description())));
    $item->addChild('g:link', get_permalink($one_product));
    $item->addChild('g:image_link',$image_link);
    $item->addChild('g:price',number_format($price,2).' EGP');
    if($sale_price){
        $item->addChild('g:sale_price',number_format($sale_price,2).' EGP');
    }
    $item->addChild('g:availability',$stock);
    $item->addChild('g:mpn',$product->get_sku());
    $item->addChild('g:brand',$brand);
    $item->addChild('g:condition','new');
}
Header('Content-type: text/xml');
print($xml->asXML());

