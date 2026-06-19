<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MahasiswaImportController extends Controller
{
    public function create(): View
    {
        return view('admin.mahasiswa.import');
    }

    public function store(Request $request): View
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xlsx', 'max:5120'],
        ]);

        $import = new MahasiswaImport();

        Excel::import($import, $validated['file']);

        $credentialsFilename = null;

        if ($import->credentials !== []) {
            $credentialsFilename = $this->writeCredentialsCsv($import->credentials);
        }

        return view('admin.mahasiswa.import', [
            'successCount' => $import->successCount,
            'skipped' => $import->skipped,
            'credentialsFilename' => $credentialsFilename,
        ]);
    }

    public function downloadCredentials(string $filename): BinaryFileResponse
    {
        $filename = basename($filename);
        $path = storage_path('app/temp/'.$filename);

        abort_unless(File::exists($path), 404);

        return response()
            ->download($path, 'mahasiswa_credentials.csv', ['Content-Type' => 'text/csv'])
            ->deleteFileAfterSend();
    }

    /**
     * @param  array<int, array{nama: string, email: string, nim: string, plain_password: string}>  $credentials
     */
    private function writeCredentialsCsv(array $credentials): string
    {
        $directory = storage_path('app/temp');
        File::ensureDirectoryExists($directory);

        $filename = 'mahasiswa_credentials_'.now()->format('YmdHis').'_'.Str::random(8).'.csv';
        $path = $directory.'/'.$filename;

        $handle = fopen($path, 'w');
        fputcsv($handle, ['nama', 'email', 'nim', 'password']);

        foreach ($credentials as $credential) {
            fputcsv($handle, [
                $credential['nama'],
                $credential['email'],
                $credential['nim'],
                $credential['plain_password'],
            ]);
        }

        fclose($handle);

        return $filename;
    }
}
