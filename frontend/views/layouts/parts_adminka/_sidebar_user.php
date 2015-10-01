<?php

use yii\helpers\Url;
use common\models\Goods;

$curModule = Yii::$app->controller->module->id;
$curContr = Yii::$app->controller->id;
$curAction = Yii::$app->controller->action->id;
$path = $curModule . '/' . $curAction;
$fullPath = $curModule . '/' . $curContr;
//vd($fullPath);
//vd($curModule .'/'.$curContr .'/' .$curAction);
$file_avatar = Yii::getAlias('@frontend') . '/web/upload/user/' . Yii::$app->user->id . '/avatar/avatar.jpg';
?>

<div id="left">
    <div class="media user-media bg-dark dker">
        <div class="user-media-toggleHover">
            <span class="fa fa-user"></span>
        </div>
        <div class="user-wrapper bg-dark">
            <a class="user-link" href="">

                <?php if (file_exists($file_avatar)) { ?>
                    <img class="media-object img-thumbnail user-img" alt="User Picture"
                         src="/upload/user/<?= Yii::$app->user->id ?>/avatar/avatar.jpg" width='100px'>
                <?php } else { ?>
                    <img class="media-object img-thumbnail user-img" alt="User Picture" src="/matis/img/user.gif">
                <?php } ?>
                <span class="label label-danger user-label">16</span>
            </a>

            <div class="media-body">

                <ul class="list-unstyled user-info">
                    <li><a href=""><?= Yii::$app->user->identity->username ?></a></li>
                    <li>Last Access :
                        <br>
                        <small>
                            <i class="fa fa-calendar"></i>&nbsp;16 Mar 16:32
                        </small>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- #menu -->
    <ul id="menu" class="dker">
        <li class="nav-header"></li>
        <li class="nav-divider"></li>


        <li class="<?php if ($path == 'goods/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/goods/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Товары<?= Goods::getQuantityOfGoodsByUserId() ? '(' .Goods::getQuantityOfGoodsByUserId() . '}' : ''; ?></span>
            </a>
        </li>
        <li class="<?php if ($path == 'brend/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/brend/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Бренды</span>
            </a>
        </li>
        <li class="<?php if ($path == 'goods_category/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/goods_category/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Категории товаров</span>
            </a>
        </li>


    </ul>
    <!-- /#menu -->
</div><!-- /#left -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('.modal').hide();$('.layout').hide()"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Очистка кеш</h4>
            </div>
            <div class="modal-body" style="text-align: center">
                <p> Вы действительно хотите очистить кеш?</p>
            </div>
            <div class="modal-footer">

                <a href="<?= Url::to('/cash/clear') ?>">
                    <button type="button" class="btn btn-danger">Очистить</button>
                </a>
                <button type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="$('.modal').hide();$('.layout').hide()">Отмена
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    //$('#myModal').modal();  
    //$('#myModal').on('shown.bs.modal', function () {
    //$('#myInput').focus()
    //})
</script>

<style>
    .modal {
        top: 330px;
        z-index: 1001;
        border-radius: 10px !important;
    }

    #myModal {
        color: #000;
    }

    .modal-header {
        background-color: rgb(107, 110, 144);
        color: #ffffff;
        padding-top: 36px;
    }

    .close {
        color: #ffffff;
    }

    .modal-footer {
        background-color: rgb(107, 110, 144);
        color: #ffffff;
    }

    .layout {
        position: absolute;
        background-color: #000;
        width: 100%;
        height: 100%;
        z-index: 1000;
        display: none;
        opacity: 0.5;
    }

    .modal-dialog {
        border-radius: 10px;
    }
    li{
        line-height: 1!important;
    }
</style>