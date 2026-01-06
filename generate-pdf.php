<?php
//pdf genration.

function add_pdf_preview_meta_box() {
    add_meta_box(
        'pdf_preview_meta_box',           // Meta box ID
        'PDF Preview & Update',           // Title
        'pdf_preview_meta_box_callback',  // Callback function
        'page',                           // Post type
        'side',                           // Context (where to display the meta box)
        'high'                            // Priority
    );
}
add_action('add_meta_boxes', 'add_pdf_preview_meta_box');

// Callback function to render the buttons
function pdf_preview_meta_box_callback($post) {
    if($post->ID == 6067){
    ?>
    <button type="button" id="preview_pdf" class="button button-primary">Generate & Preview PDF</button>
    <button type="button" id="update_pdf" value="<?= home_url(); ?>/wp-content/uploads/pdfs/card_line.pdf" onclick="copyValue(this)" class="button button-secondary" style="display:none;">📋 Copy URL</button>
    <!--<button value="abc" onclick="copyValue(this)">📋 Copy</button>-->

    <script>
        function copyValue(btn) {
            const valueToCopy = btn.value;
            const dummy = document.createElement("input");
            document.body.appendChild(dummy);
            dummy.setAttribute("value", valueToCopy);
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
            alert("Copied: " + valueToCopy);
        }
        </script>
    <div id="pdf_preview" style="margin-top: 20px;"></div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#preview_pdf').on('click', function() {
                var postId = <?php echo $post->ID; ?>;
                
                // AJAX call to generate PDF preview
                $.post(ajaxurl, {
                    action: 'generate_pdf_preview',
                    post_id: postId
                }, function(response) {
                    $('#pdf_preview').html('<iframe src="<?= home_url(); ?>/wp-content/uploads/pdfs/line-card.pdf" width="100%" height="500px"></iframe>');
                    $('#update_pdf').show();  // Show the update button once preview is generated
                });
            });

           
        });
    </script>
    <?php
    }
}
use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/pdf/vendor/autoload.php'; // Adjust path if needed
// Generate PDF preview
function generate_pdf_preview() {
    $post_id = $_POST['post_id'];

    // Load content to be converted to PDF (you can load HTML from the post)
   
$fontDir = get_stylesheet_directory() . '/pdf/Raleway/static';

$dompdf = new Dompdf([
    'fontDir' => $fontDir,
    'fontCache' => $fontDir,
    'tempDir' => $fontDir,
    'chroot' => $fontDir,
    'isRemoteEnabled' => true,
]);

$fontRegular = $fontDir . '/Raleway-Regular.ttf';
$fontMedium  = $fontDir . '/Raleway-Medium.ttf';
$fontBold    = $fontDir . '/Raleway-Bold.ttf';

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SK Line Card PDF</title>

    <style>

@font-face {
  font-family: 'Raleway';
  src: url('<?= $fontRegular ?>') format('truetype');
  font-style: normal;
  font-weight: 300;}

@font-face {
  font-family: 'Raleway';
  src: url('<?= $fontMedium ?>') format('truetype');
  font-style: normal;
  font-weight: 400;
}

@font-face {
  font-family: 'Raleway';
  src: url('<?= $fontBold ?>') format('truetype');
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
            <img src="https://wp.hashe.com/sk/wp-content/uploads/2025/07/image3.png" width="120">
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

<?php
// die;
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait');
//$customPaper = array(0,0,680,1360);
//$dompdf->setPaper($customPaper);


    $dompdf->render();
    
     $upload_dir = wp_upload_dir();
    $pdf_dir = $upload_dir['basedir'] . '/pdfs';
    if (!file_exists($pdf_dir)) {
        mkdir($pdf_dir, 0755, true);
    }
    // Output to a file (you can change the file path as needed)
$pdf_file_path = $upload_dir['basedir'] . '/pdfs/line-card.pdf';

    // $pdf_file_path = __DIR__. '/pdf/file/card-line.pdf';
    file_put_contents($pdf_file_path, $dompdf->output());
$pdf_file_url  = $upload_dir['baseurl'] . '/pdfs/line-card.pdf';

    // Return the URL of the preview PDF
    echo json_encode(['pdf_url' => $pdf_file_url]);
    wp_die();
}
add_action('wp_ajax_generate_pdf_preview', 'generate_pdf_preview');
