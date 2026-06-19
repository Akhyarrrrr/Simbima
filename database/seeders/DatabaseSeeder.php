<?php

namespace Database\Seeders;

use App\Models\BidangMinat;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\DosenSlot;
use App\Models\Mahasiswa;
use App\Models\PengajuanBimbingan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $bidangMinats = collect([
            'Rekayasa Perangkat Lunak',
            'Data Mining',
            'Sistem Informasi Geografis',
            'Jaringan',
        ])->mapWithKeys(function (string $nama) {
            return [$nama => BidangMinat::firstOrCreate(['nama' => $nama])];
        });

        User::updateOrCreate(
            ['email' => 'admin@simbima.test'],
            [
                'name' => 'Admin Simbima',
                'password' => 'password',
                'role' => 'admin',
            ],
        );

        $dosens = collect($this->dosenData())->mapWithKeys(function (array $data) use ($bidangMinats) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                    'role' => 'dosen',
                ],
            );

            $dosen = Dosen::updateOrCreate(
                ['nip' => $data['nip']],
                [
                    'user_id' => $user->id,
                    'bidang_minat_id' => $bidangMinats[$data['bidang_minat']]->id,
                ],
            );

            DosenSlot::updateOrCreate(
                [
                    'dosen_id' => $dosen->id,
                    'angkatan' => 2021,
                ],
                ['max_slot' => 10],
            );

            return [$data['key'] => $dosen];
        });

        $mahasiswas = collect($this->mahasiswaData())->mapWithKeys(function (array $data) {
            $user = User::updateOrCreate(
                ['email' => $data['nim'].'@simbima.test'],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                    'role' => 'mahasiswa',
                ],
            );

            $mahasiswa = Mahasiswa::updateOrCreate(
                ['nim' => $data['nim']],
                [
                    'user_id' => $user->id,
                    'angkatan' => 2021,
                    'bidang_minat_id' => null,
                ],
            );

            return [$data['nim'] => $mahasiswa];
        });

        $this->seedDemoWorkflow($mahasiswas, $dosens, $bidangMinats);
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function dosenData(): array
    {
        return [
            ['key' => 'zahnur', 'name' => 'Dr. Zahnur Nurdin', 'email' => 'zahnur@usk.ac.id', 'nip' => '196905291994031002', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
            ['key' => 'taufik', 'name' => 'Prof. Dr. Taufik Fuadi Abidin', 'email' => 'taufik.abidin@usk.ac.id', 'nip' => '197010081994031002', 'bidang_minat' => 'Data Mining'],
            ['key' => 'muzailin', 'name' => 'Dr. Muzailin Affan', 'email' => 'muzailin@usk.ac.id', 'nip' => '197010191995121001', 'bidang_minat' => 'Sistem Informasi Geografis'],
            ['key' => 'nizamuddin', 'name' => 'Dr. Nizamuddin', 'email' => 'niz4muddin@usk.ac.id', 'nip' => '197108241996031001', 'bidang_minat' => 'Sistem Informasi Geografis'],
            ['key' => 'viska', 'name' => 'Viska Mutiawani', 'email' => 'viska.mw@usk.ac.id', 'nip' => '198008312009122003', 'bidang_minat' => 'Data Mining'],
            ['key' => 'irvanizam', 'name' => 'Irvanizam Zamanhuri', 'email' => 'irvanizam.zamanhuri@usk.ac.id', 'nip' => '198103152003121003', 'bidang_minat' => 'Data Mining'],
            ['key' => 'razief', 'name' => 'Razief Perucha Fauzie Afidh', 'email' => 'razief@usk.ac.id', 'nip' => '198408062012121002', 'bidang_minat' => 'Jaringan'],
            ['key' => 'nazaruddin', 'name' => 'Nazaruddin', 'email' => 'anzaro@usk.ac.id', 'nip' => '197202061997021001', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
            ['key' => 'arie', 'name' => 'Arie Budiansyah', 'email' => 'arie.b@usk.ac.id', 'nip' => '197808152010121002', 'bidang_minat' => 'Jaringan'],
            ['key' => 'kurnia', 'name' => 'Kurnia Saputra', 'email' => 'kurnia.saputra@usk.ac.id', 'nip' => '198003262014041001', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
            ['key' => 'amalia', 'name' => 'Amalia Mabrina Masbar Rus', 'email' => 'amaliammr@usk.ac.id', 'nip' => '198905052015042002', 'bidang_minat' => 'Data Mining'],
            ['key' => 'dalila', 'name' => 'Dalila Husna Yunardi', 'email' => 'dalila@usk.ac.id', 'nip' => '199006172015042001', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
            ['key' => 'subianto', 'name' => 'Dr. Muhammad Subianto', 'email' => 'subianto@usk.ac.id', 'nip' => '196812111994031005', 'bidang_minat' => 'Data Mining'],
            ['key' => 'rasudin', 'name' => 'Rasudin Abubakar', 'email' => 'rasudin@usk.ac.id', 'nip' => '197410011999031001', 'bidang_minat' => 'Jaringan'],
            ['key' => 'juwita', 'name' => 'Juwita Juwita', 'email' => 'juwita@usk.ac.id', 'nip' => '198104182008122001', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
            ['key' => 'muslim', 'name' => 'Muslim Amiren', 'email' => 'muslim.amiren@usk.ac.id', 'nip' => '197311181999031001', 'bidang_minat' => 'Data Mining'],
            ['key' => 'mahyus', 'name' => 'Mahyus Ihsan', 'email' => 'mahyus@usk.ac.id', 'nip' => '197010051998021001', 'bidang_minat' => 'Jaringan'],
            ['key' => 'kikye', 'name' => 'Kikye Martiwi Sukiakhy', 'email' => 'kikye.martiwi.sukiakhy@usk.ac.id', 'nip' => '198605202019032009', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
            ['key' => 'kahlil', 'name' => 'Dr. Kahlil Muchtar', 'email' => 'kahlil@usk.ac.id', 'nip' => '198512022019031006', 'bidang_minat' => 'Rekayasa Perangkat Lunak'],
        ];
    }

    /**
     * @return array<int, array{name: string, nim: string}>
     */
    private function mahasiswaData(): array
    {
        return [
            ['nim' => '2108107010001', 'name' => 'Raihan Shabirah'],
            ['nim' => '2108107010002', 'name' => 'Aditya Rizki Ramadhan'],
            ['nim' => '2108107010003', 'name' => 'Nitiya Rihadatul Aisy'],
            ['nim' => '2108107010004', 'name' => 'Putri Ulfayani'],
            ['nim' => '2108107010005', 'name' => 'Muhammad Ilhaam Ghiffari'],
            ['nim' => '2108107010006', 'name' => 'Sofia'],
            ['nim' => '2108107010007', 'name' => 'T. Malik Kamal'],
            ['nim' => '2108107010008', 'name' => 'Devi Anggraini'],
            ['nim' => '2108107010009', 'name' => 'Marlina'],
            ['nim' => '2108107010010', 'name' => 'Nabilah Qurratul Annisa'],
            ['nim' => '2108107010011', 'name' => 'Khairil Ilmi'],
            ['nim' => '2108107010012', 'name' => 'Nuzulurrahmah'],
            ['nim' => '2108107010013', 'name' => 'Furqan Ramadhan'],
            ['nim' => '2108107010014', 'name' => 'M Zaki Zamani'],
            ['nim' => '2108107010015', 'name' => 'Siti Nurrahmasita'],
            ['nim' => '2108107010016', 'name' => 'Khairul Auni'],
            ['nim' => '2108107010017', 'name' => 'Fachri Rozan'],
            ['nim' => '2108107010018', 'name' => 'Dhaifina Alifa Putri'],
            ['nim' => '2108107010019', 'name' => 'Nadia Muqarramah'],
            ['nim' => '2108107010020', 'name' => 'Al Hilal Habib'],
            ['nim' => '2108107010021', 'name' => 'Margfirah'],
            ['nim' => '2108107010022', 'name' => 'Muhammad Al-Hadziq Tarmizi'],
            ['nim' => '2108107010023', 'name' => 'Ardiansyah'],
            ['nim' => '2108107010024', 'name' => 'Ulan Sawalia'],
            ['nim' => '2108107010025', 'name' => 'Nabila Aprillia'],
            ['nim' => '2108107010026', 'name' => 'Wilda Fahera'],
            ['nim' => '2108107010027', 'name' => 'Ivan Chiari'],
            ['nim' => '2108107010028', 'name' => 'Abdul Helmi'],
            ['nim' => '2108107010029', 'name' => 'Fanul Nastia'],
            ['nim' => '2108107010030', 'name' => 'Tyara Raynasari'],
            ['nim' => '2108107010031', 'name' => 'Diky Wahyudi'],
            ['nim' => '2108107010032', 'name' => 'Sultan Shalahuddin'],
            ['nim' => '2108107010033', 'name' => 'Aulia Muzhaffar'],
            ['nim' => '2108107010034', 'name' => 'Niswah Nasyithah'],
            ['nim' => '2108107010035', 'name' => 'Ichwanul Fata'],
            ['nim' => '2108107010036', 'name' => 'Tasya Nadila'],
            ['nim' => '2108107010037', 'name' => 'Arrijalul Khairi'],
            ['nim' => '2108107010038', 'name' => 'Ayu Aulia'],
            ['nim' => '2108107010039', 'name' => 'Ridho Ferdiansa'],
            ['nim' => '2108107010040', 'name' => 'Muhammad Arief Hidayah'],
            ['nim' => '2108107010041', 'name' => 'Riyadhusshadiqin'],
            ['nim' => '2108107010042', 'name' => 'Fatiya Quzza'],
            ['nim' => '2108107010043', 'name' => 'Muhammad Nizar Asykary'],
            ['nim' => '2108107010044', 'name' => 'Muhammad Akbarul Ihsan'],
            ['nim' => '2108107010045', 'name' => 'Muhammad Hafidz Zuliesky'],
            ['nim' => '2108107010046', 'name' => 'Ardian'],
            ['nim' => '2108107010047', 'name' => 'M. Alfan Septian Nufi'],
            ['nim' => '2108107010048', 'name' => 'Elsa Mardhatillah Hariska'],
            ['nim' => '2108107010049', 'name' => 'Dzulkiram Hilmi'],
            ['nim' => '2108107010050', 'name' => 'Muhammad Farhan'],
            ['nim' => '2108107010051', 'name' => 'Muhammad Almer Zuhdi Rangkuti'],
            ['nim' => '2108107010052', 'name' => 'Muhammad Kemal Fasya'],
            ['nim' => '2108107010053', 'name' => 'Furqan Al Ghifari Zulva'],
            ['nim' => '2108107010054', 'name' => 'Kelsy Amirah'],
            ['nim' => '2108107010055', 'name' => 'Yahdina Ahsya'],
            ['nim' => '2108107010056', 'name' => 'Raihan Fahlevi'],
            ['nim' => '2108107010057', 'name' => 'Rama Dhaniansyah'],
            ['nim' => '2108107010058', 'name' => 'Teuku Beuraja Laksamana'],
            ['nim' => '2108107010059', 'name' => 'Fajry Ariansyah'],
            ['nim' => '2108107010060', 'name' => 'Muhammad Rayyan Azzuhri'],
            ['nim' => '2108107010061', 'name' => 'Fagih Akram'],
            ['nim' => '2108107010062', 'name' => 'Putri Sakinatul Maulida'],
            ['nim' => '2108107010063', 'name' => 'Fatiya Humaira Yunaz'],
            ['nim' => '2108107010064', 'name' => 'T. Rifal Aulia'],
            ['nim' => '2108107010065', 'name' => 'T. Indris Andina'],
            ['nim' => '2108107010066', 'name' => 'Rendika Rahmaturrizki'],
            ['nim' => '2108107010067', 'name' => 'Najla Raihana Kamila'],
            ['nim' => '2108107010068', 'name' => 'Laila Asrin'],
            ['nim' => '2108107010069', 'name' => 'Askar Aziz'],
            ['nim' => '2108107010070', 'name' => 'Leni Agustina'],
            ['nim' => '2108107010071', 'name' => 'Rahmatul Idami'],
            ['nim' => '2108107010072', 'name' => 'Ahmad Faqih Al Ghiffary'],
            ['nim' => '2108107010073', 'name' => 'Rifa Faruqi'],
            ['nim' => '2108107010074', 'name' => 'Azran'],
            ['nim' => '2108107010075', 'name' => 'Muhammad Firdaus'],
            ['nim' => '2108107010076', 'name' => 'Rachmat Fajar'],
            ['nim' => '2108107010077', 'name' => 'Rahmat Azrima'],
            ['nim' => '2108107010078', 'name' => 'Alifan Naufally Atha'],
            ['nim' => '2108107010079', 'name' => 'Riyan Farhan Ramadhan'],
            ['nim' => '2108107010080', 'name' => 'Muhammad Ghufran'],
            ['nim' => '2108107010081', 'name' => 'Muhammad Danish Rabbani'],
            ['nim' => '2108107010082', 'name' => 'Sharahiya'],
            ['nim' => '2108107010083', 'name' => 'Faiza Sabila'],
            ['nim' => '2108107010084', 'name' => 'Hadija Humaira'],
            ['nim' => '2108107010085', 'name' => 'Rizka Nawalul Azka'],
            ['nim' => '2108107010086', 'name' => 'Fadhel Mohammad Dalimunthe'],
            ['nim' => '2108107010087', 'name' => 'Miftah Nadya'],
            ['nim' => '2108107010088', 'name' => 'Annisa Lathifa'],
            ['nim' => '2108107010089', 'name' => 'Habil Nasution'],
            ['nim' => '2108107010090', 'name' => 'Ar-Rayyan Ramadhani'],
            ['nim' => '2108107010091', 'name' => 'Iwansur Sidik'],
            ['nim' => '2108107010092', 'name' => 'Adrean Badar'],
            ['nim' => '2108107010093', 'name' => 'Nura Faniqa'],
            ['nim' => '2108107010094', 'name' => 'Ahmad Naziel Firdaus'],
            ['nim' => '2108107010095', 'name' => 'Akhyar'],
            ['nim' => '2108107010096', 'name' => 'Muhammad Ichsan'],
            ['nim' => '2108107010097', 'name' => 'Afifah Nibras'],
            ['nim' => '2108107010098', 'name' => 'Muatta Muhariq'],
            ['nim' => '2108107010099', 'name' => 'Ryan Fahreza Putra'],
            ['nim' => '2108107010100', 'name' => 'Muhammad Raihan Adnan Taufiqurrahman'],
        ];
    }

    private function seedDemoWorkflow($mahasiswas, $dosens, $bidangMinats): void
    {
        $this->assignInterest($mahasiswas['2108107010001'], $bidangMinats['Rekayasa Perangkat Lunak']->id);
        $this->assignInterest($mahasiswas['2108107010002'], $bidangMinats['Data Mining']->id);
        $this->assignInterest($mahasiswas['2108107010003'], $bidangMinats['Sistem Informasi Geografis']->id);
        $this->assignInterest($mahasiswas['2108107010004'], $bidangMinats['Jaringan']->id);
        $this->assignInterest($mahasiswas['2108107010005'], $bidangMinats['Rekayasa Perangkat Lunak']->id);
        $this->assignInterest($mahasiswas['2108107010006'], $bidangMinats['Data Mining']->id);
        $this->assignInterest($mahasiswas['2108107010007'], $bidangMinats['Sistem Informasi Geografis']->id);
        $this->assignInterest($mahasiswas['2108107010008'], $bidangMinats['Jaringan']->id);

        PengajuanBimbingan::updateOrCreate(
            [
                'mahasiswa_id' => $mahasiswas['2108107010001']->id,
                'dosen_id' => $dosens['kurnia']->id,
            ],
            ['status' => 'pending', 'catatan_penolakan' => null],
        );

        PengajuanBimbingan::updateOrCreate(
            [
                'mahasiswa_id' => $mahasiswas['2108107010002']->id,
                'dosen_id' => $dosens['viska']->id,
            ],
            ['status' => 'ditolak', 'catatan_penolakan' => 'Topik belum sesuai dengan rumpun riset yang tersedia semester ini.'],
        );

        $accepted = PengajuanBimbingan::updateOrCreate(
            [
                'mahasiswa_id' => $mahasiswas['2108107010005']->id,
                'dosen_id' => $dosens['dalila']->id,
            ],
            ['status' => 'diterima', 'catatan_penolakan' => null],
        );

        Bimbingan::updateOrCreate(
            ['mahasiswa_id' => $accepted->mahasiswa_id],
            [
                'dospem1_id' => $accepted->dosen_id,
                'dospem2_id' => $dosens['kahlil']->id,
                'judul_ta' => 'Rancang Bangun Sistem Monitoring Bimbingan Tugas Akhir',
                'status' => 'aktif',
            ],
        );

        $finished = PengajuanBimbingan::updateOrCreate(
            [
                'mahasiswa_id' => $mahasiswas['2108107010006']->id,
                'dosen_id' => $dosens['taufik']->id,
            ],
            ['status' => 'diterima', 'catatan_penolakan' => null],
        );

        Bimbingan::updateOrCreate(
            ['mahasiswa_id' => $finished->mahasiswa_id],
            [
                'dospem1_id' => $finished->dosen_id,
                'dospem2_id' => $dosens['subianto']->id,
                'judul_ta' => 'Klasifikasi Topik Tugas Akhir Menggunakan Pembelajaran Mesin',
                'status' => 'selesai',
            ],
        );
    }

    private function assignInterest(Mahasiswa $mahasiswa, int $bidangMinatId): void
    {
        $mahasiswa->update(['bidang_minat_id' => $bidangMinatId]);
    }
}
