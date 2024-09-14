<?php ob_start(); require_once preg_replace('/wp-content.*$/','',__DIR__).'wp-load.php'; // $theme_settings = mitch_theme_settings();?>
<!doctype html>
<?php global $language ?>
<html dir="<?php echo ($language == 'en')? 'ltr':'rtl' ?>" lang="ar">
<html>

<head>
	<!-- Google Tag Manager -->
	<script>
	(function(w, d, s, l, i) {
		w[l] = w[l] || [];
		w[l].push({
			'gtm.start': new Date().getTime(),
			event: 'gtm.js'
		});
		var f = d.getElementsByTagName(s)[0],
			j = d.createElement(s),
			dl = l != 'dataLayer' ? '&l=' + l : '';
		j.async = true;
		j.src =
			'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
		f.parentNode.insertBefore(j, f);
	})(window, document, 'script', 'dataLayer', 'GTM-5ZNV36ZX');
	</script>
	<!-- End Google Tag Manager -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16491470480"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-16491470480', {
            'allow_enhanced_conversions': true
        });

    </script>
    <?php
    global $post;
    $cate = get_queried_object();
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if (isset($_GET['lang'])) {
        if (isset($cate) && !empty($cate) && isset($cate->taxonomy)) {
            $current_page_title = get_term_meta($cate->term_id, "rank_math_title", true);
            if (empty($current_page_title)) {
                $current_page_title = get_the_title() . " - Exception";
            }
        } else {
            $current_page_title = get_post_meta($post->ID, "rank_math_title", true);
            if (empty($current_page_title)) {
                $current_page_title = get_the_title() . " - Exception";
            }
        }

    } else {
        if (isset($cate) && !empty($cate) && isset($cate->taxonomy)) {
            $current_page_title = get_term_meta($cate->term_id, "arabic_seo_title", true);
            if (empty($current_page_title)) {
                $current_page_title = get_term_meta($cate->tag_id, "attribute_in_arabic", true) . " - اكسبشن";
            }
        } else {
            $current_page_title = get_post_meta($post->ID, "seo_title", true);
            if (empty($current_page_title)) {
                $current_page_title = get_post_meta($post->ID, "product_data_arabic_title", true) . " - اكسبشن";
            }
        }
    }

    ?>
    <?php if (strpos($url, 'myaccount') !== false) { ?>
        <title> My Account - <?php echo bloginfo("name"); ?> </title>
    <?php } else { ?>
        <title> <?php echo $current_page_title; ?></title>
    <?php } ?>
    <!--    SEO Meta Fields -->
    <?php if (isset($_GET['lang'])) { ?>
        <?php if (isset($cate) && !empty($cate) && isset($cate->taxonomy)) { ?>
            <meta name="description" content="<?php echo get_term_meta($cate->term_id, "rank_math_description", true) ?>">
            <meta name="keywords" content="<?php echo get_term_meta($cate->term_id, "rank_math_focus_keyword", true) ?>">
        <?php } else { ?>
            <meta name="description" content="<?php echo get_post_meta($post->ID, "rank_math_description", true) ?>">
            <meta name="keywords" content="<?php echo get_post_meta($post->ID, "rank_math_focus_keyword", true) ?>">
        <?php } ?>
    <?php } else { ?>
        <?php if (isset($cate) && !empty($cate) && isset($cate->taxonomy)) { ?>
            <meta name="description" content="<?php echo get_term_meta($cate->term_id, "arabic_seo_description", true) ?>">
            <meta name="keywords" content="<?php echo get_term_meta($cate->term_id, "arabic_focus_keyword", true) ?>">
        <?php } else { ?>
            <meta name="description" content="<?php echo get_post_meta($post->ID, "seo_description", true) ?>">
            <meta name="keywords" content="<?php echo get_post_meta($post->ID, "focus_keywords", true) ?>">
        <?php } ?>

    <?php } ?>
    <meta name="author" content="Exception Group">
    <meta name="robots" content="index, follow">
    <meta name="facebook-domain-verification" content="tidgd8ob5d8lt3rzhmsun0ll5y2w9m" />
	<meta charset="<?php echo get_bloginfo('charset'); ?>">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- <link href="<?php //echo $theme_settings['theme_url'];?>/assets/sass/main.css" rel="stylesheet"> -->
	<!-- <link href="<?php //echo $theme_settings['theme_url'];?>/assets/sass/main.rtl.css" rel="stylesheet"> -->
	<link
		href="<?php echo $theme_settings['theme_url']; ?>/assets/sass/main<?php echo ($language == 'en')? '':'.rtl' ?>.css?no_cash=1"
		rel="stylesheet">
	<link href="<?php echo $theme_settings['theme_url'];?>/style.css?no_cash=4" rel="stylesheet">
	<link rel="shortcut icon" type="image/png" href="<?php echo $theme_settings['theme_favicon'];?>" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@200;300;400;500;600;700;800&family=Kufam:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"> -->
	<link
		href="https://fonts.googleapis.com/css2?family=Alexandria:wght@200;300;400;500;600;700;800&family=Kufam:wght@400;500;600;700;800;900&family=Sora:wght@100;300;500;700&display=swap"
		rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined&display=swap"
		rel="stylesheet" defer>

	<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->

	<!-- Start Calendar -->
	<?php if(get_post(3019) ||  is_checkout()){ ?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<?php } ?>
	<!-- End Calendar -->
	<?php
      //if(is_checkout() ){?>
	<?php wp_head();?>
	<?php// }?>
    <meta name="google-site-verification" content="4a38qCwfcxHcvp5apKZ94N_74JbqthrCUkKN7mqJG-c" />
</head>
<?php
        $has_class = (is_page(3322) || is_page(3325) || is_page(3328) || is_page(394) || is_page(386) || is_page(3333) || is_page(3404) || is_page(434) || is_page(392))? 'MD-my-account':''; 
    ?>

<body
	class="<?php if(is_user_logged_in()){echo 'logged-in-user';}else{echo 'logged-out-user';}?> <?php echo $has_class?> <?php echo ($language == 'en')? 'ltr':'rtl' ?>"
	data-mitch-ajax-url="<?php echo admin_url('admin-ajax.php');?>"
	data-mitch-logged-in="<?php if(is_user_logged_in()){echo 'yes';}else{echo 'no';}?>"
	data-mitch-current-lang="<?php echo $theme_settings['current_lang'];?>" data-mitch-home-url="<?php echo home_url();?>"
	<?php if(is_checkout()){ ?>
	data-redeem="<?php if(!empty(WC()->cart->get_fees())){echo 'true';} else{echo 'false';} ?>" <?php } ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZNV36ZX" height="0" width="0"
			style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div id="ajax_loader" style="display:none;">
		<div class="loader"></div>
	</div>
	<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['mitch_action']) && $_POST['mitch_action'] == 'add_subscriber'){
      if(wp_verify_nonce($_POST['add_subscriber_nonce'], 'mitch_add_subscriber_nonce')){
        $user_email     = sanitize_text_field($_POST['user_email']);
        $add_subscriber = mitch_campaign_monitor_add_subscriber($user_email);
        if($add_subscriber == 201){
          $response = 'success';
        }else{
          $response = 'error';
        }
        wp_redirect(home_url().'?add_subscriber='.$response);
        exit;
      }
      wp_redirect(home_url());
      exit;
    }
  }
  ?>