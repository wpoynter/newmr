<?php

class PostTypeRegistrationTest extends WP_UnitTestCase {
	public function set_up() {
		parent::set_up();
		newmr_plugin_activate();
	}

	public function test_post_types_registered() {
		foreach ( array( 'booth', 'advert', 'event', 'presentation', 'person' ) as $type ) {
		$this->assertTrue( post_type_exists( $type ), "Post type {$type} not registered" );
	}
	}

       public function test_taxonomy_registered() {
               $this->assertTrue( taxonomy_exists( 'topic' ) );
       }

       public function test_event_constant_defined() {
               $this->assertTrue( defined( 'EP_EVENT' ) );
       }

	public function test_event_permastruct() {
		global $wp_rewrite;
		$this->assertSame( '/events/%eyear%/%event%/', $wp_rewrite->extra_permastructs['event']['struct'] );
	}

       public function test_play_again_rule_exists() {
               global $wp_rewrite;
               $rules = $wp_rewrite->extra_rules_top;
               $this->assertArrayHasKey( '^play-again/([^/]*)/([^/]*)/?$', $rules );
       }

       public function test_root_post_rule_exists() {
               global $wp_rewrite;
               $rules = $wp_rewrite->extra_rules;
               $this->assertArrayHasKey( '([^/]*)', $rules );
       }
}
