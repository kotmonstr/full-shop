<div class="panel-group category-products" id="accordian"><!--category-productsr-->

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="javascript:void(0);" class="bold_and_ellow" onclick="getGoodsByCategoryId(0)">Все
                </a>
            </h4>
        </div>
    </div>
    <?php foreach ($modelGoodsCategories as $categoria): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <?php if(isset($Ajax)){ ?>
                    <a href="javascript:void(0);" class="bold_and_ellow" onclick="getGoodsByCategoryId(<?= $categoria->id ?>)"><?= $categoria->name ?>

                        <?php  }else{ ?>
                        <a href="/shop/products?categoria=<?= $categoria->id ?>" class="bold_and_ellow" ><?= $categoria->name ?>
                        <?php  } ?>
                    </a>
                </h4>
            </div>
        </div>
    <?php endforeach ?>

</div>
<style>
    .bold_and_ellow:hover {
        color: #FE980F!important;
        font-weight: bolder;
    }
</style>