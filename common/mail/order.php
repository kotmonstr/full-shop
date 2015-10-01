<?php
use common\models\Goods;
?>

<div style="">
    <h3>Заказ #<?= $order_id ?></h3>
    <h3>Время #<?= $order_id ?></h3>
<?php foreach($listItemsInOrder as $item){
    //vd($item['good_id']);
    echo Goods::getName($item['good_id']) .'--'.$item['quantity'].'шт. --'.$item['price'].'р.<br>';
}





?>
</div>