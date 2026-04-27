<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class BackupController extends Controller
{
    protected $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    /**
     * List all available backups
     */
    public function index()
    {
        $backups = collect(File::files($this->backupPath))
            ->filter(fn($file) => $file->getExtension() === 'sql')
            ->map(fn($file) => [
                'name' => $file->getFilename(),
                'size' => $file->getSize(),
                'size_formatted' => $this->formatBytes($file->getSize()),
                'date' => date('d M, Y • h:i A', $file->getMTime()),
                'timestamp' => $file->getMTime(),
            ])
            ->sortByDesc('timestamp')
            ->values();

        return response()->json(['backups' => $backups]);
    }

    /**
     * Create a new database backup (Export)
     */
    public function backup()
    {
        try {
            $database = config('database.connections.mysql.database');
            $filename = 'backup_' . date('Y-m-d_His') . '.sql';
            $filepath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

            $sql = "-- Suhaim Soft Lab Database Backup\n";
            $sql .= "-- Generated: " . now()->format('Y-m-d H:i:s') . "\n";
            $sql .= "-- Database: {$database}\n";
            $sql .= "-- ================================================\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
            $sql .= "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n";

            // Get all tables
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . $database;

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;

                // Skip migration and cache tables for cleaner backup
                if (in_array($tableName, ['migrations', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs'])) {
                    continue;
                }

                // Get CREATE TABLE statement
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $sql .= "-- Table: {$tableName}\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

                // Get table data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $columns = array_keys((array)$rows->first());
                    $columnList = implode('`, `', $columns);

                    foreach ($rows->chunk(100) as $chunk) {
                        $sql .= "INSERT INTO `{$tableName}` (`{$columnList}`) VALUES\n";
                        $values = [];
                        foreach ($chunk as $row) {
                            $rowValues = [];
                            foreach ((array)$row as $value) {
                                if (is_null($value)) {
                                    $rowValues[] = 'NULL';
                                } else {
                                    $rowValues[] = "'" . addslashes($value) . "'";
                                }
                            }
                            $values[] = '(' . implode(', ', $rowValues) . ')';
                        }
                        $sql .= implode(",\n", $values) . ";\n\n";
                    }
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            File::put($filepath, $sql);

            $size = $this->formatBytes(filesize($filepath));

            return response()->json([
                'success' => true,
                'message' => "Backup created successfully ({$size})",
                'filename' => $filename,
                'size' => $size,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restore database from a backup file (Import)
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|string',
        ]);

        $filename = $request->input('backup_file');
        $filepath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($filepath)) {
            return response()->json([
                'success' => false,
                'message' => 'Backup file not found.',
            ], 404);
        }

        try {
            $sql = File::get($filepath);

            DB::unprepared($sql);

            return response()->json([
                'success' => true,
                'message' => "Database restored successfully from {$filename}",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Restore failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Import/restore from an uploaded SQL file
     */
    public function import(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|max:51200', // Max 50MB
        ]);

        try {
            $file = $request->file('sql_file');
            $sql = file_get_contents($file->getRealPath());

            // Save a copy to backups
            $filename = 'imported_' . date('Y-m-d_His') . '_' . $file->getClientOriginalName();
            File::put($this->backupPath . DIRECTORY_SEPARATOR . $filename, $sql);

            DB::unprepared($sql);

            return response()->json([
                'success' => true,
                'message' => "Database imported successfully from {$file->getClientOriginalName()}",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download a backup file
     */
    public function download($filename)
    {
        $filepath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($filepath)) {
            return back()->with('error', 'Backup file not found.');
        }

        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Delete a backup file
     */
    public function delete($filename)
    {
        $filepath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($filepath)) {
            return response()->json([
                'success' => false,
                'message' => 'Backup file not found.',
            ], 404);
        }

        File::delete($filepath);

        return response()->json([
            'success' => true,
            'message' => "Backup {$filename} deleted successfully.",
        ]);
    }

    /**
     * Get backup statistics for dashboard
     */
    public function stats()
    {
        $backups = collect(File::files($this->backupPath))
            ->filter(fn($file) => $file->getExtension() === 'sql');

        $totalSize = $backups->sum(fn($file) => $file->getSize());
        $latestBackup = $backups->sortByDesc(fn($file) => $file->getMTime())->first();

        // Get DB size
        $database = config('database.connections.mysql.database');
        $dbSize = DB::select("SELECT SUM(data_length + index_length) as size FROM information_schema.tables WHERE table_schema = ?", [$database]);
        $dbSizeBytes = (!empty($dbSize) && isset($dbSize[0]->size)) ? $dbSize[0]->size : 0;

        // Get storage size
        $storagePath = storage_path('app');
        $storageSize = 0;
        if (File::exists($storagePath)) {
            foreach (File::allFiles($storagePath) as $file) {
                $storageSize += $file->getSize();
            }
        }

        return response()->json([
            'total_backups' => $backups->count(),
            'total_size' => $this->formatBytes($totalSize),
            'db_size' => $this->formatBytes($dbSizeBytes),
            'storage_size' => $this->formatBytes($storageSize),
            'last_backup' => $latestBackup ? date('d M, Y • h:i A', $latestBackup->getMTime()) : 'Never',
            'last_backup_ago' => $latestBackup ? Carbon::createFromTimestamp($latestBackup->getMTime())->diffForHumans() : 'No backups yet',
        ]);
    }

    /**
     * Export specific tables as CSV
     */
    public function exportCsv(Request $request)
    {
        $table = $request->input('table', 'patients');
        $allowedTables = ['patients', 'bookings', 'reports', 'report_items', 'payments', 'test_types', 'test_parameters', 'test_categories', 'equipment', 'tasks', 'users', 'labs'];

        if (!in_array($table, $allowedTables)) {
            return response()->json(['success' => false, 'message' => 'Invalid table name.'], 400);
        }

        $rows = DB::table($table)->get();
        if ($rows->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No data found in table.'], 404);
        }

        $filename = $table . '_export_' . date('Y-m-d_His') . '.csv';
        $headers = array_keys((array)$rows->first());

        $callback = function () use ($rows, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            foreach ($rows as $row) {
                fputcsv($file, (array)$row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
    }
}
