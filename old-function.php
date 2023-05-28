<?php

defined( 'ABSPATH' ) or exit;

function my_theme_enqueue_styles() {

  wp_enqueue_style( 'my-custom-style', get_template_directory_uri() . '/assets/css/my-custom-style.css');

}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


// Theme constants
define( 'FIXLAB_PATH', trailingslashit( get_template_directory() ) );
define( 'FIXLAB_URI', trailingslashit( get_template_directory_uri() ) );
define( 'FIXLAB_VERSION', '1.0.0' );
define( 'FIXLAB_ID', 'fixlab' );


// Action to load the theme translation
add_action( 'after_setup_theme', 'fixlab_translation_import', 5 );

/**
 * Load the translation files into the theme textdomain
 *
 * @return  void
 */
function fixlab_translation_import() {
	load_theme_textdomain( 'fixlab', get_template_directory() . '/languages' );
}


/**
 * We must check PHP version to ensure the theme can
 * be worked fine
 */
if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	// Register action to checking theme requirements
	add_action( 'after_switch_theme', 'fixlab_requirement_check', 10, 2 );

	// Action to sending a notice while hosting does
	// not meet the minimum requires
	add_action( 'admin_notices', 'fixlab_requirement_notice' );

	/**
	 * Check the theme requirements
	 *
	 * @param   string  $name   Theme's name
	 * @param   object  $theme  The theme object
	 *
	 * @return  void
	 */
	function fixlab_requirement_check( $name, $theme ) {
		// Switch back to previous theme
		switch_theme( $theme->stylesheet );
	}

	/**
	 * Show the warning message when hosting environment doesn't
	 * meet the theme minimum requires.
	 *
	 * @return  void
	 */
	function fixlab_requirement_notice() {
		printf( '<div class="error"><p>%s</p></div>',
			esc_html__( 'Sorry! Your server does not meet the minimum requirements, please upgrade PHP version to 5.3 or higher', 'fixlab' ) );
	}

	return;
}


// The base classes
require_once FIXLAB_PATH . 'inc/options/class-options-container.php';
require_once FIXLAB_PATH . 'inc/options/class-options-control.php';
require_once FIXLAB_PATH . 'inc/options/class-options-section.php';

require_once FIXLAB_PATH . 'inc/functions-helpers.php';
require_once FIXLAB_PATH . 'inc/functions-helpers-styles.php';

// Theme customize setup
require_once FIXLAB_PATH . 'inc/customize/functions-customize.php';

// Theme setup
require_once FIXLAB_PATH . 'inc/functions-setup.php';
require_once FIXLAB_PATH . 'inc/functions-template.php';
require_once FIXLAB_PATH . 'inc/functions-metaboxes.php';
require_once FIXLAB_PATH . 'inc/class-custom-sidebars.php';

if ( is_admin() ) {
	require_once FIXLAB_PATH . 'admin/functions-setup.php';
	require_once FIXLAB_PATH . 'admin/functions-plugins.php';
}

// Custom filters & actions
require_once FIXLAB_PATH . 'inc/functions-filters.php';
require_once FIXLAB_PATH . 'inc/functions-blog.php';
require_once FIXLAB_PATH . 'inc/functions-projects.php';
require_once FIXLAB_PATH . 'inc/functions-woocommerce.php';


