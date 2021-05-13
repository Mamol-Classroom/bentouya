

<?php $__env->startSection('title', 'トップページ'); ?>

<?php $__env->startSection('content'); ?>
    <header>
        <div class="logo"><img src="/img/logo.jpg" width="100px" height="auto"></div>
        <div class="profile">
            <p>ようこそ、<?php echo e($name); ?> 様</p>

            <a href="/logout">ログアウト</a>
        </div>
    </header>

    <main>
        <h1 class="center">商品一覧</h1>
        <div class="bento-container">
            <?php $__currentLoopData = $bentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bento">
                    <p><?php echo e($bento->bento_name); ?></p>
                    <p>￥ <?php echo e(number_format($bento->price)); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\nakam\bentouya\resources\views/top.blade.php ENDPATH**/ ?>