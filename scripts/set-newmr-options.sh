#!/usr/bin/env bash
set -euo pipefail

# Environment variables:
#   DONATE_BOX_HTML      - HTML for the Donate widget (required)
#   ABOUT_BOX_HTML       - HTML for the About widget (required)
#   GA_CODE              - Google Analytics tracking ID (required)
#   LEFT_PAGE_SLUG       - Slug for left footer link page (required)
#   RIGHT_PAGE_SLUG      - Slug for right footer link page (required)
#   FEATURED_VIDEO_SLUG  - Slug for featured video page (required)

: "${DONATE_BOX_HTML:?DONATE_BOX_HTML is required}"
: "${ABOUT_BOX_HTML:?ABOUT_BOX_HTML is required}"
: "${GA_CODE:?GA_CODE is required}"
: "${LEFT_PAGE_SLUG:?LEFT_PAGE_SLUG is required}"
: "${RIGHT_PAGE_SLUG:?RIGHT_PAGE_SLUG is required}"
: "${FEATURED_VIDEO_SLUG:?FEATURED_VIDEO_SLUG is required}"

wp option update newmr_front_middle_left   "$DONATE_BOX_HTML"
wp option update newmr_front_bottom_right "$ABOUT_BOX_HTML"
wp option update newmr_ga_tracking_code   "$GA_CODE"
wp option update newmr_left_footer_link   "$LEFT_PAGE_SLUG"
wp option update newmr_right_footer_link  "$RIGHT_PAGE_SLUG"
wp option update newmr_featured_video     "$FEATURED_VIDEO_SLUG"


echo "NewMR options updated."

# Ensure static front page (Home) and posts page (Blog) exist and are configured.
# (Block theme will use templates/front-page.html automatically for the Home page.)
# Create Home page if missing and set as front page.
HOME_PAGE_ID=$(wp post list --post_type=page --field=ID --format=ids --title="Home" || true)
if [ -z "$HOME_PAGE_ID" ]; then
  HOME_PAGE_ID=$(wp post create --post_type=page --post_title="Home" --post_status=publish --porcelain)
else
  # Ensure slug is consistent
  wp post update "$HOME_PAGE_ID" --post_name=home >/dev/null 2>&1

fi

# Create Blog page if missing and set as posts page.
BLOG_PAGE_ID=$(wp post list --post_type=page --field=ID --format=ids --title="Blog" || true)
if [ -z "$BLOG_PAGE_ID" ]; then
  BLOG_PAGE_ID=$(wp post create --post_type=page --post_title="Blog" --post_status=publish --porcelain)
else
  wp post update "$BLOG_PAGE_ID" --post_name=blog >/dev/null 2>&1
fi

# Ensure Blog page uses the default (no custom) page template
wp post meta delete "$BLOG_PAGE_ID" _wp_page_template >/dev/null 2>&1 || true

wp option update show_on_front page
wp option update page_on_front "$HOME_PAGE_ID"
wp option update page_for_posts "$BLOG_PAGE_ID"

echo "Front page set to Home (ID: $HOME_PAGE_ID), posts page set to Blog (ID: $BLOG_PAGE_ID)."
