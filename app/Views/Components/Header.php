<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=5, viewport-fit=cover, user-scalable=0">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="google" value="notranslate" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">

    <title>Polkryptex - <?php $this->title(); ?></title>
    <?php foreach ($this->styles as $style) : ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $style[0]; ?>" integrity="<?php echo $style[1]; ?>" crossorigin="anonymous" />
    <?php endforeach; ?>
</head>

<body class="<?php echo $this->getBodyClasses(); ?>">
<?php $this->getComponent('Cookie'); ?>
<section id="app">