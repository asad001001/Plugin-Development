<?php
/**
 * Line card PDF template (rendered by Dompdf).
 *
 * Reads the ACF repeater "pdf_detail" (group_title + manufacturers[].manufacturer_name)
 * from the page and lays manufacturer names out in 4 columns, filled top-to-bottom.
 *
 * Available variables: $post_id, $font_regular, $font_medium, $font_bold, $logo_url.
 *
 * @package PdfLineCard
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SK Line Card PDF</title>

    <style>

@font-face {
  font-family: 'Raleway';
  src: url('<?php echo esc_attr( $font_regular ); ?>') format('truetype');
  font-style: normal;
  font-weight: 300;}

@font-face {
  font-family: 'Raleway';
  src: url('<?php echo esc_attr( $font_medium ); ?>') format('truetype');
  font-style: normal;
  font-weight: 400;
}

@font-face {
  font-family: 'Raleway';
  src: url('<?php echo esc_attr( $font_bold ); ?>') format('truetype');
  font-style: normal;
  font-weight: 600;
}

body, div, p, span, h4, a, strong {
    font-family: 'Raleway';
    font-size: 9px;
    line-height: 1;
}

.header{
    padding-top:5px;
}

.header p {
    display: inline-block;
    vertical-align: middle;
    font-weight: 300;
}

.header img {
    margin-right: 57%;
    display: inline-block;
    vertical-align: middle;
    width: 210px;
    padding-left: 10px;
}
.section-title {
    background-color: #3c9d0b;
    padding: 5px 10px;
    margin-top: 10px;
    color: #fff;
    font-size: 10px;
    font-weight: 600;
}
.footer-bar {
    background-color: #43a808;
    color: white;
    font-weight: 600;
    padding: 5px 10px;
    font-size: 11px;
    margin-top: 10px;
}
.footer-bar a {
    color: #fff;
    font-weight: 700;
    text-decoration: none;
}
.main-div h4 {
    color: #3c9d0b;
    padding: 4px 0px;
    font-size: 10px;
    font-weight: 600;
    margin-bottom: 0px;
    margin-top:0px;
}
.main-div .row.mb-0:nth-child(even) {
    background: #f9f9f9;
    margin: 0px 1px;
}
.main-div .row.mb-0:nth-child(odd) {
    background: #f1f1f1;
    margin: 0px 1px;
}
.main-div .col-md-3 {
    font-size: 9px;
    color: #333;
    padding-top: 2px;
    padding-bottom: 2px;
    padding-left: 10px;
    line-height: 1;
    width: 22%;
    display: inline-block;
    vertical-align:middle;
}
.col-md-3 span{
    display:block;
}
@page { margin: 10px 20px 10px 20px; }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="header">
            <img src="<?php echo esc_url( $logo_url ); ?>" width="120" alt="">
            <p class="mb-0">20/22 Carver Circle<br>Canton, Ma 02021</p>
        </div>

        <div class="section-title">Representing the industry’s best manufacturers</div>
      <div class="main-div">
    <?php if (have_rows('pdf_detail',$post_id)): ?>
        <?php while (have_rows('pdf_detail',$post_id)): the_row(); ?>
            <?php 
                $group_title = get_sub_field('group_title');
                $manufacturers = [];

                if (have_rows('manufacturers')) {
                    while (have_rows('manufacturers')) {
                        the_row();
                        $manufacturers[] = get_sub_field('manufacturer_name');
                    }
                }

                $manufacturers = array_map('trim', $manufacturers);
                natcasesort($manufacturers);
                $manufacturers = array_values($manufacturers);

                if ($group_title) {
                    echo '<h4>' . esc_html($group_title) . '</h4>';
                }

                $total = count($manufacturers);
                $cols = 4;
                $rows = ceil($total / $cols);
                $vertical = [];

                for ($i = 0; $i < $rows; $i++) {
                    $vertical[$i] = [];
                    for ($j = 0; $j < $cols; $j++) {
                        $index = $j * $rows + $i;
                        if (isset($manufacturers[$index])) {
                            $vertical[$i][] = $manufacturers[$index];
                        } else {
                            $vertical[$i][] = '';
                        }
                    }
                }

                foreach ($vertical as $row) {
                    echo '<div class="row mb-0">';
                    foreach ($row as $manufacturer) {
                        echo '<div class="col-md-3">' . esc_html($manufacturer) . '</div>';
                    }
                    echo '</div>';
                }
            ?>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

        <div class="footer-bar d-flex justify-content-left align-items-center flex-wrap">
            <span>www.skandassociates.com</span>
            <span class="mx-2">|</span>
            <span>Phone: <strong><span>781-821-1700</span></strong></span>
            <span class="mx-2">|</span>
            <span>Fax: <strong><span>781-821-4100</span></strong></span>
        </div>
    </div>
</body>
</html>
