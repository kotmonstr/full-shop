<div class="col-sm-3">
    <div class="left-sidebar">
        <?php if($modelGoodsCategories){ ?>
            <h2>Категории товаров</h2>
            <?= $this->render('/menu/_category-products', ['modelGoodsCategories' => $modelGoodsCategories]); ?>
        <?php } ?>
        <?php if($modelBrends){ ?>
            <div class="brands_products"><!--brands_products-->

                <h2>Бренды</h2>
                <?= $this->render('/menu/_brands-name', ['modelBrends' => $modelBrends]); ?>
            </div>
        <?php } ?>
        <!--/brands_products-->

        <div class="price-range"><!--price-range-->
            <h2>Цена</h2>

            <div class="well text-center" onratechange="getGoodsbyPriceRange()" style="">
                <input onratechange="getGoodsbyPriceRange()" type="text" class="span2" value="" data-slider-min="0" data-slider-max="10000"
                       data-slider-step="5" data-slider-value="[0,10000]" id="sl2"><br/>
                <b class="pull-left"><?= $PRICE_1 ?> 0<?= $PRICE_2 ?></b> <b class="pull-right"><?= $PRICE_1 ?> 10000<?= $PRICE_2 ?></b>
            </div>
        </div>
        <!--/price-range-->

        <div class="shipping text-center">
            <?= $this->render('/menu/_banner', ['modelBanner' => $modelBanner]); ?>

        </div>
        <!--/shipping-->

    </div>
</div>