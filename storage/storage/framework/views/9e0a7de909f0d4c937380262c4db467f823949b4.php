

<?php $__env->startSection('title', '登録完了'); ?>

<?php $__env->startSection('content'); ?>
    <main class="center">
        <h1>登録完了</h1>
        <div>
            <p>登録情報は下記になります</p>
            <table class="register-table">
                <tr>
                    <td>メールアドレス</td>
                    <td><?php echo e($email); ?></td>
                </tr>
                <tr>
                    <td>名前</td>
                    <td><?php echo e($name); ?></td>
                </tr>
                <tr>
                    <td>郵便番号</td>
                    <td><?php echo e($postcode); ?></td>
                </tr>
                <tr>
                    <td>都道府県</td>
                    <td><?php echo e($prefecture); ?></td>
                </tr>
                <tr>
                    <td>市区町村</td>
                    <td><?php echo e($city); ?></td>
                </tr>
                <tr>
                    <td>住所</td>
                    <td><?php echo e($address); ?></td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td><?php echo e($tel); ?></td>
                </tr>
            </table>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\nakam\OneDrive\デスクトップ\projects\bentouya\resources\views/register_success.blade.php ENDPATH**/ ?>