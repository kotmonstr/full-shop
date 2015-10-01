">
    <thead>
    <tr class="cart_menu">
        <td class="image">Итого</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

    </tr>
    <?php
    $i = 1;
    $Total = 0;
    ?>
    <?php if ($model): ?>
        <?php foreach ($model as $good): ?>
            <tr>
                <td>
                    <?= $i++ ?>
                </td>
                <td>
                    <a href="/shop/detail?item=<?= $good->goods->id ?>"><img src="<?= '/upload/goods/' . $good->goods->image ?>" alt=""
                                                                             width="50px"></a>
                </td>
                <td>
                    <?= $good->goods->item ?>
                </td>
                <td>
                    <?= $good->quantity . ' ед.'; ?>
                </td>
                <td>
                    <?= '$' . $good->price ?>
                </td>
                <td>
                    <?= '$' . $good->quantity * $good->price ?>
                </td>
            </tr>
            <?php $Total = $Total + ($good->quantity * $good->price); ?>

        <?php endforeach ?>
    <?php endif ?>
    <tr>
        <hr>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Итого:</td>
        <td><?= '$' . $Total ?></td>
    </tr>
    </thead>
    <tbody>
    </tbody>
