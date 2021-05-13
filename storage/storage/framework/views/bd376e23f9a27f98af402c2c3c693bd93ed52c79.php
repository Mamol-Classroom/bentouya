

<?php $__env->startSection('title', '弁当登録完了'); ?>

<?php $__env->startSection('content'); ?>
    <main class="center">
        <h1>弁当登録完了</h1>
        <div>
            <table class="register-table">
                <tr>
                    <td>弁当名</td>
                    <td><?php echo e($bento_name); ?></td>
                </tr>
                <tr>
                    <td>価格</td>
                    <td><?php echo e($price); ?></td>
                </tr>
                <tr>
                    <td>弁当コード</td>
                    <td><?php echo e($bento_code); ?></td>
                </tr>
                <tr>
                    <td>説明</td>
                    <td><?php echo nl2br($description); ?></td>
                </tr>
                <tr>
                    <td>賞味期限</td>
                    <td><?php echo e($guarantee_period); ?></td>
                </tr>
                <tr>
                    <td>在庫数</td>
                    <td><?php echo e($stock); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="/bentos">商品管理へ</a>
                    </td>
                </tr>
            </table>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\nakam\OneDrive\デスクトップ\projects\bentouya\resources\views/bento/add-complete.blade.php ENDPATH**/ ?>