<?php
/**
 * Standalone (non-WordPress) version of the line card with static content.
 *
 * Run from this folder after `composer install` in the repo root:
 *   php -S localhost:8000   then open http://localhost:8000/standalone-line-card.php
 */
use Dompdf\Dompdf;
use Dompdf\Options;

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

$options = new Options();
$fontDir = dirname( __DIR__ ) . '/fonts/Raleway/static';
$dompdf = new Dompdf([
    'fontDir' => $fontDir,
    'fontCache' => $fontDir,
    'tempDir' => $fontDir,
    'chroot' => dirname( __DIR__ ),
    'isRemoteEnabled'=> true,
]);
$fontRegular = $fontDir . '/Raleway-Regular.ttf';
$fontMedium = $fontDir . '/Raleway-Medium.ttf';
$fontBold = $fontDir . '/Raleway-Bold.ttf';
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SK Line Card PDF</title>

    <style>
        /* cyrillic-ext */
@font-face {
  font-family: 'Raleway';
  src: url('<?= $fontRegular ?>') format('truetype');
  font-style: normal;
  font-weight: 300;}
/* cyrillic-ext */
@font-face {
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 400;
  src: url('<?= $fontMedium ?>') format('truetype');
}

@font-face {
  font-family: 'Raleway';
  font-style: normal;
  font-weight: 600;
  src: url('<?= $fontBold ?>') format('truetype');
}
        .header{
            padding-top:10px;
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
            width: 170px;
            padding-left: 15px;
        }
        .section-title {
            background-color: #3c9d0b;
            padding: 10px 15px;
            margin-top: 20px;
            color: #fff;
             font-size: 16px; 
            font-family: 'Raleway', sans-serif;
            line-height: 1;
            font-weight: 600;
        }
        .footer-bar {
            background-color: #43a808;
            color: white;
            font-weight: 600;
            padding: 10px 15px;
            font-size: 15px;
            margin-top: 20px;
        }
        .footer-bar a {
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }
        .main-div h4 {
            color: #3c9d0b;
            padding: 0px 0px 15px 15px;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 0px;
            margin-top:15px;
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
            font-size: 11px;
            color: #9192a3;
            padding-top:5px;
            padding-bottom:5px;
            padding-left:15px;
            line-height: 1;
        }
        div{
            font-family: 'Raleway', sans-serif;
            line-height: 1;
        }
        p{
            font-family: 'Raleway', sans-serif;
            line-height: 1;
           
        }
        h4{
            font-family: 'Raleway', sans-serif;
            line-height: 1;
        }
        .col-md-3 {
            display: inline-block;
            width: 20%;
            vertical-align:middle;
        }
        .col-md-3  span{
            display:block;
          
        }
    

        @page { margin: 20px 40px 20px 40px; }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="header">
            <img src="https://skandassociates.com/wp-content/uploads/2023/05/logo-1.png" width="150">
            <p class="mb-0">20/22 Carver Circle<br>Canton, Ma 02021</p>
        </div>

        <div class="section-title">Representing the industry’s best manufacturers</div>
        <div class="main-div">
                                                <h4>Decorative &amp; Custom</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">Absolux Lighting</div>
                                                                    <div class="col-md-3">GM Lighting </div>
                                                                    <div class="col-md-3">Manning Lighting</div>
                                                                    <div class="col-md-3">Quattrobi</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Bethel International</div>
                                                                    <div class="col-md-3">IKIO</div>
                                                                    <div class="col-md-3">Mario Contract Industries</div>
                                                                    <div class="col-md-3">Snowball Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Bloom Lighting</div>
                                                                    <div class="col-md-3">lncon Lighting </div>
                                                                    <div class="col-md-3">Meomi Lighting</div>
                                                                    <div class="col-md-3">Solais+Energylite</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Chameleon Lighting</div>
                                                                    <div class="col-md-3">LED Industries USA</div>
                                                                    <div class="col-md-3">MIORA-Luminaire</div>
                                                                    <div class="col-md-3">Teron Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Del Toro Lighting</div>
                                                                    <div class="col-md-3">LEUCOS Lighting</div>
                                                                    <div class="col-md-3">NEMO Lighting</div>
                                                                    <div class="col-md-3">Til Industry</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">DESIGN HOUSE Lighting</div>
                                                                    <div class="col-md-3">LumosCielo Lighting </div>
                                                                    <div class="col-md-3">Newstamp Lighting</div>
                                                                    <div class="col-md-3">TMS Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">EKLIPSE Lighting</div>
                                                                    <div class="col-md-3">Lumpure Lighting</div>
                                                                    <div class="col-md-3">Poe Lighting USA</div>
                                                                    <div class="col-md-3">ZiLux</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">ELCO Lighting</div>
                                                                    <div class="col-md-3">Lumen Warm</div>
                                                                    <div class="col-md-3">OPTIQUE Lighting</div>
                                                                    <div class="col-md-3">ZLED Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">G Lighting</div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            <h4>Industrial, Hazardous &amp; Security</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">ABB Hazlux</div>
                                                                    <div class="col-md-3">DuraGuard</div>
                                                                    <div class="col-md-3">LamarLED</div>
                                                                    <div class="col-md-3">SONARAY Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">All Green Lighting</div>
                                                                    <div class="col-md-3">DURAY Lighting</div>
                                                                    <div class="col-md-3">LDPI</div>
                                                                    <div class="col-md-3">TACTICK</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Arcus Light</div>
                                                                    <div class="col-md-3">Esco Lighting</div>
                                                                    <div class="col-md-3">Sigmalux Commercial Lighting </div>
                                                                    <div class="col-md-3">Xtralight</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Best Lights</div>
                                                                    <div class="col-md-3">Kurtzon Lighting</div>
                                                                    <div class="col-md-3">Solas Ray</div>
                                                                    <div class="col-md-3">ZLED Lighting</div>
                                                                                            </div>
                                                            <h4>Architectural Linear, Recessed &amp; Downlighting </h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">ARLEE Lighting</div>
                                                                    <div class="col-md-3">Glacier Architectural Lighting</div>
                                                                    <div class="col-md-3">National Lighting</div>
                                                                    <div class="col-md-3">Renova lighting </div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Atlantic Lighting</div>
                                                                    <div class="col-md-3">IKIO</div>
                                                                    <div class="col-md-3">OPTIQUE Lighting</div>
                                                                    <div class="col-md-3">Snowball Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Chameleon Lighting</div>
                                                                    <div class="col-md-3">LamarLED</div>
                                                                    <div class="col-md-3">Peachtree Lighting</div>
                                                                    <div class="col-md-3">Solais+Energylite</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Delviro Energy</div>
                                                                    <div class="col-md-3">Lantana LED</div>
                                                                    <div class="col-md-3">Poe Lighting USA</div>
                                                                    <div class="col-md-3">Utopia Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">ELCO Lighting</div>
                                                                    <div class="col-md-3">LED Industries USA</div>
                                                                    <div class="col-md-3">Precision Architectural Ltg.</div>
                                                                    <div class="col-md-3">Xtralight</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Elium Lighting</div>
                                                                    <div class="col-md-3">LumosCielo Lighting </div>
                                                                    <div class="col-md-3">Quantalight</div>
                                                                    <div class="col-md-3">EKLIPSE Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">LUX llluminaire</div>
                                                                    <div class="col-md-3">Quattrobi</div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            <h4>Exterior Lighting Products</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">AEON Lighting</div>
                                                                    <div class="col-md-3">DESIGN HOUSE Lighting </div>
                                                                    <div class="col-md-3">Ryther-Purdy Wood Poles</div>
                                                                    <div class="col-md-3">WJM</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">All Green Lighting</div>
                                                                    <div class="col-md-3">DuraGuard</div>
                                                                    <div class="col-md-3">Shakespeare Poles</div>
                                                                    <div class="col-md-3">Xtralight</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Alumilite</div>
                                                                    <div class="col-md-3">Esco Lighting</div>
                                                                    <div class="col-md-3">Sigmalux Commercial Lighting</div>
                                                                    <div class="col-md-3">ZiLux</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">ARTEC Lighting</div>
                                                                    <div class="col-md-3">HCI Lighting</div>
                                                                    <div class="col-md-3">SLG Lighting</div>
                                                                    <div class="col-md-3">Clear World Solar Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Lumca Lighting</div>
                                                                    <div class="col-md-3">Teron Lighting</div>
                                                                    <div class="col-md-3">Del Toro Lighting</div>
                                                                    <div class="col-md-3">Paraflex Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">Visionaire Lighting </div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            <h4>Landscape Lighting</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">AEON Lighting</div>
                                                                    <div class="col-md-3">Garden Light LED</div>
                                                                    <div class="col-md-3">Paraflex Lighting </div>
                                                                    <div class="col-md-3">ZiLux</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">ARTEC Lighting</div>
                                                                    <div class="col-md-3">Paraflex Lighting </div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            <h4>Emergency Lighting </h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">Crucial Power Products</div>
                                                                    <div class="col-md-3">Emergi-Lite</div>
                                                                    <div class="col-md-3">Lightalarms</div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            <h4>Standard Commercial Lighting Luminaires</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">Best Lights </div>
                                                                    <div class="col-md-3">LamarLED</div>
                                                                    <div class="col-md-3">SLG Lighting</div>
                                                                    <div class="col-md-3">Xtralight</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">DESIGN HOUSE Lighting</div>
                                                                    <div class="col-md-3">LA Lighting</div>
                                                                    <div class="col-md-3">Utopia Lighting</div>
                                                                    <div class="col-md-3">ZLED Lighting</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">DuraGuard</div>
                                                                    <div class="col-md-3">Renova lighting </div>
                                                                    <div class="col-md-3">WHD Energy</div>
                                                                    <div class="col-md-3">KB Lighting</div>
                                                                                            </div>
                                                            <h4>LTG &amp; DMX Controls - Sensors</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">Autani</div>
                                                                    <div class="col-md-3">Lehigh Electric</div>
                                                                    <div class="col-md-3">PLC Multipoint</div>
                                                                    <div class="col-md-3">LED Industries USA</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">LEVITON</div>
                                                                    <div class="col-md-3">Poe Lighting USA</div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            <h4>Medical, Clean Room &amp; Food Process  </h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">Kurtzon Lighting</div>
                                                                    <div class="col-md-3">LA Lighting</div>
                                                                    <div class="col-md-3">SONARAY Lighting</div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            <h4>Area/Site Lighting</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">AlumiLite</div>
                                                                    <div class="col-md-3">HCI Lighting</div>
                                                                    <div class="col-md-3">Visionaire</div>
                                                                    <div class="col-md-3">Zilux</div>
                                                                                            </div>
                                                    <div class="row mb-0">
                                                                    <div class="col-md-3">DuraGuard</div>
                                                                    <div class="col-md-3">Lumca Lighting</div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            <h4>Poles/Structures.</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">Ryther-Purdy</div>
                                                                    <div class="col-md-3">Shakespeare</div>
                                                                    <div class="col-md-3">WJM</div>
                                                                    <div class="col-md-3">Zilux</div>
                                                                                            </div>
                                                            <h4>Lamps &amp; Accessories</h4>                            <div class="row mb-0">
                                                                    <div class="col-md-3">HYLITE Led Lighting</div>
                                                                    <div class="col-md-3">ZLED Lighting</div>
                                                                                                    <div class="col-md-3">&nbsp;</div>
                                                                    <div class="col-md-3">&nbsp;</div>
                                                            </div>
                                                            </div>

        <div class="footer-bar d-flex justify-content-left align-items-center flex-wrap">
            <a href="http://www.skandassociates.com">www.skandassociates.com</a>
            <span class="mx-2">|</span>
            <span>Phone: <strong><a href="tel:7818211700">781-821-1700</a></strong></span>
            <span class="mx-2">|</span>
            <span>Fax: <strong><a href="tel:7818214100">781-821-4100</a></strong></span>
        </div>
    </div>
</body>
</html>
<?php
// die;
$html = ob_get_clean();
$dompdf->loadHtml($html);
// $dompdf->setPaper('A4', 'portrait');
$customPaper = array(0,0,680,1360);
$dompdf->setPaper($customPaper);
$dompdf->render();
$dompdf->stream('sk-linecard.pdf', ['Attachment' => false]);
exit;
