# PDF Line Card Generator (WordPress)

A WordPress plugin that turns ACF data on a page into a branded, print-ready **line card PDF** — a one-page list of the manufacturers a sales agency represents, grouped by category — using **Dompdf** with embedded **Raleway** fonts.

## Features

- **One-click generation** – a "PDF Preview & Update" box on the line-card page generates the PDF and previews it inline.
- **Shareable link** – the PDF is saved to `wp-content/uploads/pdfs/line-card.pdf`; copy the URL with one click.
- **Smart layout** – manufacturer names are sorted naturally and flowed into four columns top-to-bottom, with zebra rows.
- **Secure** – AJAX protected by a nonce and the `edit_post` capability.

## Requirements

- WordPress 6.0+, PHP 7.4+
- [Advanced Custom Fields](https://www.advancedcustomfields.com/) with a repeater `pdf_detail` → `group_title` (text) + `manufacturers` (repeater → `manufacturer_name`)
- Composer

## Installation

```bash
cd wp-content/plugins
git clone https://github.com/asad001001/wp-pdf-generator.git pdf-line-card
cd pdf-line-card
composer install --no-dev
```

Activate **PDF Line Card Generator**, then set the page that holds the data and (optionally) the logo:

```php
add_filter( 'plc_page_id', fn() => 123 );
add_filter( 'plc_logo_url', fn() => 'https://example.com/logo.png' );
```

## Structure

```
├── wp-pdf-line-card.php          # Plugin: meta box, AJAX handler, PDF generation
├── templates/line-card.php       # HTML/CSS rendered by Dompdf
├── fonts/Raleway/                # Raleway (SIL Open Font License)
├── examples/standalone-line-card.php  # Same card without WordPress
├── composer.json / composer.lock # dompdf/dompdf ^3.1
```

## License

GPL-2.0-or-later. Raleway font: SIL Open Font License (see `fonts/Raleway/OFL.txt`).
