<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/04/2014
 * Time: 15:42
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
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h2>Profil des répondants</h2>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h3>Ils sont :</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Effectif</th>
                        <th>%</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>des hommes</td>
                        <td><?php echo $numMale; ?></td>
<td><?php echo $numMalePercent ?></td>
</tr>
<tr>
    <td>des femmes</td>
    <td><?php echo $numFemale; ?></td>
    <td><?php echo $numFemalePercent ?></td>
</tr>
<tr>
    <td>Total</td>
    <td><?php echo $numEntry; ?></td>
    <td>100%</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6">
    <h3>Tranches d'âge :</h3>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Effectif</th>
            <th>%</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($tranchesAge as $k=>$v): ?>
            <tr <?php if($k === $highlightAge){ echo ' class="success"';} ?>>
                <td><?php echo $v["name"]; ?></td>
                <td><?php echo $v["num"]; ?></td>
                <td><?php echo $v["percent"]; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td>Total</td>
            <td><?php echo $numEntry; ?></td>
            <td>100%</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="col-md-12">
    <h3>Profession :</h3>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Effectif</th>
            <th>%</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($prof as $k => $v): ?>
            <tr <?php if($k === $highlightProf){ echo ' class="success"';} ?>>
                <td><?php echo $v["name"]; ?></td>
                <td><?php echo $v["num"]; ?></td>
                <td><?php echo $v["percent"]; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td>Total</td>
            <td><?php echo $numEntry; ?></td>
            <td>100%</td>
        </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
