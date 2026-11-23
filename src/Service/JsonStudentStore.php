<?php
declare(strict_types=1);

namespace App\Service;

use RuntimeException;

final class JsonStudentStore
{
    private string $file;

    public function __construct(?string $file = null)
    {
        $this->file = $file ?? dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'students.json';
    }

    /** @return array<int, array<string, mixed>> */
    public function all(): array
    {
        $this->ensureFile();
        $json = file_get_contents($this->file);
        $rows = json_decode($json === false ? '[]' : $json, true);
        if (!is_array($rows)) {
            throw new RuntimeException('Student JSON storage contains invalid JSON.');
        }
        return array_values($rows);
    }

    public function find(int $id): ?array
    {
        foreach ($this->all() as $row) {
            if ((int)($row['id'] ?? 0) === $id) {
                return $row;
            }
        }
        return null;
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): array
    {
        return $this->mutate(function (array &$rows) use ($data): array {
            $nextId = 1;
            foreach ($rows as $row) {
                $nextId = max($nextId, (int)($row['id'] ?? 0) + 1);
            }
            $now = date(DATE_ATOM);
            $record = array_merge($data, ['id' => $nextId, 'created' => $now, 'modified' => $now]);
            $rows[] = $record;
            return $record;
        });
    }

    /** @param array<string, mixed> $data */
    public function update(int $id, array $data): ?array
    {
        return $this->mutate(function (array &$rows) use ($id, $data): ?array {
            foreach ($rows as &$row) {
                if ((int)($row['id'] ?? 0) === $id) {
                    $row = array_merge($row, $data, ['id' => $id, 'modified' => date(DATE_ATOM)]);
                    $updated = $row;
                    unset($row);
                    return $updated;
                }
            }
            unset($row);
            return null;
        });
    }

    public function delete(int $id): bool
    {
        return $this->mutate(function (array &$rows) use ($id): bool {
            $before = count($rows);
            $rows = array_values(array_filter($rows, static fn(array $row): bool => (int)($row['id'] ?? 0) !== $id));
            return count($rows) < $before;
        });
    }

    private function ensureFile(): void
    {
        $directory = dirname($this->file);
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException('Unable to create JSON storage directory.');
        }
        if (!file_exists($this->file)) {
            $seed = [
                ['id'=>1,'student_number'=>'2026-0001','first_name'=>'Alex','last_name'=>'Santos','email'=>'alex.santos@example.com','course'=>'BS Information Technology','year_level'=>'2nd Year','date_of_birth'=>'2005-04-18','gender'=>'Male','phone'=>'09171234567','address'=>'San Fernando, Pampanga','created'=>date(DATE_ATOM),'modified'=>date(DATE_ATOM)],
                ['id'=>2,'student_number'=>'2026-0002','first_name'=>'Mia','last_name'=>'Reyes','email'=>'mia.reyes@example.com','course'=>'BS Computer Science','year_level'=>'3rd Year','date_of_birth'=>'2004-09-02','gender'=>'Female','phone'=>'09179876543','address'=>'Angeles City, Pampanga','created'=>date(DATE_ATOM),'modified'=>date(DATE_ATOM)],
                ['id'=>3,'student_number'=>'2026-0003','first_name'=>'Jordan','last_name'=>'Garcia','email'=>'jordan.garcia@example.com','course'=>'BS Information Systems','year_level'=>'1st Year','date_of_birth'=>'2006-01-27','gender'=>'Prefer not to say','phone'=>'','address'=>'Mabalacat, Pampanga','created'=>date(DATE_ATOM),'modified'=>date(DATE_ATOM)],
            ];
            file_put_contents($this->file, json_encode($seed, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
        }
    }

    private function mutate(callable $callback): mixed
    {
        $this->ensureFile();
        $handle = fopen($this->file, 'c+');
        if ($handle === false || !flock($handle, LOCK_EX)) {
            throw new RuntimeException('Unable to lock JSON student storage.');
        }
        try {
            rewind($handle);
            $contents = stream_get_contents($handle);
            $rows = json_decode($contents === false || trim($contents) === '' ? '[]' : $contents, true);
            if (!is_array($rows)) {
                throw new RuntimeException('Student JSON storage contains invalid JSON.');
            }
            $result = $callback($rows);
            $encoded = json_encode(array_values($rows), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            if ($encoded === false) {
                throw new RuntimeException('Unable to encode student JSON storage.');
            }
            rewind($handle);
            ftruncate($handle, 0);
            fwrite($handle, $encoded);
            fflush($handle);
            return $result;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }
}
