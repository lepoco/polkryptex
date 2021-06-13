
<!doctype html>
<html lang="<?php echo e($language); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=5, viewport-fit=cover, user-scalable=0">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<?php if($noTranslate): ?>
    <meta name="google" value="notranslate" />
<?php endif; ?>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <title>Polkryptex - <?php echo e($title); ?></title>
    <link rel="icon" href="<?php echo $baseUrl . 'media/favicon.svg'; ?>"/>
    <link rel="manifest" href="<?php echo $baseUrl . 'media/manifest.json'; ?>">
    <script type="importmap"><?php echo json_encode( $importmap , 15, 512) ?></script>

<?php $__currentLoopData = $styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo e($style['src']); ?>" integrity="<?php echo e($style['sri']); ?>" crossorigin="anonymous" />
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

    <script>const app = {title: '<?php echo e($title); ?>', props: <?php echo json_encode( $props , 15, 512) ?>, csrf: '<?php echo e($csrfToken); ?>', auth: <?php echo json_encode( $auth, JSON_PRETTY_PRINT, 512) ?>}</script>
<?php $__currentLoopData = $scripts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script type="<?php echo e($script['type']); ?>" src="<?php echo e($script['src']); ?>" integrity="<?php echo e($script['sri']); ?>" crossorigin="anonymous" defer></script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</head>
<body class="<?php echo e($bodyClasses); ?>">

<?php echo $__env->make('components.cookie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section id="app"><?php /**PATH C:\xampp\htdocs\polkryptex\app\common\views/components/header.blade.php ENDPATH**/ ?>