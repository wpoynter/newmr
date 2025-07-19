<?php
class PostTypeSupportsTest extends WP_UnitTestCase {
    public function set_up() {
        parent::set_up();
        newmr_plugin_activate();
    }

    public function test_booth_supports_features() {
        $this->assertTrue( post_type_supports( 'booth', 'title' ) );
        $this->assertTrue( post_type_supports( 'booth', 'editor' ) );
        $this->assertTrue( post_type_supports( 'booth', 'page-attributes' ) );
    }

    public function test_event_supports_features() {
        $this->assertTrue( post_type_supports( 'event', 'thumbnail' ) );
        $this->assertTrue( post_type_supports( 'event', 'revisions' ) );
        $this->assertTrue( post_type_supports( 'event', 'shortlinks' ) );
    }

    public function test_presentation_registered_to_topic() {
        $taxonomy = get_taxonomy( 'topic' );
        $this->assertContains( 'presentation', $taxonomy->object_type );
    }
}
