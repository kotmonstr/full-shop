<?php

use yii\helpers\Url;
use common\models\Cart;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\rating\StarRating;
use frontend\helpers\SetupSite;

$USD  = substr(SetupSite::getCurs("USD"),0);
$EUR  = substr(SetupSite::getCurs("EUR"),0);
$UKR = substr(SetupSite::getCurs("UAH"),0);

$Module = Yii::$app->getModule('shop');
$i = 1;
echo $this->render('/menu/_header', [
    'data' => $data,
    'USD' => $USD,
    'UKR' => $UKR,
    'EUR' => $EUR,
    'dropMenuActive'=>'blog'
]);
//vd($data['currCurency']);
switch ($data['currCurency']) {
    case 'RUB':
        $PRICE_1 = '';
        $PRICE_2 = ' Руб';
        $VALUTE = 1;
        break;
    case 'DOLLAR':
        $PRICE_1 = '$ ';
        $PRICE_2 = '';
        $VALUTE = $USD;
        break;
    case 'UAN':
        $PRICE_1 = '';
        $PRICE_2 = ' Грв';
        $VALUTE = $UKR;
        break;
    default:
        $PRICE_1 = '';
        $PRICE_2 = ' Руб';
        $VALUTE = 1;
}
?>

<section>
    <div class="container ">
        <div class="row">
            <div class="col-sm-3">

            </div>

            <?php if ($models){ ?>
            <div class="col-sm-12">
                <div class="blog-post-area">
                    <h2 class="title text-center">Новости</h2>


                    <?php foreach ($models as $blog): ?>

                        <div class="single-blog-post">
                            <h3><?= Html::encode($blog->title) ?></h3>
                            <?php
                            echo StarRating::widget([
                                'name' => $blog->id,
                                'id'=>$blog->id,
                                'value' => isset($blog->rating) ? $blog->rating : 0,
                                'pluginOptions' => [
                                    'readonly' => true,
                                    'showClear' => false,
                                    'showCaption' => false,
                                ],
                            ]); ?>

                            <div class="post-meta">
                                <ul>
                                    <li><i class="fa fa-user"></i><?= $blog->user->username; ?></li>
                                    <li><i class="fa fa-clock-o"></i><?= date("H:i", $blog->created_at); ?></li>
                                    <li><i class="fa fa-calendar"></i><?= date("d m Y", $blog->created_at); ?></li>
                                </ul>

                            </div>
                            <a href="">
                                <?php if ($blog->image): ?>
                                    <img src="<?= $Module::getBlogImage($blog->image) ?>" alt=""/>
                                <?php endif; ?>
                            </a>

                            <p><?= strip_tags(StringHelper::truncate($blog->content, 500)); ?></p>
                            <a class="btn btn-primary" href="/shop/blog-detail?id=<?= $blog->id ?>">Подробнее</a>
                        </div>


                    <?php endforeach; ?>




                    <?php
                    echo LinkPager::widget([
                        'pagination' => $pages,
                    ]);
                    ?>


                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .pagination {

        margin-top: 28px;

    }

    .star-rating{
        float: right;
        /* top: -14px; */
        margin-top: -30px;
    }
    .single-blog-post img{
        max-width: 840px;;
    }
</style>
