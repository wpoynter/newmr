<?php
class RewriteEndpointTest extends WP_UnitTestCase {
    public function set_up() {
        parent::set_up();
        newmr_plugin_activate();
    }

    public function test_speakers_endpoint_query_var() {
        $post_id = self::factory()->post->create([
            'post_type' => 'event',
            'post_name' => 'session-one',
            'post_date' => '2020-06-01 00:00:00',
        ]);
        update_post_meta( $post_id, 'event_date_from', '2020-06-01' );

        $this->go_to( '/events/2020/session-one/speakers/' );
        $this->assertTrue( is_single() );
        global $wp_query;
        $this->assertSame( 'event', $wp_query->get( 'post_type' ) );
        $this->assertArrayHasKey( 'speakers', $wp_query->query_vars );
    }
}
