<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use App\Models\MbbrProgramType;
use App\Models\User;
use App\Models\ProvincialLeader;
use App\Models\WelcomeSlide;
use App\Models\Post;
use App\Models\Agenda;
use App\Models\StructuralOfficial;
use App\Models\Gallery;
use App\Models\Document;
use App\Models\OrganizationalUnit;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(['username'=>'admin'], ['name'=>'Administrator','email'=>'admin@dinaspkp.local','password'=>Hash::make('admin12345'),'role'=>'admin','is_active'=>true]);
        WebsiteSetting::query()->updateOrCreate(['id'=>1], ['agency_name'=>'Dinas Perumahan dan Kawasan Permukiman Provinsi Maluku','short_name'=>'Dinas PKP Maluku','about'=>'Dinas Perumahan dan Kawasan Permukiman Provinsi Maluku adalah perangkat daerah yang melaksanakan urusan pemerintahan bidang perumahan rakyat dan kawasan permukiman. Dinas berkomitmen menghadirkan hunian yang layak, aman, sehat, terjangkau, serta lingkungan permukiman yang berkelanjutan bagi masyarakat Maluku.','history'=>'Dinas Perumahan dan Kawasan Permukiman Provinsi Maluku dibentuk sebagai perangkat daerah untuk memperkuat pelayanan publik pada bidang perumahan rakyat dan kawasan permukiman. Dalam perkembangannya, dinas menjalankan perencanaan, penyediaan rumah layak huni, penanganan kawasan permukiman, peningkatan kualitas rumah masyarakat berpenghasilan rendah, serta koordinasi pembangunan perumahan bersama pemerintah kabupaten/kota dan pemangku kepentingan.','vision'=>'Mewujudkan permukiman yang layak, aman, nyaman, dan terjangkau bagi masyarakat Maluku.','mission'=>'Meningkatkan kualitas pelayanan, penyediaan perumahan, dan pembangunan kawasan permukiman secara berkelanjutan.','address'=>'Jl. Wolter Monginsidi, Passo, Kec. Baguala, Kota Ambon, Maluku','email'=>'dpkp@malukuprov.go.id','website'=>'dinasperkim.malukuprov.go.id','social_links'=>['facebook'=>'https://www.facebook.com/MalukuProv','instagram'=>'https://www.instagram.com/malukuprov/','youtube'=>'https://www.youtube.com/@MalukuProvTV']]);
        MbbrProgramType::query()->updateOrCreate(['code'=>'PEMBANGUNAN_PERUMAHAN'], ['name'=>'Pembangunan Perumahan','description'=>'Program pembangunan dan penyediaan perumahan yang layak bagi masyarakat.']);
        MbbrProgramType::query()->updateOrCreate(['code'=>'KAWASAN_PERMUKIMAN'], ['name'=>'Kawasan Permukiman','description'=>'Program penataan dan peningkatan kualitas kawasan permukiman.']);
        MbbrProgramType::query()->updateOrCreate(['code'=>'PENINGKATAN_PSU'], ['name'=>'Peningkatan PSU','description'=>'Program peningkatan prasarana, sarana, dan utilitas umum perumahan.']);
        ProvincialLeader::query()->updateOrCreate(['position'=>'gubernur'], ['name'=>'Hendrik Lewerissa, S.H., LL.M.','period'=>'2025 – 2030','vision'=>'Transformasi Maluku Menuju Maluku Yang Maju, Adil dan Sejahtera Menyongsong Indonesia Emas 2045','photo_path'=>'assets/img/gub.png','emblem_path'=>'assets/img/logo.png','sort_order'=>1,'is_active'=>true]);
        ProvincialLeader::query()->updateOrCreate(['position'=>'wakil_gubernur'], ['name'=>'H. Abdullah Vanath, S.Sos.','period'=>'2025 – 2030','vision'=>'Transformasi Maluku Menuju Maluku Yang Maju, Adil dan Sejahtera Menyongsong Indonesia Emas 2045','photo_path'=>'assets/img/wagub.png','emblem_path'=>'assets/img/logo.png','sort_order'=>2,'is_active'=>true]);
        WelcomeSlide::query()->updateOrCreate(['image_path'=>'assets/img/carousel/1.jpg'], ['title'=>'Selamat Datang di Dinas Perkim Maluku','subtitle'=>'Mewujudkan Permukiman yang Layak dan Terjangkau','sort_order'=>1,'is_active'=>true]);
        WelcomeSlide::query()->updateOrCreate(['image_path'=>'assets/img/carousel/2.jpg'], ['title'=>'Pelayanan Perumahan untuk Maluku','subtitle'=>'Informasi, program dan layanan bagi masyarakat','sort_order'=>2,'is_active'=>true]);
        Post::query()->updateOrCreate(['slug'=>'peningkatan-kualitas-perumahan-maluku'], ['title'=>'Peningkatan Kualitas Perumahan di Maluku','excerpt'=>'Dinas PKP Maluku terus mendorong pembangunan permukiman yang layak dan terjangkau bagi masyarakat.','content'=>'Informasi kegiatan dan program peningkatan kualitas perumahan di Provinsi Maluku.','cover_image'=>'assets/img/carousel/3.jpg','status'=>'published','published_at'=>now(),'author_id'=>1]);
        Post::query()->updateOrCreate(['slug'=>'koordinasi-program-rumah-layak-huni'], ['title'=>'Koordinasi Program Rumah Layak Huni','category'=>'Kegiatan','excerpt'=>'Koordinasi lintas sektor dilakukan untuk memperkuat layanan perumahan masyarakat Maluku.','content'=>'Berita kegiatan koordinasi program rumah layak huni.','cover_image'=>'assets/img/carousel/4.jpg','status'=>'published','published_at'=>now()->subDay(),'author_id'=>1]);
        foreach ([
            ['sosialisasi-program-perumahan-di-ambon','Sosialisasi Program Perumahan bagi Masyarakat di Kota Ambon','Kegiatan','Sosialisasi program perumahan dilaksanakan untuk memperluas akses informasi layanan kepada masyarakat.','Dinas PKP melaksanakan sosialisasi program perumahan bagi masyarakat di Kota Ambon. Kegiatan ini menjadi sarana penyampaian informasi mengenai layanan dan mekanisme program perumahan.','assets/img/carousel/1.jpg',2],
            ['monitoring-peningkatan-kualitas-rumah','Monitoring Peningkatan Kualitas Rumah Masyarakat','Program','Tim Dinas PKP melakukan monitoring pelaksanaan peningkatan kualitas rumah masyarakat.','Monitoring lapangan dilakukan untuk memastikan program peningkatan kualitas rumah berjalan sesuai rencana. Hasil monitoring menjadi bahan evaluasi pelaksanaan program berikutnya.','assets/img/carousel/2.jpg',3],
            ['rapat-penataan-kawasan-permukiman','Rapat Koordinasi Penataan Kawasan Permukiman','Kegiatan','Koordinasi lintas perangkat daerah membahas penataan kawasan permukiman berkelanjutan.','Dinas PKP bersama pemangku kepentingan melaksanakan rapat koordinasi penataan kawasan permukiman untuk menyelaraskan program dan kebutuhan infrastruktur dasar.','assets/img/carousel/3.jpg',4],
            ['verifikasi-data-penerima-mbbr','Verifikasi Data Penerima Bantuan MBBR Tahun 2025','Pengumuman','Verifikasi data dilakukan untuk menjaga ketepatan sasaran program bantuan masyarakat berpenghasilan rendah.','Proses verifikasi data penerima bantuan MBBR dilakukan secara bertahap bersama pemerintah kabupaten dan kota.','assets/img/carousel/4.jpg',5],
            ['peningkatan-psu-perumahan','Peningkatan Prasarana, Sarana, dan Utilitas Perumahan','Program','Peningkatan PSU menjadi bagian penting dalam mendukung lingkungan hunian yang layak.','Program peningkatan prasarana, sarana, dan utilitas umum diarahkan untuk mendukung kualitas lingkungan perumahan sesuai kebutuhan masyarakat.','assets/img/carousel/1.jpg',6],
            ['pelayanan-informasi-perumahan','Pelayanan Informasi Perumahan Terus Diperkuat','Layanan','Dinas PKP memperkuat penyediaan informasi program dan layanan bagi masyarakat.','Penyediaan informasi yang mudah diakses menjadi bagian dari peningkatan kualitas pelayanan publik Dinas PKP.','assets/img/carousel/2.jpg',7],
            ['evaluasi-program-kawasan-permukiman','Evaluasi Program Kawasan Permukiman Semester I','Kegiatan','Evaluasi dilakukan untuk mengukur capaian pelaksanaan program kawasan permukiman.','Evaluasi mencakup capaian kegiatan, kendala di lapangan, serta langkah tindak lanjut pelaksanaan program.','assets/img/carousel/3.jpg',8],
            ['kerja-bakti-lingkungan-permukiman','Kolaborasi Masyarakat dalam Menjaga Lingkungan Permukiman','Informasi','Partisipasi masyarakat menjadi unsur penting dalam menciptakan lingkungan permukiman yang sehat.','Dinas PKP mengajak masyarakat untuk menjaga lingkungan permukiman melalui kerja sama dan pemanfaatan prasarana secara berkelanjutan.','assets/img/carousel/4.jpg',9],
            ['penguatan-data-geospasial-perumahan','Penguatan Data Geospasial untuk Perencanaan Perumahan','Program','Pemanfaatan data geospasial mendukung perencanaan program yang lebih tepat sasaran.','Penguatan data geospasial dilakukan sebagai bagian dari penyediaan informasi pembangunan perumahan dan kawasan permukiman.','assets/img/carousel/1.jpg',10],
            ['persiapan-program-perumahan-tahun-berikutnya','Persiapan Program Perumahan Tahun Anggaran Berikutnya','Pengumuman','Penyusunan program dilakukan secara terarah dengan memperhatikan kebutuhan masyarakat Maluku.','Dinas PKP menyiapkan usulan program perumahan tahun anggaran berikutnya berdasarkan data kebutuhan dan prioritas wilayah.','assets/img/carousel/2.jpg',11],
        ] as [$slug,$title,$category,$excerpt,$content,$cover,$days]) Post::query()->updateOrCreate(['slug'=>$slug], ['title'=>$title,'category'=>$category,'excerpt'=>$excerpt,'content'=>$content,'cover_image'=>$cover,'status'=>'published','published_at'=>now()->subDays($days),'author_id'=>1]);
        Agenda::query()->updateOrCreate(['title'=>'Rapat Koordinasi Pembangunan Perumahan'], ['description'=>'Rapat koordinasi program pembangunan perumahan.','location'=>'Kantor Dinas PKP Maluku','start_date'=>today()->addDays(5),'status'=>'scheduled']);
        Agenda::query()->updateOrCreate(['title'=>'Monitoring Proyek Perumahan'], ['description'=>'Monitoring pelaksanaan proyek perumahan dan kawasan permukiman.','location'=>'Kota Ambon','start_date'=>today()->addDays(12),'status'=>'scheduled']);
        Gallery::query()->updateOrCreate(['title'=>'Kegiatan Pelayanan Perumahan'], ['image_path'=>'assets/img/carousel/1.jpg','description'=>'Dokumentasi kegiatan pelayanan Dinas PKP Maluku.','category'=>'kegiatan','is_active'=>true]);
        Gallery::query()->updateOrCreate(['title'=>'Program Kawasan Permukiman'], ['image_path'=>'assets/img/carousel/2.jpg','description'=>'Dokumentasi program pembangunan kawasan permukiman.','category'=>'kegiatan','is_active'=>true]);
        Gallery::query()->updateOrCreate(['title'=>'Monitoring Peningkatan Kualitas Rumah'], ['image_path'=>'assets/img/carousel/3.jpg','description'=>'Dokumentasi monitoring program peningkatan kualitas rumah masyarakat.','category'=>'kegiatan','is_active'=>true]);
        Gallery::query()->updateOrCreate(['title'=>'Koordinasi Pembangunan Perumahan'], ['image_path'=>'assets/img/carousel/4.jpg','description'=>'Kegiatan koordinasi pembangunan perumahan bersama pemangku kepentingan.','category'=>'kegiatan','is_active'=>true]);
        Gallery::query()->updateOrCreate(['title'=>'Informasi Layanan Perumahan'], ['image_path'=>'assets/img/carousel/1.jpg','description'=>'Materi informasi layanan perumahan dan kawasan permukiman untuk masyarakat.','category'=>'informasi','is_active'=>true]);
        Gallery::query()->updateOrCreate(['title'=>'Publikasi Program MBBR'], ['image_path'=>'assets/img/carousel/2.jpg','description'=>'Informasi pelaksanaan program bantuan masyarakat berpenghasilan rendah.','category'=>'informasi','is_active'=>true]);
        Document::query()->updateOrCreate(['title'=>'Informasi Layanan Dinas PKP','category'=>'informasi'], ['file_path'=>'assets/img/carousel/1.jpg','description'=>'Informasi umum layanan Dinas PKP Maluku.','published_date'=>today()]);
        Document::query()->updateOrCreate(['title'=>'Daftar Dokumen Unduhan','category'=>'unduhan'], ['file_path'=>'assets/img/carousel/2.jpg','description'=>'Dokumen publik yang dapat diunduh masyarakat.','published_date'=>today()]);
        Document::query()->updateOrCreate(['title'=>'Peraturan Bidang Perumahan','category'=>'peraturan'], ['file_path'=>'assets/img/carousel/3.jpg','description'=>'Kumpulan informasi peraturan bidang perumahan dan kawasan permukiman.','published_date'=>today()]);
        WebsiteSetting::query()->whereKey(1)->update([
            'about'=>'Dinas Perumahan dan Kawasan Pemukiman Provinsi Maluku merupakan instansi pemerintah yang bertanggung jawab dalam penyelenggaraan urusan pemerintahan di bidang perumahan dan kawasan pemukiman sesuai amanat Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah. Kami berkomitmen mewujudkan permukiman yang layak, aman, nyaman, sehat, dan terjangkau bagi seluruh masyarakat Maluku.',
            'history'=>'Dinas Perumahan dan Kawasan Pemukiman Provinsi Maluku dibentuk berdasarkan Peraturan Daerah Provinsi Maluku dengan tugas pokok melaksanakan urusan pemerintahan di bidang perumahan dan kawasan pemukiman. Sejak berdiri, dinas ini telah berkontribusi dalam pembangunan unit rumah, pengembangan kawasan pemukiman, dan peningkatan kualitas hidup masyarakat Maluku melalui berbagai program strategis.',
            'vision'=>'Transformasi Menuju Maluku yang Maju, Adil dan Sejahtera Menyongsong Indonesia Emas 2045.',
            'mission'=>'1. Meningkatkan aksesibilitas masyarakat terhadap perumahan dan permukiman yang layak melalui program yang inklusif dan berkeadilan.\n2. Mengembangkan kawasan permukiman yang terintegrasi, berkelanjutan, dan ramah lingkungan.\n3. Memberdayakan masyarakat dalam penyelenggaraan perumahan dan permukiman melalui peningkatan kapasitas serta partisipasi aktif.\n4. Memperkuat tata kelola pemerintahan dan pelayanan publik yang transparan, akuntabel, serta berkeadilan.',
            'duties'=>'Dinas Perumahan dan Kawasan Pemukiman Provinsi Maluku bertugas menyelenggarakan urusan pemerintahan bidang perumahan rakyat dan kawasan permukiman. Fungsinya meliputi perencanaan dan pengembangan kawasan pemukiman; pembangunan dan perbaikan perumahan; pengelolaan lingkungan permukiman; fasilitasi pembiayaan perumahan; serta pengawasan dan pengendalian pembangunan.',
            'address'=>'Jl. Gubernur M. J. Latuharhary No. 01, Kec. Sirimau, Kota Ambon, Provinsi Maluku','phone'=>'(0911) 352312','email'=>'dinasperkim@malukuprov.go.id','website'=>'https://perkim.malukuprov.go.id'
        ]);
        WebsiteSetting::query()->whereKey(1)->update(['mission'=>str_replace('\\n', PHP_EOL, WebsiteSetting::query()->find(1)->mission)]);
        WebsiteSetting::query()->whereKey(1)->update(['mission'=>implode(PHP_EOL, [
            '1. Meningkatkan aksesibilitas masyarakat terhadap perumahan dan permukiman yang layak melalui program-program yang inklusif dan berkeadilan serta peningkatan tata kelola pemerintahan dan pelayanan publik secara adil, inklusif, transparan, dan akuntabel.',
            '2. Mengembangkan kawasan permukiman yang terintegrasi, berkelanjutan, dan ramah lingkungan dengan memperhatikan daya dukung ekosistem serta pengentasan kemiskinan dan penurunan tingkat pengangguran melalui kebijakan yang tepat sasaran, efisien, dan efektif.',
            '3. Memberdayakan masyarakat dalam penyelenggaraan perumahan dan permukiman melalui peningkatan kapasitas dan partisipasi aktif serta memperkuat pembangunan sumber daya manusia, sains, teknologi, pendidikan, kesehatan, prestasi olahraga, kesetaraan gender, dan penguatan peran perempuan, pemuda, serta penyandang disabilitas.',
            '4. Peningkatan kualitas dan kuantitas infrastruktur dasar serta transportasi dan telekomunikasi untuk memperlancar konektivitas antar dan intra wilayah.',
            '5. Pengelolaan lingkungan kawasan pesisir dan pulau-pulau kecil, sumber daya alam yang berkelanjutan, adaptasi dan mitigasi dampak perubahan iklim, serta ketahanan bencana yang etis, responsif, dan akuntabel.',
            '6. Peningkatan pertumbuhan ekonomi yang inklusif melalui hilirisasi komoditas unggulan, pemberian insentif bagi usaha mikro, kecil, dan menengah, membuka aksesibilitas pasar, serta mengurangi disparitas antarwilayah.',
            '7. Penataan dan revitalisasi lembaga sosial kemasyarakatan dalam semangat hidup orang basudara, berbasis adat budaya dan kearifan lokal serta ketaatan dan kepatuhan terhadap hukum.'
        ])]);
        $officials = [
            ['Nurjanah Yunus, S.T., M.M.,M.Si','KEPALA DINAS','II','197706212001072001','S2 Magister Sains','Pimpinan'],
            ['Wody Andi Alen Timisela, S.Hut, M.Si','SEKRETARIS DINAS','III',null,'S2 Magister Sains','SEKRETARIAT'],
            ['Fadly H. Latukolengsusu, ST, MT','KEPALA BIDANG RUMAH UMUM','III','197611112005011005','S2 Magister Teknik','BIDANG RUMAH UMUM'],
            ['Anthony Wattimena, ST','KEPALA BIDANG RUMAH SWADAYA','III',null,'S1 Teknik','BIDANG RUMAH SWADAYA'],
            ['Nurul H. Sopalauw, ST, M.Si','KEPALA BIDANG KAWASAN PERMUKIMAN','III',null,'S2 Magister Sains','BIDANG KAWASAN PERMUKIMAN'],
            ['Linley Jerry Pattinama, ST, MT','KEPALA BIDANG PRASARANA DAN PEMBIAYAAN','III',null,'S2 Magister Teknik','BIDANG PRASARANA DAN PEMBIAYAAN'],
            ['Kardi Dahlan, SE, M.Si','KASUBAG KEPEGAWAIAN DAN UMUM','IV',null,'S2 Magister Sains','SEKRETARIAT'],
            ['Asnawi Marasabesy, SE','KASUBAG KEUANGAN DAN ASET','IV',null,'S1 Ekonomi','SEKRETARIAT'],
        ];
        foreach ($officials as $index => [$name,$position,$echelon,$nip,$education,$unit]) StructuralOfficial::query()->updateOrCreate(['position'=>$position], ['name'=>$name,'nip'=>$nip,'unit'=>$unit,'education'=>$education,'echelon'=>'Eselon '.$echelon,'photo_path'=>'assets/img/user.png','bio'=>'Pejabat struktural pada '.$unit.' Dinas Perumahan dan Kawasan Permukiman Provinsi Maluku.','sort_order'=>$index+1,'is_active'=>true]);
        foreach ([
            ['JF. PERENCANAAN AHLI MUDA','sekretariat','jf-perencanaan',1],
            ['JF. TEKNIK TATA BANGUNAN DAN PERUMAHAN AHLI MUDA','rumah-umum','jf-rumah-umum-1',1],
            ['JF. TEKNIK TATA BANGUNAN DAN PERUMAHAN AHLI MUDA','rumah-umum','jf-rumah-umum-2',2],
            ['JF. TEKNIK TATA BANGUNAN DAN PERUMAHAN AHLI MUDA','rumah-swadaya','jf-rumah-swadaya-1',1],
            ['JF. TEKNIK TATA BANGUNAN DAN PERUMAHAN AHLI MUDA','rumah-swadaya','jf-rumah-swadaya-2',2],
            ['JF. TEKNIK PENYEHATAN DAN PERUMAHAN AHLI MUDA','kawasan-permukiman','jf-kawasan-1',1],
            ['JF. TEKNIK PENYEHATAN DAN PERUMAHAN AHLI MUDA','kawasan-permukiman','jf-kawasan-2',2],
            ['JF. TEKNIK PENYEHATAN DAN PERUMAHAN AHLI MUDA','prasarana-pembiayaan','jf-prasarana-1',1],
            ['JF. TEKNIK PENYEHATAN DAN PERUMAHAN AHLI MUDA','prasarana-pembiayaan','jf-prasarana-2',2],
        ] as [$name,$parent,$key,$order]) OrganizationalUnit::query()->updateOrCreate(['unit_key'=>$key],['name'=>$name,'parent_key'=>$parent,'sort_order'=>$order,'is_active'=>true]);
    }
}
