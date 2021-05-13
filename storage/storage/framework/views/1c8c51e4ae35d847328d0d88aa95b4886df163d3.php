

<?php $__env->startSection('title', '新規登録'); ?>

<?php $__env->startSection('content'); ?>
<main class="center">
    <h1>新規登録</h1>
    <div>
        <form method="post" action="/register-user">
            <table class="register-table">
                <tr>
                    <td>メールアドレス</td>
                    <td>
                        <input type="text" name="email" value="<?php if($data != null): ?><?php echo e($data['email']); ?><?php endif; ?>" />
                        <?php if(isset($error_message) && $error_message['email'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['email']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td>
                        <input type="password" name="password" value="<?php echo e($data['password']); ?>" />
                        <?php if(isset($error_message) && $error_message['password'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['password']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>パスワード確認</td>
                    <td>
                        <input type="password" name="password_confirm" value="<?php echo e($data['password_confirm']); ?>" />
                        <?php if(isset($error_message) && $error_message['password_confirm'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['password_confirm']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>名前</td>
                    <td>
                        <input type="text" name="name" value="<?php echo e($data['name']); ?>" />
                        <?php if(isset($error_message) && $error_message['name'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['name']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>郵便番号</td>
                    <td>
                        <input type="text" name="postcode" value="<?php echo e($data['postcode']); ?>" />
                        <?php if(isset($error_message) && $error_message['postcode'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['postcode']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>都道府県</td>
                    <td>
                        <input type="text" name="prefecture" value="<?php echo e($data['prefecture']); ?>" />
                        <?php if(isset($error_message) && $error_message['prefecture'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['prefecture']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>市区町村</td>
                    <td>
                        <input type="text" name="city" value="<?php echo e($data['city']); ?>" />
                        <?php if(isset($error_message) && $error_message['city'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['city']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>住所</td>
                    <td>
                        <input type="text" name="address" value="<?php echo e($data['address']); ?>" />
                        <?php if(isset($error_message) && $error_message['address'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['address']); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td>
                        <input type="text" name="tel" value="<?php echo e($data['tel']); ?>" />
                        <?php if(isset($error_message) && $error_message['tel'] != null): ?>
                            <span class="error-message"><?php echo e($error_message['tel']); ?></span>
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

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\nakam\OneDrive\デスクトップ\projects\bentouya\resources\views/register.blade.php ENDPATH**/ ?>