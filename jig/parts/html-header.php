<!doctype html>
<html lang="en">
<head>
    <!-- html-header -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo (@$headTitle != '') ? $headTitle : 'Dance a Jig!'; ?></title>
    <?php if (@$headDescription != '') { ?><meta name="description" content="<?php echo $headDescription; ?>"><?php } ?>

    <link rel="icon" type="image/png" href="/assets/images/icon.png">
    <link rel="apple-touch-icon" href="/assets/images/icon.png">

    <link rel="stylesheet" href="/assets/styles/vendor.css">
    <link rel="stylesheet" href="/assets/styles/site.css">

    <?php if (@$headContent != '') { ?>
        <!-- headContent -->
        <?php echo $headContent; ?>
    <?php } ?>
</head>
<body<?php echo (@$bodyAttributes != '') ? ' ' . $bodyAttributes : ''; ?>>
