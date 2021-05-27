<?php /* @include('components.cookie') */ ?>
<?php /* @include('components.navigation') */ ?>

<!doctype html>
<html lang="<?php echo e($language); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=5, viewport-fit=cover, user-scalable=0">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="google" value="notranslate" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <title>Polkryptex - <?php echo e($title); ?></title>
    <script type="importmap"><?php echo json_encode( $importmap , 15, 512) ?></script>
<?php $__currentLoopData = $styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo e($style['src']); ?>" integrity="<?php echo e($style['sri']); ?>" crossorigin="anonymous" />
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $scripts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script type="<?php echo e($script['type']); ?>" src="<?php echo e($script['src']); ?>" integrity="<?php echo e($script['sri']); ?>" crossorigin="anonymous" defer></script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</head>
    <body class="<?php echo e($body_classes); ?>">
        <section id="app" data-vue-component="<?php echo e($title); ?>" data-vue-props="<?php echo json_encode( $props , 15, 512) ?>" data-auth="<?php echo json_encode( $auth , 15, 512) ?>" data-csrf-token="<?php echo e($csrf_token); ?>"></section>
    </body>
</html><?php /**PATH E:\MAMP\htdocs\polkryptex\app\common\views/app.blade.php ENDPATH**/ ?>