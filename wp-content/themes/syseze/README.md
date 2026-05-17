# SysEze WordPress Theme

A custom, classic WordPress theme for **SysEze Tech Pvt Ltd** — IT infrastructure, cloud, and cybersecurity. Built from scratch with the design system you reviewed: dark base, gradient accents, Inter + Space Grotesk + JetBrains Mono.

This is a fully editable WordPress theme — pages, posts, menus, portfolio, team, testimonials, and most copy are managed from the WP admin. No page builder required.

---

## 1. Installation

1. Zip the entire `syseze-theme/` folder (or use the zip provided).
2. In WordPress admin: **Appearance → Themes → Add New → Upload Theme** → upload the zip → **Install Now** → **Activate**.

If you prefer FTP / Hostinger File Manager: upload the unzipped `syseze-theme` folder into `wp-content/themes/`, then activate from **Appearance → Themes**.

---

## 2. One-time setup (~10 minutes)

### A. Permalinks
**Settings → Permalinks** → choose **Post name** (`/%postname%/`) → **Save Changes**. This is required for the portfolio CPT and clean URLs.

### B. Install Contact Form 7
- **Plugins → Add New** → search `Contact Form 7` → Install + Activate.
- Open **Contact** in the sidebar → edit the default form (or create a new one) with these fields:
  ```
  [text*       your-name      placeholder "Full name"]
  [email*      your-email     placeholder "Email"]
  [text        your-company   placeholder "Company"]
  [tel         your-phone     placeholder "Phone"]
  [select      your-service "Not sure yet" "Cloud Services" "IT Consulting" "Migration Services" "Network Design" "Cyber Security" "Business Support"]
  [textarea*   your-message   placeholder "How can we help?"]
  [submit class:btn class:btn-primary "Send Message"]
  ```
- Copy its shortcode (looks like `[contact-form-7 id="123" title="Contact"]`).
- Go to **Appearance → Customize → SysEze — Contact Form** → paste it in. Save.
- If you skip this, the page falls back to a static (non-sending) form.

### C. Create the core pages
Create these pages and assign the matching **Page Template** in the **Page Attributes** panel (right sidebar of the page editor):

| Page title | Slug         | Page template                  |
|------------|--------------|--------------------------------|
| Home       | `home`       | Default (front page) — see step D |
| About      | `about`      | `Template Name: About`         |
| Services   | `services`   | `Template Name: Services Overview` |
| Cloud Services      | `cloud-services`      | `Template Name: Service — Cloud Services` |
| IT Consulting       | `it-consulting`       | `Template Name: Service — IT Consulting` |
| Migration Services  | `migration-services`  | `Template Name: Service — Migration Services` |
| Network Design      | `network-design`      | `Template Name: Service — Network Design` |
| Cyber Security      | `cyber-security`      | `Template Name: Service — Cyber Security` |
| Business Support    | `business-support`    | `Template Name: Service — Business Support` |
| Portfolio  | `portfolio`  | `Template Name: Portfolio`     |
| Blog       | `blog`       | `Template Name: Blog Index`    |
| Contact    | `contact`    | `Template Name: Contact`       |

**Important:** the slugs must match exactly — the theme uses them to wire up the nav, footer, and dropdown links.

### D. Set the front page and blog page
**Settings → Reading**
- *Your homepage displays*: **A static page**
- *Homepage*: leave blank — the theme uses `front-page.php` automatically.
- *Posts page*: select **Blog**.

