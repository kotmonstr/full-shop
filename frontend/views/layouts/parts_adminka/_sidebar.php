<?php

use yii\helpers\Url;

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

        <li class="<?php if ($path == 'blog/show') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/blog/show') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Cтатьи</span>
            </a>
        </li>

        <li class="<?php if ($path == 'user/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/user/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Пользователи</span>
            </a>
        </li>
        <li class="<?php if ($path == 'image/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/image/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Слайдер</span>
            </a>
        </li>
        <li class="<?php if ($path == 'video/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/video/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Youtube</span>
            </a>
        </li>

        <li class="<?php if ($path == 'video/preview') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/video/preview') ?>">
                <i class="fa"></i><span class="link-title">&nbsp; Видео</span>
            </a>
        </li>

        <li class="<?php if ($path == 'image/form-multy') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/image/form-multy') ?>">
                <i class="fa"></i><span class="link-title">&nbsp; Мульти загрузка фото</span>
            </a>
        </li>
        <li class="<?php if ($path == 'video_categoria/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/video_categoria/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Категории видео</span>
            </a>
        </li>
        <li class="<?php if ($path == 'author/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/author/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Авторы</span>
            </a>
        </li>
        <li class="<?php if ($path == 'email/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/email/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Email рассылка</span>
            </a>
        </li>
        <li class="<?php if ($path == 'comment/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/comment/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Коментарии</span>
            </a>
        </li>
        <li class="<?php if ($path == 'comment/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/book/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Книги</span>
            </a>
        </li>
        <li class="<?php if ($path == 'goods/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/goods/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Товары</span>
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
        <li class="<?php if ($path == 'banner/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/banner/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Баннеры</span>
            </a>
        </li>
        <li class="<?php if ($path == 'review/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/review/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Отзывы</span>
            </a>
        </li>
        <li class="<?php if ($path == 'order/index') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/order/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Заказы</span>
            </a>
        </li>

        <li class="<?php if ($fullPath == 'shop/reqvizit') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/shop/reqvizit/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Реквизиты</span>
            </a>
        </li>
        <li class="<?php if ($fullPath == 'shop/patch') {
            echo "active";
        } ?>">
            <a href="<?= Url::to('/patch/index') ?>">
                <i class="fa"></i><span class="link-title">&nbsp;Запустить патчь</span>
            </a>
        </li>
        <li class="<?php if ($path == 'cash/index') {
            echo "active";
        } ?>">
            <a href="javascript:void(0);" data-toggle="cash" data-target="#myModalcash"
               onclick="$('.cash').css('opacity', '1').show(),$('.layout').show()">
                <i class="fa"></i><span class="link-title">&nbsp;Очистить кеш</span>
            </a>
        </li>
    </ul>
    <!-- /#menu -->
</div><!-- /#left -->


<div class="modal fade cash" id="myModalcash" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('.modal').hide();$('.layout').hide()"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" >Очистка кеш</h4>
            </div>
            <div class="modal-body" style="text-align: center">
                <p style="color: #000000!important;"> Вы действительно хотите очистить кеш?</p>
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

<div class="modal fade system" id="system" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('.modal').hide();$('.layout').hide()"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Информация</h4>
            </div>
            <div class="modal-body" style="text-align: center">
                <p style="color: #000"></p>
            </div>
            <div class="modal-footer">


                <button type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="$('.modal').hide();$('.layout').hide()">Ок
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
        position: fixed;
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