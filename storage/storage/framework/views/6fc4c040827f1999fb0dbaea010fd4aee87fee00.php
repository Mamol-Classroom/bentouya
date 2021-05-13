

<?php $__env->startSection('title', '弁当管理'); ?>

<?php $__env->startSection('content'); ?>
    <main id="main">
        <ul id="main-nav">
            <li><a href="/bento/add">商品追加</a></li>
        </ul>
        <div class="subview">
            <h1 class="center">弁当管理</h1>
            <div class="bento-container">
                <?php $__currentLoopData = $bentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bento">
                        <a href="/bento/update?bento_id=<?php echo e($bento->id); ?>">
                            <p><?php echo e($bento->bento_name); ?></p>
                            <p>￥ <?php echo e(number_format($bento->price)); ?></p>
                        </a>
                        <form method="post" action="/bento/delete">
                            <input type="hidden" name="bento_id" value="<?php echo e($bento->id); ?>">
                            <button type="submit">販売終了</button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\nakam\OneDrive\デスクトップ\projects\bentouya\resources\views/bento/index.blade.php ENDPATH**/ ?>