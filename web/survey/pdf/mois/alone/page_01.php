<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 14/05/14
 * Time: 08:55
 */
  /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/
?>
<style type="text/css">
    table{
        width: 100%;

    }
    table.table{
        border: none; min-width:100%; border-collapse: collapse;table-layout: fixed;
    }
    table.table.small tr th, table.table.small tr td{
        font-size: 6pt;
    }
    table.table tr th{
        text-align: left;
        background-color: #97bf0d;
        color: #ffffff;
    }
    table.table tr th, table.table tr td {
        padding: 1mm;
    }
    table.table tr.odd {
        background-color: #dfe782;
    }
    table.table tr.even {
        background-color: #97bf0d;
    }
    table.page_footer{  padding: 2mm; }
    table.page-header{padding: 2mm;}
    table.page-header tr td{
        width: 100%;
        text-align: center;
        padding: 10pt;
    }
    table.page-header tr td span.big{
        font-size: 24pt;
    }
    table.page-header tr td span.regular{
        font-size: 15pt;
        font-weight: bold;
    }
    tr.highlight{
        background-color: #d03838;
        color: #fff;
    }
    td.big-header{
        border: 1pt solid #A9A085;
        color: #97bf0d;
        background-color: #f6f3ea;
        font-size: 30pt;
        padding: 10pt;
    }
    td.sub-header{
        color: #000000;
        font-size: 15pt;
        font-weight: bold;

        padding: 10pt;
    }
    td.header{
        font-size: 18pt;
        font-weight: bold;
        padding: 10pt;
        color: #97bf0d;
        text-decoration: underline;
    }
    td.big-header, td.header, td.sub-header{
        width: 70%;
        text-align: center;
    }
    .page-footer-title{
        color: #97bf0d;
        font-weight: bold;
    }
</style>
<page orientation="L" format="A4" backtop="5mm" backright="5mm" backleft="5mm" backbottom="20mm">
    <page_footer>
        <table class="page_footer">
            <tr>
                <td style="width: 33%; text-align: left;"><?php echo $annee; ?></td>
                <td style="width: 33%; text-align: center;"><span class="page-footer-title">Les Jardins de Beauval</span></td>
                <td style="width: 33%; text-align: right;">[[page_cu]]</td>
            </tr>
        </table>
    </page_footer>
    <table style="margin-top: 50mm;">
        <tr>
            <td style="width: 15%;"></td>
            <td class="big-header">Les Jardins de Beauval</td>
            <td style="width: 15%;"></td>
        </tr>
        <tr>
            <td style="width: 15%;"></td>
            <td class="sub-header">Résultats de l'enquête de satisfaction</td>
            <td style="width: 15%;"></td>
        </tr>
        <tr>
            <td style="width: 15%;"></td>
            <td class="header"><?php echo ucfirst($datas_mois[$monthStart-1]) . " " . $annee; ?></td>
            <td style="width: 15%;"></td>
        </tr>
    </table>

</page>



















