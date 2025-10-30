<?php
require_once __DIR__ . '/db.php';

/**
 * Create a job and attach categories (transactional)
 */
function job_create(PDO $pdo, array $data, array $categoryIds = []): int {
    $sql = "INSERT INTO jobs
      (employer_id, title, slug, location, employment_type, salary_min, salary_max, salary_currency, description, responsibilities, requirements, benefits, status, is_remote, expires_at)
      VALUES (:employer_id, :title, :slug, :location, :employment_type, :salary_min, :salary_max, :salary_currency, :description, :responsibilities, :requirements, :benefits, :status, :is_remote, :expires_at)";
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':employer_id' => $data['employer_id'],
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':location' => $data['location'],
            ':employment_type' => $data['employment_type'] ?? 'full_time',
            ':salary_min' => $data['salary_min'] ?? null,
            ':salary_max' => $data['salary_max'] ?? null,
            ':salary_currency' => $data['salary_currency'] ?? 'USD',
            ':description' => $data['description'],
            ':responsibilities' => $data['responsibilities'] ?? null,
            ':requirements' => $data['requirements'] ?? null,
            ':benefits' => $data['benefits'] ?? null,
            ':status' => $data['status'] ?? 'draft',
            ':is_remote' => $data['is_remote'] ? 1 : 0,
            ':expires_at' => $data['expires_at'] ?? null
        ]);
        $jobId = (int)$pdo->lastInsertId();

        if (!empty($categoryIds)) {
            $stmt2 = $pdo->prepare("INSERT INTO job_categories (job_id, category_id) VALUES (:job_id, :category_id)");
            foreach ($categoryIds as $catId) {
                $stmt2->execute([':job_id' => $jobId, ':category_id' => $catId]);
            }
        }
        $pdo->commit();
        return $jobId;
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

/**
 * Update job (simplified). Should also handle categories similar to create.
 */
function job_get_by_employer(PDO $pdo, int $employerId): array {
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE employer_id = :eid");
    $stmt->execute([':eid' => $employerId]);
    return $stmt->fetchAll();
}
