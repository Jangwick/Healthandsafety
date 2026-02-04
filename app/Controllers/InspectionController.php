<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\BaseModel;
use App\Services\InspectionService;
use App\Middleware\AuthMiddleware;
use App\Database;

class InspectionController extends BaseController
{
    private InspectionService $service;
    private AuthMiddleware $auth;

    public function __construct()
    {
        $this->service = new InspectionService();
        $this->auth = new AuthMiddleware();
    }

    public function index(): void
    {
        $user = $this->auth->handle();
        $db = Database::getInstance();
        
        $inspections = $db->query("
            SELECT i.*, e.name as business_name, u.full_name as inspector_name 
            FROM inspections i 
            JOIN establishments e ON i.establishment_id = e.id 
            JOIN users u ON i.inspector_id = u.id 
            ORDER BY i.scheduled_date DESC
        ")->fetchAll();

        ob_start();
        $this->view('pages/inspections/list', ['inspections' => $inspections]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Inspections - LGU H&S',
            'pageHeading' => 'Inspection Management',
            'breadcrumb' => ['Inspections' => '/inspections'],
            'content' => $content
        ]);
    }

    public function create(): void
    {
        $user = $this->auth->handle();
        $this->auth->authorize($user, 5); // Inspector or above

        $db = Database::getInstance();
        $establishments = $db->query("SELECT id, name FROM establishments WHERE deleted_at IS NULL")->fetchAll();
        $templates = $db->query("SELECT id, category FROM checklist_templates")->fetchAll();

        ob_start();
        $this->view('pages/inspections/create', [
            'establishments' => $establishments,
            'templates' => $templates
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Schedule Inspection',
            'pageHeading' => 'New Inspection',
            'breadcrumb' => ['Inspections' => '/inspections', 'Create' => '#'],
            'content' => $content
        ]);
    }
}
