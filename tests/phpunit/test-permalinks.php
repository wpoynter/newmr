<?php
class EventPermalinkTest extends WP_UnitTestCase {
    public function set_up() {
        parent::set_up();
        newmr_plugin_activate();
    }

    public function test_event_permalink_uses_meta_year() {
        $post_id = self::factory()->post->create([
            'post_type' => 'event',
            'post_name' => 'my-event',
            'post_date' => '2015-01-01 00:00:00',
        ]);
        update_post_meta( $post_id, 'event_date_from', '2021-03-05' );

        $url = newmr_event_permalink( '/events/%eyear%/%event%/', get_post( $post_id ), false );
        $this->assertSame( '/events/2021/my-event/', $url );
    }

    public function test_event_permalink_falls_back_to_post_year() {
        $post_id = self::factory()->post->create([
            'post_type' => 'event',
            'post_name' => 'future-event',
            'post_date' => '2022-04-01 00:00:00',
        ]);

        $url = newmr_event_permalink( '/events/%eyear%/%event%/', get_post( $post_id ), false );
        $this->assertSame( '/events/2022/future-event/', $url );
    }
}
