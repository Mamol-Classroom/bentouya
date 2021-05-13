

<?php $__env->startSection('title', '弁当修正'); ?>

<?php $__env->startSection('content'); ?>
    <main class="center">
        <h1>弁当修正</h1>
        <div>
            <form method="post" action="/bento/update?bento_id=<?php echo e($bento_id); ?>">
                <table class="register-table">
                    <tr>
                        <td>弁当名</td>
                        <td>
                            <input type="text" name="bento_name" value="<?php echo e($data['bento_name']); ?>" />
                            <?php if($error_message != null && $error_message['bento_name'] != null): ?>
                                <span class="error-message"><?php echo e($error_message['bento_name']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>価格</td>
                        <td>
                            <input type="number" name="price" value="<?php echo e($data['price']); ?>" />
                            <?php if(isset($error_message) && $error_message['price'] != null): ?>
                                <span class="error-message"><?php echo e($error_message['price']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>説明</td>
                        <td>
                            <textarea name="description" style="width: 500px; height: 200px;"><?php echo e($data['description']); ?></textarea>
                            <?php if(isset($error_message) && $error_message['description'] != null): ?>
                                <span class="error-message"><?php echo e($error_message['description']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>賞味期限</td>
                        <td>
                            <input type="date" name="guarantee_period" value="<?php echo e($data['guarantee_period']); ?>" />
                            <?php if(isset($error_message) && $error_message['guarantee_period'] != null): ?>
                                <span class="error-message"><?php echo e($error_message['guarantee_period']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>在庫数</td>
                        <td>
                            <input type="number" name="stock" value="<?php echo e($data['stock']); ?>" min="0" />
                            <?php if(isset($error_message) && $error_message['stock'] != null): ?>
                                <span class="error-message"><?php echo e($error_message['stock']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit">確認</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\nakam\OneDrive\デスクトップ\projects\bentouya\resources\views/bento/update.blade.php ENDPATH**/ ?>