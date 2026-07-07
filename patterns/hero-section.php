<?php
defined('ABSPATH') || exit;
/**
 * Title: Hero Section
 * Slug: rozholy/hero-section
 * Categories: rozholy, hero
 * Description: Main hero banner with animated aurora background, glass CTA buttons
 */
?>
<!-- wp:cover {"overlayColor":"dark","minHeight":85,"minHeightUnit":"vh","align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"className":"hero-aurora"} -->
<div class="wp-block-cover alignfull hero-aurora has-grain" style="padding-top:80px;padding-bottom:80px;min-height:85vh">
  <span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-60 has-background-dim"></span>
  <div class="wp-block-cover__inner-container">
    <!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"clamp(2.5rem, 8vw, 5rem)","fontWeight":"800"},"color":{"text":"#ffffff"}}} -->
    <h1 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff;font-size:clamp(2.5rem, 8vw, 5rem);font-weight:800" data-reveal="fade-up">زیبایی تو، هنر ماست</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.85)"},"typography":{"fontSize":"clamp(1rem, 2.5vw, 1.3rem)"}}} -->
    <p class="has-text-align-center has-text-color" style="color:rgba(255,255,255,0.85);font-size:clamp(1rem, 2.5vw, 1.3rem)" data-reveal="fade-up" data-reveal-delay="1">با تیمی حرفه‌ای از بهترین متخصصان زیبایی، تجربه‌ای متفاوت از سالن زیبایی را برای شما رقم می‌زنیم.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
    <div class="wp-block-buttons" data-reveal="fade-up" data-reveal-delay="2">
      <!-- wp:button {"backgroundColor":"primary","className":"btn-spring"} -->
      <div class="wp-block-button btn-spring"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#" data-magnetic="0.2">رزرو وقت</a></div>
      <!-- /wp:button -->

      <!-- wp:button {"className":"is-style-outline"} -->
      <div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button btn-spring" href="#" style="border-color:rgba(255,255,255,0.6);color:#ffffff" data-magnetic="0.2">مشاهده خدمات</a></div>
      <!-- /wp:button -->
    </div>

    <!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.3)"},"typography":{"fontSize":"0.8rem"},"spacing":{"margin":{"top":"60px"}}}} -->
    <p class="has-text-align-center has-text-color scroll-hint" style="color:rgba(255,255,255,0.3);font-size:0.8rem;margin-top:60px" data-reveal="fade" data-reveal-delay="3">
      اسکرول کنید
      <span class="scroll-hint__line"></span>
    </p>
    <!-- /wp:paragraph -->
  </div>
</div>
<!-- /wp:cover -->
