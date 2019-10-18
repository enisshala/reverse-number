<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.cancellation-requests', function ($trail) {
    $trail->push(__('strings.backend.dashboard.cancel'), route('admin.cancellation-requests'));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
