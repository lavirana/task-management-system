<?php

namespace App\Contexts;

class SessionContext {
    protected $activeWorkspaceId;

    public function setActiveWorkspaceId($workspaceId) {
        $this->activeWorkspaceId = $workspaceId;
    }

    public function getActiveWorkspaceId() {
        return $this->activeWorkspaceId;
    }
}

    