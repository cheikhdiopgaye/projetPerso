<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerXeA9DPo\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerXeA9DPo/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerXeA9DPo.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerXeA9DPo\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerXeA9DPo\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'XeA9DPo',
    'container.build_id' => 'fd50933a',
    'container.build_time' => 1567981045,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerXeA9DPo');
