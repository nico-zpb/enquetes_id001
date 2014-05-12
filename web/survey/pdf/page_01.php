<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 12/05/14
 * Time: 08:37
 */
?>
<style type="text/css">
    table{border: none; width:100%;}
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
            <td class="header">Rapport sur l'année <?php echo $annee; ?></td>
            <td style="width: 15%;"></td>
        </tr>
    </table>

</page>
