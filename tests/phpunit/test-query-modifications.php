<?php
class QueryModificationTest extends WP_UnitTestCase {
    public function set_up() {
        parent::set_up();
        newmr_plugin_activate();
    }

    public function test_booth_query_sorted_and_unlimited() {
        $q = new WP_Query( array( 'post_type' => 'booth' ) );
        $this->assertSame( 'ASC', $q->get( 'order' ) );
        $this->assertSame( -1, $q->get( 'posts_per_page' ) );
    }

    public function test_person_query_normalization_and_sort() {
        $q = new WP_Query( array( 'post_type' => 'person', 'name' => 'John Doe' ) );
        $this->assertSame( 'john-doe', $q->get( 'name' ) );
        $this->assertSame( -1, $q->get( 'posts_per_page' ) );
        $this->assertSame( 'title', $q->get( 'orderby' ) );
        $this->assertSame( 'ASC', $q->get( 'order' ) );
    }

    public function test_advert_query_sorted() {
        $q = new WP_Query( array( 'post_type' => 'advert' ) );
        $this->assertSame( 'ASC', $q->get( 'order' ) );
    }
}
