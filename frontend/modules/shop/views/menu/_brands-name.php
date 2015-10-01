<?php
  use common\models\Goods;

?>

<div class="brands-name">
    <ul class="nav nav-pills nav-stacked">

        <?php foreach($modelBrends as $brend): ?>
            <?php  $quantity = count(Goods::getQuantityOfGoodsByBrand($brend->id)); ?>
            <?php if(isset($Ajax)){ ?>
                <li><a class="bold_and_ellow" href="javascript:void(0);" onclick="getGoodsByBrend(<?= $brend->id; ?>)"> <span class="pull-right">(<?= $quantity ?>)</span><?= $brend->name ?></a></li>

          <?php  }else{ ?>

                <li><a class="bold_and_ellow" href="/shop/products?brand=<?= $brend->id ?>" > <span class="pull-right">(<?= $quantity ?>)</span><?= $brend->name ?></a></li>
          <?php  } ?>



        <?php endforeach; ?>

    </ul>
</div>