UPLINK — WORDPRESS UPLOAD PACKAGE
==================================

This package contains 3 long-form blog posts ready to upload to WordPress.

CONTENTS
--------
  posts/
    zero-trust-isnt-a-product.html         — Article 1 (Security)
    helpdesk-that-closes-its-own-tickets.html — Article 2 (Automation)
    migrating-12000-vms-in-90-days.html    — Article 3 (Cloud Migration)
  images/
    zero-trust-isnt-a-product.txt          — Image source URLs (Unsplash)
    helpdesk-that-closes-its-own-tickets.txt
    migrating-12000-vms-in-90-days.txt
  preview.html                              — Open in a browser to preview
                                              how each post will look


HOW TO UPLOAD EACH POST
-----------------------
For each .html file in posts/:

  1. Open the file in any text editor. The TOP of the file is an
     instruction block (in HTML comments) telling you:
       - The post title to use
       - The category to assign
       - The featured image to upload

  2. In WordPress, go to:  Posts → Add New

  3. Set the Title (copy from the instruction block).

  4. Switch the editor to CODE view:
       Click the ⋮ menu in the top-right → "Code editor"
     (In Classic Editor, click the "Text" tab.)

  5. Open the .html file and copy EVERYTHING below the
     "PASTE EVERYTHING BELOW THIS LINE" marker.
     Paste it into the WordPress code editor.

  6. Switch back to Visual editor — WordPress will render the post.

  7. In the right sidebar:
       - Set the Category (from the instruction block)
       - Set the Featured Image (upload the matching image
         from the images/ folder)
       - Set the publish date if you want to backdate

  8. Click Publish.


ABOUT THE IMAGES
----------------
The hero images currently load from Unsplash (free, license-free URLs).
You have two choices:

  Option A — Keep them as remote URLs (easiest):
    Do nothing. The <img src="..."> in each post already points to
    Unsplash. The image will load from there. This works fine but
    depends on Unsplash staying up.

  Option B — Upload to your WordPress Media Library (recommended):
    1. Open the corresponding .txt file in images/ — it contains
       the direct download URL.
    2. Right-click the URL → Save Image As → download the .jpg.
    3. In WordPress: Media → Add New → upload it.
    4. Copy the new Media Library URL.
    5. In the post's code editor, replace the Unsplash URL with
       your new Media Library URL.

  Or use a plugin like "Auto Upload Images" to do this in one click
  per post.


STYLING
-------
Each post has a small <style> block at the top that styles ONLY
elements inside the .uplink-post wrapper, so it won't interfere with
the rest of your theme. If your theme already has nice typography,
you can safely delete the <style> block and the post will inherit
your theme's defaults.


CATEGORIES
----------
Article 1 → Security
Article 2 → Automation
Article 3 → Cloud Migration

(Create these categories in WordPress before uploading if they don't
exist: Posts → Categories.)


QUESTIONS / TWEAKS
------------------
Open preview.html in your browser to see how each post will render
once pasted into WordPress.

Have fun!
