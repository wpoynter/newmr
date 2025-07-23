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
