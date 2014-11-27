<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="generator" content="ncuesta/pinocchio" />
        <title><?php echo $configuration->get('index_title'); ?></title>
        <?php if ($stylesheets = $configuration->get('css')): ?>
            <style>
                <?php foreach ($stylesheets as $file): ?>
                    <?php echo file_get_contents($file); ?>
                <?php endforeach; ?>
            </style>
        <?php endif; ?>
    </head>
    <body>
        <h1><?php echo $configuration->get('index_title'); ?></h1>
        <ul>
            <?php foreach ($sources as $pinocchio): ?>
            <li>
                <a href="<?php echo $pinocchio->getOutputFilename($configuration->get('source')) ?>">
                    <?php echo $pinocchio->getTitle(); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <footer>
            <p>&copy; 2013 - <a href="http://ncuesta.github.com/pinocchio">Pinocchio</a>.</p>
        </footer>
    </body>
</html>