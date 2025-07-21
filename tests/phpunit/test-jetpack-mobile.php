<?php
/**
 * Tests for Jetpack mobile compatibility.
 */
class JetpackMobileTest extends WP_UnitTestCase {
    private $mobile_template;

    public function set_up() {
        parent::set_up();
        newmr_plugin_activate();

        // Provide a user agent so mobile checks don't fail early.
        $_SERVER['HTTP_USER_AGENT'] = 'WordPress PHPUnit';

        // Ensure jetpack_is_mobile() can be mocked.
        if ( ! function_exists( 'jetpack_is_mobile' ) ) {
            function jetpack_is_mobile() {
                return isset( $GLOBALS['__test_is_mobile'] ) ? $GLOBALS['__test_is_mobile'] : false;
            }
        }

        // Create a dummy mobile template inside the active theme.
        $this->mobile_template = get_stylesheet_directory() . '/mobile.php';
        if ( ! file_exists( $this->mobile_template ) ) {
            file_put_contents( $this->mobile_template, '<?php // mobile template ?>' );
        }
    }

    public function tear_down() {
        if ( file_exists( $this->mobile_template ) ) {
            unlink( $this->mobile_template );
        }
        unset( $_SERVER['HTTP_USER_AGENT'] );
        parent::tear_down();
    }

    public function test_check_mobile_false_by_default() {
        $GLOBALS['__test_is_mobile'] = false;
        $this->assertFalse( newmr_jetpack_check_mobile() );
    }

    public function test_check_mobile_true_when_reported() {
        $GLOBALS['__test_is_mobile'] = true;
        $this->assertTrue( newmr_jetpack_check_mobile() );
    }

    public function test_template_swaps_when_mobile() {
        $GLOBALS['__test_is_mobile'] = true;
        $filtered = newmr_maybe_load_mobile_template( '/path/to/index.php' );
        $this->assertSame( $this->mobile_template, $filtered );
    }

    public function test_jetpack_theme_disabled_filter() {
        $this->assertFalse( apply_filters( 'jetpack_has_mobile_theme', true ) );
    }
}
