<?php

class PostTypeRegistrationTest extends WP_UnitTestCase {
    public function test_post_type_registered() {
        $this->assertTrue( post_type_exists( 'newmr_item' ) );
    }
}