(Optional: if you do want the WP "Home" page to drive the homepage instead of `front-page.php`, set Homepage = Home and don't worry about the `front-page.php` precedence; WP picks the most specific one.)

### E. Menus
**Appearance → Menus** → create a menu, assign it to the **Primary Menu** location. The theme will use this for the main nav. (If you skip this step, it falls back to the hardcoded nav — which is already wired up correctly, so this is optional.)

Optionally create two more menus for the footer: **Footer — Services** and **Footer — Company**.

### F. Customizer — fill in your details
**Appearance → Customize**:
- **Site Identity** → set the **Site Logo** (uploads the SysEze logo; defaults to the bundled PNG if empty).
- **SysEze — Stats** → tweak the four numbers (years, projects, industries, retention).
- **SysEze — Contact Info** → address, phone, email, hours.
- **SysEze — Social Links** → LinkedIn, Facebook, X, Instagram URLs.
- **SysEze — Contact Form** → paste your CF7 shortcode (from step B).
- **SysEze — Footer** → tagline, copyright line, credit.

---

## 3. Content management

### Portfolio (case studies)
**Portfolio → Add New Case Study**
- Title = case study name.
- Editor = the long write-up (shown on the single page).
- Excerpt = short summary on the grid card.
- Featured Image = the thumbnail.
- **Categories** (right sidebar) = used for the filter buttons. Add ones like `Cloud`, `Security`, `Network`, `Migration`, `Support`.
- **Case Study Details** (right sidebar) = `Industry` (e.g. "Healthcare") and `Year` (e.g. "2024") — both show in the meta line.

### Team members
**Team → Add Team Member**
- Title = full name.
- Editor = short bio.
- Featured Image = headshot (optional — initials are auto-generated if none).
- **Team Member Details** (right sidebar) = `Role` (e.g. "Founder & Principal Engineer").
- Order via **Order** in Page Attributes.

### Testimonials
**Testimonials → Add Testimonial**
- Title = author name (e.g. "Ramya Menon").
- Editor = the quote itself.
- **Author Details** (right sidebar) = `Role` and `Company`.
- Order via **Order** in Page Attributes.
- The top 3 (by menu order, then date) appear on the homepage. If none exist, three placeholders are shown.

### Blog posts
**Posts → Add New** — standard WordPress posts. Featured Image + Category + Excerpt all show in the layout.

---

## 4. Editing the design

| What                              | Where to edit                                          |
|-----------------------------------|--------------------------------------------------------|
| Colors, fonts, spacing tokens     | `assets/css/styles.css` — top of file, in `:root {}`   |
| Component styles (forms, FAQ, etc.) | `assets/css/pages.css`                                |
| JS (nav, scroll, FAQ, filter, form) | `assets/js/main.js`                                  |
| Header / nav markup               | `header.php`                                           |
| Footer markup                     | `footer.php`                                           |
| Homepage sections                 | `front-page.php`                                       |
| Service page structure (caps, FAQs) | `page-templates/template-<service>.php`              |

After editing CSS or JS, bump the version in `functions.php` (`define( 'SYSEZE_VERSION', '1.0.0' )`) so browsers don't serve a stale cached copy.

---

## 5. Deploying to Hostinger

If WordPress is already installed on Hostinger:

1. **Hostinger Panel → File Manager** → navigate to `public_html/wp-content/themes/`.
2. Upload the `syseze-theme` folder (or upload the zip and extract it there).
3. In WP admin → **Appearance → Themes** → activate **SysEze**.
4. Run the one-time setup (section 2 above).

Alternatively, install via **Appearance → Themes → Add New → Upload Theme** with the zip.

---

## 6. TODO before going live

- [ ] Wire up Contact Form 7 (section 2.B).
- [ ] Populate **Portfolio**, **Team**, and **Testimonial** posts with real content.
- [ ] Publish 3–6 real blog posts.
- [ ] Verify the four stats in the Customizer.
- [ ] Replace the homepage trust-strip text logos with real client logos (edit `front-page.php`, or wire to a Customizer setting later).
- [ ] Add a 1200×630 Open Graph image and set it as the site icon / social preview (an SEO plugin like Yoast or Rank Math will handle this).
- [ ] Install an SEO plugin (Rank Math or Yoast).
- [ ] Install a caching plugin (LiteSpeed Cache works well on Hostinger).

---

## 7. File structure

```
syseze-theme/
├── style.css                        # theme header (WordPress requirement)
├── functions.php                    # bootstrap — pulls in /inc/
├── header.php                       # nav + open <main>
├── footer.php                       # footer + close <main>
├── front-page.php                   # homepage
├── page.php                         # generic page fallback
├── single.php                       # single blog post
├── single-portfolio.php             # single case study
├── archive-portfolio.php            # portfolio archive (/portfolio/)
├── search.php                       # search results
├── 404.php                          # not-found page
├── index.php                        # required fallback
│
├── inc/
│   ├── setup.php                    # theme features, menus, image sizes
│   ├── enqueue.php                  # CSS + JS + Google fonts
│   ├── cpt.php                      # portfolio, team, testimonial CPTs + meta
│   ├── customizer.php               # stats, contact info, socials, footer
│   └── template-helpers.php         # syseze_arrow(), syseze_orbs(), CTA banner, etc.
│
├── page-templates/
│   ├── template-about.php
│   ├── template-services.php
│   ├── template-portfolio.php
│   ├── template-blog.php
│   ├── template-contact.php
│   ├── template-cloud-services.php
│   ├── template-it-consulting.php
│   ├── template-migration-services.php
│   ├── template-network-design.php
│   ├── template-cyber-security.php
│   └── template-business-support.php
│
└── assets/
    ├── css/
    │   ├── styles.css               # tokens, base, components
    │   └── pages.css                # FAQ, forms, portfolio, etc.
    ├── js/
    │   └── main.js                  # nav, mobile menu, reveal, FAQ, filter, form
    └── images/
        └── logo.png                 # fallback SysEze logo
```

---

## Credits

Theme built for SysEze Tech Pvt Ltd. Designed by Aravind Raj R.
