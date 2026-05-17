# Client Logos

Drop client logo files here. The homepage trust strip will auto-pick them up.

## How it works

Each `<a class="tl">` on the homepage references an image at this path:
```
assets/images/clients/<slug>.png
```

If the image file exists → it shows (auto-grayscale, full color on hover).
If it doesn't exist → the page falls back to a styled text wordmark with the company name.

So adding a logo is as simple as saving the file with the right name.

## Files to drop in

| Save as                          | Company                |
|----------------------------------|------------------------|
| `cmart-solutions.png`            | CMart Solutions        |
| `natural-remedies.png`           | Natural Remedies       |
| `silicon-patterns.png`           | Silicon Patterns       |
| `justo-global.png`               | Justo Global           |
| `cynlr.png`                      | CynLr (Vyuti Systems)  |

## Specs

- **Format:** PNG with transparent background (preferred), or SVG.
- **Height:** ~200px tall, width whatever's natural (the CSS displays them at 36px tall with `max-width: 180px`).
- **Color:** any. The CSS auto-applies grayscale + faded opacity, switching to full color on hover.
- **File size:** keep under 50KB each for fast page loads. Tools like TinyPNG / Squoosh make this easy.

## Where to get the logos

The user said: "You can download they're logo from there website directly." Open each company's site, right-click the logo in the header, **Save Image As…** (or download from their press/media kit if they have one):

- CMart Solutions — https://cmartsolutions.com/
- Natural Remedies — https://www.naturalremedy.com/
- Silicon Patterns — https://siliconpatterns.com/
- Justo Global — https://justoglobal.com/
- CynLr — https://www.cynlr.com/

## Adding more clients later

Open `index.html` (static site) or `syseze-theme/front-page.php` (WordPress) and copy the pattern for one of the existing clients. The `assets/images/clients/<slug>.png` path is the only filename you need to keep in sync.
