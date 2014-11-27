<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="generator" content="ncuesta/pinocchio" />
        <title><?php echo $pinocchio->getTitle(); ?></title>
        <?php if ($stylesheets = $configuration->get('css')): ?>
            <style>
                <?php foreach ($stylesheets as $file): ?>
                    <?php echo file_get_contents($file); ?>
                <?php endforeach; ?>
            </style>
        <?php endif; ?>
    </head>
    <body>
        <div id="container">
            <div id="background"></div>

            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="docs">
                            <h1><?php echo $pinocchio->getTitle(); ?></h1>
                        </th>
                        <th class="code"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pinocchio->getCodeBlocks() as $i => $codeBlock): ?>
                        <tr id="section-<?php echo $i; ?>">
                            <td class="docs">
                                <div class="pilwrap">
                                    <a class="pilcrow" href="#section-<?php echo $i; ?>">&#182;</a>
                                </div>
                                <?php echo $pinocchio->getDocBlock($i); ?>
                            </td>
                            <td class="code">
                                <?php echo $codeBlock; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
