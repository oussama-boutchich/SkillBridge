<?php
/**
 * SkillBridge — ProfileController
 * GET  /api/profiles/student/{id}
 * PUT  /api/profiles/student
 * GET  /api/profiles/company/{id}
 * PUT  /api/profiles/company
 */
declare(strict_types=1);

class ProfileController
{
    private StudentProfileModel $studentModel;
    private CompanyProfileModel $companyModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/StudentProfileModel.php';
        require_once __DIR__ . '/../models/CompanyProfileModel.php';
        $this->studentModel = new StudentProfileModel();
        $this->companyModel = new CompanyProfileModel();
    }

    // GET /api/profiles/student/{id}
    public function showStudent(string $id): void
    {
        require_once __DIR__ . '/../models/CertificateModel.php';
        $userId = (int) $id;
        $profile = $this->studentModel->getByUserId($userId);
        if (!$profile) {
            Response::error('Student profile not found.', 404);
        }
        $certModel = new CertificateModel();
        $profile['certificates'] = $certModel->getByUserId($userId);
        Response::success($profile);
    }

    // PUT /api/profiles/student
    public function updateStudent(): void
    {
        $input  = $this->jsonInput();
        $userId = (int) $_SESSION['user_id'];

        $allowed = ['university','field_of_study','bio','skills','resume_url','linkedin_url','graduation_year'];
        $data = array_intersect_key($input, array_flip($allowed));

        $v = new Validator();
        if (!empty($data['resume_url']))   $v->url('resume_url',   $data['resume_url']);
        if (!empty($data['linkedin_url'])) $v->url('linkedin_url', $data['linkedin_url']);
        if (!$v->passes()) Response::error($v->getErrors(), 400);

        $this->studentModel->update($userId, $data);
        Response::success(['message' => 'Profile updated successfully.']);
    }

    // GET /api/profiles/company/{id}
    public function showCompany(string $id): void
    {
        $profile = $this->companyModel->getByUserId((int) $id);
        if (!$profile) Response::error('Company profile not found.', 404);
        Response::success($profile);
    }

    // PUT /api/profiles/company
    public function updateCompany(): void
    {
        $input  = $this->jsonInput();
        $userId = (int) $_SESSION['user_id'];

        $v = new Validator();
        $v->required('company_name', $input['company_name'] ?? '');
        if (!$v->passes()) Response::error($v->getErrors(), 400);

        $allowed = ['company_name','industry','description','website','location','company_size','founded_year'];
        $data = array_intersect_key($input, array_flip($allowed));

        $this->companyModel->update($userId, $data);
        Response::success(['message' => 'Company profile updated successfully.']);
    }

    private function jsonInput(): array
    {
        return json_decode(file_get_contents('php://input') ?: '{}', true) ?? [];
    }
}
