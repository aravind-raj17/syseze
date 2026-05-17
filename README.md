# SysEze — Deploy Repo

This repo is structured so Hostinger's GitHub Auto-Deploy drops files in the right place.

## How it works

- Hostinger reads this repo and writes everything to `/public_html/` on the server.
- Theme files live inside `wp-content/themes/syseze/` in this repo.
- So when Hostinger deploys, the theme lands at `/public_html/wp-content/themes/syseze/` — exactly where WordPress expects it. Your WordPress installation is untouched.

## Setup

1. **GitHub:** push the contents of this folder to your `syseze` repo.
2. **Hostinger:** Dashboard → Git → Auto-deploy from `aravind-raj17/syseze` (branch `main`). Hostinger will set "Root directory" to `public_html` automatically — that's correct.
3. **WordPress admin:** Appearance → Themes → activate **SysEze**.

That's it. From here on, every push to GitHub auto-deploys to the live site within seconds.
