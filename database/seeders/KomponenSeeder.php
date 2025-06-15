<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomponenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('komponens')->insert([
            ['nama_komponen' => 'Guru memahami perbedaan kemampuan belajar setiap siswa.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memperhatikan latar belakang sosial dan budaya siswa dalam mengajar.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru mampu mengenali siswa yang mengalami kesulitan belajar sejak dini.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memberikan pendekatan berbeda kepada siswa sesuai dengan gaya belajarnya.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memahami potensi dan bakat unik dari setiap siswa.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru membantu siswa yang pemalu atau kurang percaya diri agar lebih aktif.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memberikan perhatian khusus pada siswa dengan kebutuhan khusus (jika ada).', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru bersikap adil kepada semua siswa tanpa membeda-bedakan.', 'tipe' => 1, 'status' => 1],
        ]);

        DB::table('komponens')->insert([
            ['nama_komponen' => 'Guru menjelaskan materi dengan pendekatan yang sesuai untuk tahap perkembangan siswa.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru menerapkan berbagai strategi pembelajaran agar siswa tidak cepat bosan.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru mampu mengaitkan teori dengan praktik secara jelas dalam kegiatan belajar.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru menerapkan prinsip pembelajaran aktif, kreatif, dan menyenangkan di kelas.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memberi kesempatan siswa untuk belajar mandiri dan bekerja sama dalam kelompok.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memahami kapan harus menggunakan diskusi, ceramah, atau metode lainnya.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru membantu siswa membangun pemahaman, bukan hanya menghafal informasi.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru mendorong siswa untuk berpikir kritis dan memecahkan masalah dalam pembelajaran.', 'tipe' => 1, 'status' => 1],
        ]);

        DB::table('komponens')->insert([
            ['nama_komponen' => 'Guru menyusun modul ajar yang sesuai dengan capaian pembelajaran dalam kurikulum.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Modul ajar yang digunakan mencakup tujuan pembelajaran, aktivitas, dan asesmen dengan lengkap.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Modul ajar yang digunakan memuat aktivitas pembelajaran yang variatif dan mendidik.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru menyusun bahan ajar yang relevan dengan konteks lokal dan kebutuhan peserta didik.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru mengadaptasi modul ajar agar sesuai dengan tingkat kemampuan siswa di kelas.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Modul ajar yang digunakan memperhatikan diferensiasi dalam proses belajar mengajar.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memperbarui modul ajar secara berkala sesuai evaluasi hasil belajar siswa.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru mencantumkan asesmen yang sesuai dengan tujuan pembelajaran dan indikator pencapaian.', 'tipe' => 1, 'status' => 1],
        ]);

        DB::table('komponens')->insert([
            ['nama_komponen' => 'Guru memulai pembelajaran dengan motivasi atau pengantar yang menarik.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru menyampaikan tujuan pembelajaran dengan jelas di awal kegiatan.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru menggunakan media atau alat bantu yang mendukung pemahaman materi.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru menciptakan interaksi positif antara guru dan siswa selama pembelajaran.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru melibatkan siswa secara aktif dalam proses pembelajaran.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru membimbing siswa dalam kegiatan pembelajaran secara bertahap dan sistematis.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru menghubungkan materi dengan konteks kehidupan sehari-hari.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru menutup pembelajaran dengan menyimpulkan materi dan memberi refleksi.', 'tipe' => 1, 'status' => 1],
        ]);

        DB::table('komponens')->insert([
            ['nama_komponen' => 'Guru mendorong siswa untuk mengenali dan mengembangkan potensi dirinya.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memberikan kesempatan kepada siswa untuk menunjukkan kreativitas dan inisiatif.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memberi perhatian pada perkembangan minat dan bakat siswa di luar akademik.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memotivasi siswa untuk memiliki tujuan belajar yang tinggi namun realistis.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru membimbing siswa agar percaya diri dalam mengembangkan kemampuannya.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru mengajak siswa untuk terlibat dalam kegiatan pengembangan diri di sekolah.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memberikan dukungan kepada siswa yang menunjukkan prestasi atau potensi khusus.', 'tipe' => 1, 'status' => 1],
            ['nama_komponen' => 'Guru memperlakukan setiap siswa sebagai individu yang unik dengan potensi berbeda-beda.', 'tipe' => 1, 'status' => 1],
        ]);

        DB::table('komponens')->insert([
            // Aspek 1: Sikap dan Etika Sosial
            ['nama_komponen' => 'Guru menunjukkan sikap dan menghormati keyakinan orang lain.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru bertindak sesuai dengan peraturan sekolah dan hukum yang berlaku.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru menunjukkan perilaku yang menghargai nilai-nilai sosial dalam berinteraksi.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru tidak pernah melakukan tindakan diskriminatif terhadap siswa.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru menjadi contoh dalam menjaga sopan santun dan etika dalam berkomunikasi.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru menghargai dan melestarikan budaya nasional dalam kehidupan sekolah.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru menanamkan nilai-nilai Pancasila dan semangat kebangsaan dalam kegiatan pembelajaran.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru bersikap adil dan bijak dalam mengambil keputusan yang menyangkut siswa.', 'tipe' => 2, 'status' => 1],
        
            // Aspek 2: Kehadiran dan Komitmen
            ['nama_komponen' => 'Guru hadir tepat waktu di kelas sesuai dengan jadwal yang ditentukan.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru jarang atau tidak pernah absen tanpa pemberitahuan yang jelas.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru konsisten hadir mengajar dari awal hingga akhir semester/tahun ajaran.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru menunjukkan komitmen untuk tetap hadir meskipun dalam kondisi tidak ideal.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru memberi tahu atau mengatur pengganti bila tidak bisa hadir.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru menghargai waktu belajar siswa dengan hadir sesuai jadwal pelajaran.', 'tipe' => 2, 'status' => 1],
        
            // Aspek 3: Tanggung Jawab dan Profesionalisme
            ['nama_komponen' => 'Guru menunjukkan semangat kerja yang tinggi dalam mengajar.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru menyelesaikan tugas-tugasnya dengan penuh tanggung jawab.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru tidak menunda pekerjaan yang berkaitan dengan pembelajaran atau administrasi.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru bekerja secara profesional meskipun dalam situasi sulit atau penuh tekanan.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru menjadi teladan bagi siswa dan rekan kerja dalam hal kedisiplinan dan kerja keras.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru selalu berusaha meningkatkan kualitas dirinya dalam mengajar.', 'tipe' => 2, 'status' => 1],
            ['nama_komponen' => 'Guru mampu mengelola waktu dengan baik antara mengajar, tugas tambahan, dan tanggung jawab lainnya.', 'tipe' => 2, 'status' => 1],
        ]);

        DB::table('komponens')->insert([
            // Penguasaan Materi Pelajaran
            ['nama_komponen' => 'Guru menguasai materi pelajaran dengan baik dan menyampaikannya secara jelas.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru mampu menjelaskan konsep-konsep dasar secara mendalam dan mudah dipahami.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru menunjukkan pemahaman yang kuat terhadap struktur dan alur materi pelajaran.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru mampu mengaitkan materi dengan konteks kehidupan nyata atau lintas disiplin ilmu.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru mengajarkan pola pikir ilmiah dan logis dalam menyelesaikan masalah pelajaran.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru mampu menjawab pertanyaan siswa dengan penjelasan yang runtut dan berbasis keilmuan.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru memperbarui pengetahuan sesuai perkembangan terkini dalam bidang pelajaran yang diampu.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru mendorong siswa untuk memahami konsep, bukan hanya menghafal informasi.', 'tipe' => 3, 'status' => 1],
        
            // Pengembangan Keprofesian Berkelanjutan
            ['nama_komponen' => 'Guru aktif mengikuti pelatihan, seminar, atau workshop pendidikan.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru terlibat dalam komunitas belajar atau kelompok kerja guru (KKG/MGMP).', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru mengembangkan keterampilan baru yang relevan dengan tugas mengajar.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru menyusun atau mengembangkan bahan ajar secara mandiri maupun kolaboratif.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru membaca dan mengikuti perkembangan literatur atau referensi pendidikan terbaru.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru bersedia berbagi ilmu hasil pengembangan profesinya dengan rekan sejawat.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru memanfaatkan hasil pelatihan atau kegiatan pengembangan untuk meningkatkan pembelajaran di kelas.', 'tipe' => 3, 'status' => 1],
            ['nama_komponen' => 'Guru mengikuti penilaian kinerja guru atau sertifikasi secara aktif dan bertanggung jawab.', 'tipe' => 3, 'status' => 1],
        ]);

        DB::table('komponens')->insert([
            // Aspek Sosial: Keadilan dan Toleransi
            ['nama_komponen' => 'Guru memperlakukan semua siswa dengan adil, tanpa membeda-bedakan latar belakang atau kondisi pribadi.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru menghargai perbedaan suku, agama, ras, budaya, dan kemampuan siswa.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru menyampaikan penilaian atau pendapat secara obyektif dan berdasarkan fakta.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru menciptakan lingkungan kelas yang ramah bagi semua siswa tanpa kecuali.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru tidak menunjukkan perlakuan khusus terhadap siswa tertentu.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru terbuka terhadap masukan dari siswa, orang tua, maupun rekan sejawat.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru menjadi contoh dalam menjalin hubungan sosial yang saling menghormati.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru menghindari sikap prasangka dan perlakuan yang tidak adil dalam interaksi di sekolah.', 'tipe' => 4, 'status' => 1],
        
            // Aspek Sosial: Hubungan Kerja Sama
            ['nama_komponen' => 'Guru menjalin komunikasi yang baik dengan guru lain dan tenaga kependidikan.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru menunjukkan sikap saling menghargai saat bekerja sama dengan rekan sejawat.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru terbuka terhadap pendapat dan masukan dari guru atau staf lainnya.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru aktif terlibat dalam kegiatan bersama guru dan tenaga kependidikan di sekolah.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru dapat bekerja sama dalam tim tanpa menimbulkan konflik atau perpecahan.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru menjaga etika komunikasi saat berinteraksi di lingkungan sekolah.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru bersedia membantu rekan kerja yang mengalami kesulitan dalam tugas-tugas sekolah.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru memiliki hubungan yang harmonis dengan semua pihak di lingkungan sekolah.', 'tipe' => 4, 'status' => 1],
        
            // Aspek Sosial: Partisipasi dan Inovasi
            ['nama_komponen' => 'Guru aktif mengikuti workshop, seminar, atau pelatihan yang berkaitan dengan pengembangan profesi.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru membagikan hasil workshop atau pelatihan kepada rekan sejawat di sekolah.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru antusias mengikuti kegiatan pelatihan yang diselenggarakan oleh sekolah atau instansi terkait.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru menerapkan ilmu atau keterampilan yang diperoleh dari workshop dalam kegiatan pembelajaran.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru mendukung budaya belajar sepanjang hayat dengan terus mengikuti pengembangan diri.', 'tipe' => 4, 'status' => 1],
            ['nama_komponen' => 'Guru terbuka terhadap inovasi baru dalam pendidikan dari hasil pelatihan yang diikutinya.', 'tipe' => 4, 'status' => 1],
        ]);
        


    }
}
