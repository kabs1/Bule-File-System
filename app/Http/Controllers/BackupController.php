<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Backup\BackupDestination\BackupCollection;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;
use Spatie\Backup\Helpers\Format;
use Spatie\Backup\Config\Config;

class BackupController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    // public function index()
    // {
    //     $this->authorize('backup.view');

    //     $config = Config::fromArray(config('backup'));

    //     $backups = collect(BackupDestinationFactory::createFromArray($config))
    //         ->flatMap(function ($backupDestination) {
    //             return $backupDestination->backups();
    //         })->map(function ($backup) {
    //         return [
    //             'date' => $backup->date()->format('Y-m-d H:i:s'),
    //             'size' => Format::humanReadableSize($backup->sizeInBytes()),
    //             'path' => $backup->path(),
    //             'disk' => $backup->disk(),
    //         ];
    //     })->toArray();

    //     // The backups are already sorted newest first, so no need to reverse.
    //     return view('content.backups.index', compact('backups'));
    // }
    // In App\Http\Controllers\BackupController

public function index()
{
    $this->authorize('backup.view');

    $config = Config::fromArray(config('backup'));

    $backups = collect(BackupDestinationFactory::createFromArray($config))
        ->flatMap(function ($backupDestination) {
            // Get the string name of the disk from the destination object
            $diskName = $backupDestination->diskName(); // <-- Key change: use diskName()

            return $backupDestination->backups()->map(function ($backup) use ($diskName) {
                return [
                    'date' => $backup->date()->format('Y-m-d H:i:s'),
                    'size' => Format::humanReadableSize($backup->sizeInBytes()),
                    'path' => $backup->path(),
                    'disk' => $diskName, // <-- Use the string disk name
                ];
            });
        })->toArray();

    return view('content.backups.index', compact('backups'));
}

public function list(Request $request)
{
    $this->authorize('backup.view');
    $config = Config::fromArray(config('backup'));
    $backups = collect(BackupDestinationFactory::createFromArray($config))
        ->flatMap(function ($backupDestination) {
            $diskName = $backupDestination->diskName();
            return $backupDestination->backups()->map(function ($backup) use ($diskName) {
                return [
                    'date' => $backup->date()->format('Y-m-d H:i:s'),
                    'size' => Format::humanReadableSize($backup->sizeInBytes()),
                    'path' => $backup->path(),
                    'disk' => $diskName,
                    'actions' => ''
                ];
            });
        })->toArray();

    return response()->json(['data' => $backups]);
}

    public function create()
    {
        $this->authorize('backup.create');

        try {
            Artisan::call('backup:run');
            return back()->with('success', 'Backup created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    public function download($disk, $path)
    {
        $this->authorize('backup.download');

    $backupDestination = BackupDestinationFactory::createFromDiskName($disk);
    $backup = $backupDestination->backups()->first(fn ($backup) => $backup->path() === $path);

    if (!$backup) {
            abort(404, 'Backup not found.');
        }

        return response()->download($backup->path());
    }

    public function delete($disk, $path)
    {
       $this->authorize('backup.delete');

    $backupDestination = BackupDestinationFactory::createFromDiskName($disk);
    $backup = $backupDestination->backups()->first(fn ($backup) => $backup->path() === $path);
        if (!$backup) {
            abort(404, 'Backup not found.');
        }

        $backup->delete();

        return back()->with('success', 'Backup deleted successfully!');
    }
}