add_shortcode('reviews_slider', 'reviews_slider_shortcode');
function reviews_slider_shortcode() {
    ob_start();
    $args = array(
        'post_type' => 'reviews',
        'posts_per_page' => -1,
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
    ?>
        <!-- новый блок отзывы  -->
                  <section class="customer-reviews">
                    <div class="wrapper wrap">
                      <h2 class="customer-reviews__title">Отзывы клиентов</h2>

                      <!-- слайдер  -->
                      <!-- Swiper -->
                      <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                          <!-- слайд  -->

        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <!-- здесь разметка одного отзыва -->
            <div class="swiper-slide">
                <div class="reviews-item">
                    <div class="reviews-item__header">
                        <span class="reviews-item__icon"><?php echo mb_substr(get_the_title(), 0, 1); ?></span>
                        <span class="reviews-item__name"><?php the_title(); ?></span>
                    </div>
                    <div class="reviews-item__text"><?php the_content(); ?></div>

                    <div class="reviews-item__footer">
                        <ul class="stars-list">
                            <?php
                            $star_count = get_field('company-evaluation');
                            for ($i = 1; $i <= 5; $i++): ?>
                                <li class="<?php echo $i <= $star_count ? 'active' : '';?>">
                                    <!-- звезда -->
                                </li>
                            <?php endfor; ?>
                        </ul>
                        <time datetime="<?php echo get_field('data_publikaczii_otzyva'); ?>"><?php echo date_i18n("j F Y", strtotime(get_field('data_publikaczii_otzyva'))); ?></time>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php
    else :
        echo '<p>Отзывов пока нет</p>';
    endif;

    wp_reset_postdata(); ?>

    </div>

                        <div class="swiper-button-next"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="10"
                            fill="none">
                            <path stroke="#fff" stroke-linecap="round" stroke-width="2" d="M1 5h16m0 0-4-4m4 4-4 4" />
                          </svg></div>
                        <div class="swiper-button-prev"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="10"
                            fill="none">
                            <path stroke="#fff" stroke-linecap="round" stroke-width="2" d="M18 5H2m0 0 4-4M2 5l4 4" />
                          </svg></div>
                        <div class="swiper-pagination"></div>
                      </div>
                      <!-- КОНЕЦ слайдер  -->
                      <div class="customer-reviews__footer">
                        <div class="statistic">
                          <div class="statistic__logo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none">
                              <g clip-path="url(#a)">
                                <path fill="#FC3F1D"
                                  d="M24 47.951c13.228 0 23.951-10.723 23.951-23.951S37.228.049 24 .049.049 10.772.049 23.999C.049 37.229 10.772 47.952 24 47.952Z" />
                                <path fill="#fff"
                                  d="M32.667 39.035h-5.258V13.031h-2.342c-4.294 0-6.543 2.147-6.543 5.351 0 3.636 1.552 5.32 4.76 7.467l2.645 1.782-7.6 11.4h-5.654l6.84-10.178c-3.933-2.809-6.146-5.55-6.146-10.178 0-5.782 4.031-9.715 11.662-9.715h7.6v30.067h.036v.008Z" />
                              </g>
                              <defs>
                                <clipPath id="a">
                                  <path fill="#fff" d="M0 0h48v48H0z" />
                                </clipPath>
                              </defs>
                            </svg>
                          </div>
                          <div class="statistic__number">4,1</div>

                          <div class="statistic__text">
                            <span>26 оценок</span>
                            <ul class="stars-list">
                              <li class="active"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                  fill="none">
                                  <path fill="#FC3F1D"
                                    d="m12.5 0 2.95 9.167H25l-7.725 5.666L20.225 24 12.5 18.334 4.775 24l2.95-9.167L0 9.167h9.55L12.5 0Z" />
                                </svg></li>
                              <li class="active"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                  fill="none">
                                  <path fill="#FC3F1D"
                                    d="m12.5 0 2.95 9.167H25l-7.725 5.666L20.225 24 12.5 18.334 4.775 24l2.95-9.167L0 9.167h9.55L12.5 0Z" />
                                </svg></li>
                              <li class="active"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                  fill="none">
                                  <path fill="#FC3F1D"
                                    d="m12.5 0 2.95 9.167H25l-7.725 5.666L20.225 24 12.5 18.334 4.775 24l2.95-9.167L0 9.167h9.55L12.5 0Z" />
                                </svg></li>
                              <li class="active"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                  fill="none">
                                  <path fill="#FC3F1D"
                                    d="m12.5 0 2.95 9.167H25l-7.725 5.666L20.225 24 12.5 18.334 4.775 24l2.95-9.167L0 9.167h9.55L12.5 0Z" />
                                </svg></li>
                              <li><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" fill="none">
                                  <path fill="#FC3F1D"
                                    d="m12.5 0 2.95 9.167H25l-7.725 5.666L20.225 24 12.5 18.334 4.775 24l2.95-9.167L0 9.167h9.55L12.5 0Z" />
                                </svg></li>
                            </ul>
                          </div>


                        </div>
                        <div class="customer-reviews__buttons">
                        <a href="#" class="button"><span>Смотреть всё</span></a>
                        <a href="#" class="button button--red"><span>Написать отзыв</span></a>
                      </div>
                      </div>
                    </div>
                  </section>
                  <!-- КОНЕЦ новый блок отзывы  -->

   <?php
	$output = ob_get_contents();
    ob_end_clean();
    return $output;
}
