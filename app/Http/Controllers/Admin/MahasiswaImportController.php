<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            $credentialsFilename = $this->cacheCredentialsCsv($import->credentials);
        }

        return view('admin.mahasiswa.import', [
            'successCount' => $import->successCount,
            'skipped' => $import->skipped,
            'credentialsFilename' => $credentialsFilename,
        ]);
    }

    public function downloadCredentials(string $filename): StreamedResponse
    {
        $csv = Cache::pull('mahasiswa-import-credentials:'.$filename);

        abort_unless(is_string($csv), 404);

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'mahasiswa_credentials.csv', ['Content-Type' => 'text/csv']);
    }

    /**
     * @param  array<int, array{nama: string, email: string, nim: string, plain_password: string}>  $credentials
     */
    private function cacheCredentialsCsv(array $credentials): string
    {
        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['nama', 'email', 'nim', 'password']);

        foreach ($credentials as $credential) {
            fputcsv($handle, [
                $credential['nama'],
                $credential['email'],
                $credential['nim'],
                $credential['plain_password'],
            ]);
        }

        rewind($handle);
        $csv = (string) stream_get_contents($handle);
        fclose($handle);

        $token = Str::random(40);
        Cache::put('mahasiswa-import-credentials:'.$token, $csv, now()->addMinutes(10));

        return $token;
    }
}
