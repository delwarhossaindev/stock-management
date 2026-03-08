<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $backups = collect(Storage::disk('local')->files('backups'))
            ->filter(fn($f) => str_ends_with($f, '.sql'))
            ->map(fn($f) => [
                'name' => basename($f),
                'path' => $f,
                'size' => number_format(Storage::disk('local')->size($f) / 1024, 1) . ' KB',
                'date' => date('d/m/Y H:i', Storage::disk('local')->lastModified($f)),
            ])
            ->sortByDesc('date')
            ->values();

        return view('backups.index', compact('backups'));
    }

    public function store()
    {
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port', 3306);

        $filename = 'backup_' . date('Y_m_d_His') . '.sql';
        $path = storage_path('app/backups/' . $filename);

        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $mysqldump = 'mysqldump';
        // Try common Windows paths
        foreach (['C:/wamp64/bin/mysql/mysql8.3.0/bin/mysqldump', 'C:/wamp64/bin/mysql/mysql8.0.31/bin/mysqldump', 'C:/xampp/mysql/bin/mysqldump'] as $tryPath) {
            if (file_exists($tryPath . '.exe') || file_exists($tryPath)) {
                $mysqldump = '"' . $tryPath . '"';
                break;
            }
        }

        $command = sprintf(
            '%s --host=%s --port=%s --user=%s --password=%s %s > "%s" 2>&1',
            $mysqldump,
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            $path
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($path) || filesize($path) === 0) {
            // Fallback: PHP-based backup
            $this->phpBackup($path);
        }

        if (file_exists($path) && filesize($path) > 0) {
            return redirect()->route('backups.index')->with('success', __('Backup created successfully.'));
        }

        return redirect()->route('backups.index')->with('error', __('Backup failed.'));
    }

    public function download($filename)
    {
        $path = 'backups/' . $filename;
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }
        return response()->download(storage_path('app/' . $path));
    }

    public function destroy($filename)
    {
        $path = 'backups/' . $filename;
        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
        }
        return redirect()->route('backups.index')->with('success', __('Backup deleted successfully.'));
    }

    private function phpBackup(string $path): void
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $key = 'Tables_in_' . $dbName;

        $sql = "-- Backup generated " . date('Y-m-d H:i:s') . "\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$key;
            $create = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $create[0]->{'Create Table'} . ";\n\n";

            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = collect((array) $row)->map(function ($v) {
                    return $v === null ? 'NULL' : "'" . addslashes($v) . "'";
                })->implode(', ');
                $sql .= "INSERT INTO `{$tableName}` VALUES ({$values});\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        file_put_contents($path, $sql);
    }
}
