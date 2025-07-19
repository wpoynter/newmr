<?php

class RewriteEndpointTest extends WP_UnitTestCase {
    public function set_up() {
        parent::set_up();
        newmr_plugin_activate();
    }

    public function test_speakers_endpoint_registered() {
        global $wp_rewrite;
        $names = wp_list_pluck( $wp_rewrite->endpoints, 1 );
        $this->assertContains( 'speakers', $names );
    }
}

