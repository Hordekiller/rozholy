<?php
defined('ABSPATH') || exit;
/**
 * Title: Booking Form
 * Slug: rozholy/booking-form
 * Categories: rozholy, booking
 * Description: Online booking form with glass card container
 */
?>
<!-- wp:group {"backgroundColor":"base-alt","style":{"spacing":{"padding":{"top":"clamp(4rem, 10vh, 9rem)","bottom":"clamp(4rem, 10vh, 9rem)"}}}} -->
<div class="wp-block-group has-base-alt-background-color has-background" style="padding-top:clamp(4rem, 10vh, 9rem);padding-bottom:clamp(4rem, 10vh, 9rem)">
  <!-- wp:group {"layout":{"type":"constrained","contentSize":"650px"}} -->
  <div class="wp-block-group" data-reveal="fade-up">
    <!-- wp:group {"style":{"border":{"radius":"16px","width":"1px"},"spacing":{"padding":{"top":"45px","right":"45px","bottom":"45px","left":"45px"}}},"borderColor":"border","backgroundColor":"white","className":"glass-card"} -->
    <div class="wp-block-group has-white-background-color has-background has-border-color has-border-border-color glass-card" style="border-width:1px;border-radius:16px;padding-top:45px;padding-right:45px;padding-bottom:45px;padding-left:45px">
      <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.8rem"}}} -->
      <h3 class="wp-block-heading has-text-align-center" style="font-size:1.8rem"><span class="text-gradient">رزرو نوبت آنلاین</span></h3>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"align":"center","textColor":"text-light"} -->
      <p class="has-text-align-center has-text-light-color has-text-color">برای رزرو وقت، اطلاعات خود را وارد کنید. همکاران ما در اسرع وقت با شما تماس خواهند گرفت.</p>
      <!-- /wp:paragraph -->

      <!-- wp:contact-form-7/form-config {"id":"booking"} /-->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
