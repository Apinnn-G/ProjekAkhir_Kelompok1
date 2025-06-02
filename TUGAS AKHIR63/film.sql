-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 02, 2025 at 02:09 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `film`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'adminnontoniq@gmail.com', 'admin123\r\n', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `film_id` int NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `film_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` varchar(225) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`id`, `user_id`, `film_id`, `title`, `content`, `created_at`, `comment`) VALUES
(1, 10, 6, '', '', '2025-06-02 04:20:47', 'bagus dangdut'),
(2, 10, 1, '', '', '2025-06-02 07:11:35', 'bukit jelek');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `durasi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `rating` decimal(3,1) DEFAULT '0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `judul`, `durasi`, `genre`, `gambar`, `featured`, `deskripsi`, `rating`) VALUES
(1, 'Lilo & Stitch', '1h 48m', 'Adventure', 'm1.jpg', 1, '“Lilo & Stitch” adalah kisah yang sangat lucu dan menyentuh tentang seorang gadis Hawaii yang kesepian dan alien buronan yang membantu memperbaiki keluarganya yang hancur. Film ini disutradarai oleh pembuat film pemenang penghargaan Dean Fleischer Camp, dengan skenario oleh Chris Kekaniokalani Bright dan Mike Van Waes, dan dibintangi oleh Sydney Elizebeth Agudong, Billy Magnussen, Tia Carrere, Hannah Waddingham, Chris Sanders, dengan Courtney B. Vance, dan Zach Galifianakis, dan memperkenalkan Maia Kealoha. “Lilo & Stitch” diproduksi oleh Jonathan Eirich, pga dan Dan Lin, dengan Tom Peitzman, Ryan Halprin, Louie Provost, Thomas Schumacher sebagai produser eksekutif.', 4.0),
(2, 'Cocote Tonggo', '1h 57m', 'Comedy', 'm2.jpg', 1, '\"Cocote Tonggo\" (bahasa Jawa yang berarti \"Mulut Tetangga\") adalah film komedi Indonesia tahun 2025 yang disutradarai oleh Bayu Skak. Film ini bercerita tentang tekanan sosial dan pilihan-pilihan yang diambil oleh pasangan suami istri, Murni dan Luki, yang menjalankan bisnis jamu kesuburan, namun kesulitan memiliki anak. \r\n', 4.0),
(3, 'Pembantaian Dukun Santet', '1h 32m', 'Horror', 'm3.jpg', 1, 'Pembantaian Dukun Santet (sebelumnya Lemah Santet Banyuwangi) adalah sebuah film horor Indonesia tahun 2025 yang disutradarai oleh Azhar Kinoi Lubis. Film tersebut menampilkan Kevin Ardilova, Aurora Ribero, Kaneishia Yusuf, dan Ariyo Wahab. Film tersebut dirilis pada 8 Mei 2025. Film ini mengisahkan mengenai Pembantaian Banyuwangi 1998.', 0.0),
(4, 'Mungkin Kita Perlu Waktu', '1h 38m', 'Family, Drama', 'm4.jpg', 1, '\"Mungkin Kita Perlu Waktu\" adalah film drama keluarga Indonesia yang menceritakan sebuah keluarga yang berusaha bangkit dari depresi setelah kehilangan anak sulung mereka secara mendadak. Film ini mengisahkan perjalanan emosional masing-masing anggota keluarga dalam menghadapi duka dan bagaimana trauma kehilangan dapat memengaruhi dinamika keluarga. \r\nMungkin Kita Perlu Waktu ditulis dan digarap sutradara Teddy Soeriaatmadja. Teddy dikenal sebagai sutradara Lovely Man (2011), About a Woman (2015), Affliction (2021), hingga Berbalas Kejam (2023).\r\n\r\nFilm ini menampilkan Bima Azriel, Lukman Sardi, Sha Ine Febriyanti, Tissa Biani, Naura Hakim, hingga Asri Welas.', 0.0),
(5, 'Pengepungan Di Bukit Duri', '1h 58m', 'Thriller', 'm5.jpg', 1, ' film tersebut mengisahkan Edwin yang berjanji akan menemukan anak kakaknya. Pencarian Edwin membawanya masuk ke SMA Bukit Duri, tempat siswa-siswi buangan. Ketika akhirnya bertemu dengan sang keponakan, kerusuhan pecah. Edwin dan keponakannya terjebak di SMA Bukit Duri, di mana anak-anak beringas mengincar nyawa mereka.\r\n\r\nDisutradarai oleh Joko Anwar, Film produksi Amazon MGM Studios serta Come and See Pictures ini dibintangi oleh Morgan Oey, Omara Esteghlal, dan Hana Malasan.', 0.0),
(6, 'Mendadak Dangdut', '1h 49m', 'Comedy', 'm6.jpg', 1, '\"Mendadak Dangdut\" (2025) adalah film komedi drama Indonesia yang mengisahkan perjalanan Naya, seorang penyanyi pop terkenal, yang terpaksa menyamar dan terjun ke dunia dangdut setelah dituduh terlibat dalam kasus pembunuhan.\r\nFilm yang dibintangi Anya Geraldine ini bukan remake melainkan reboot atau produksi versi baru dari film asli yang rilis tahun 2006.\r\nMengusung alur cerita dan lebih fresh, Mendadak Dangdut menghadirkan nuansa baru yang lebih emosional dengan mempertahankan semangat dalam membawa musik dangdut. Film ini mempunyai pengembangan karakter dengan pemeran yang berbeda dari versi sebelumnya.\r\n\r\nMeskipun begitu, satu aktor dari versi 2026 kembali memerankan karakter yang sama. Yakni Dwi Sasono yang hadir memberikan sentuhan nostalgia bagi penggemar film pertama. Ia tetap memerankan karakter Rizal Maduma yang bertransformasi menjadi seorang produser dangdut.', 5.0),
(7, 'Mumu', '1h 51m', 'Drama', 'm7.jpg', 1, 'Film MuMu: Silent Love adalah drama keluarga asal Tiongkok yang dirilis di Indonesia pada 7 Mei 2025. Disutradarai oleh Sha Mo, film ini dibintangi oleh Lay Zhang (anggota EXO) sebagai Xiao Ma dan Li Luoan sebagai MuMu. Kisahnya mengangkat tema cinta tanpa kata dalam komunitas Tuli, menjadikannya sebagai \"surat cinta\" bagi Teman Tuli di seluruh dunia.\nMuMu adalah seorang gadis berusia 7 tahun yang dibesarkan oleh ayahnya yang tunarungu, Xiao Ma, di sebuah komunitas Tuli yang hangat dan penuh kasih. Kehidupan mereka yang damai terguncang ketika ibu kandung MuMu, Xiao Jing, tiba-tiba muncul dan berusaha mengambil hak asuh atas MuMu. Xiao Ma pun berjuang keras mempertahankan putrinya, bahkan rela terlibat dalam pekerjaan ilegal demi mendapatkan pengacara dan penghasilan yang cukup. Sementara itu, MuMu harus beradaptasi dengan dunia baru yang penuh suara, namun ia merasa terasing dan merindukan kehangatan serta komunikasi tanpa kata bersama ayahnya.', 5.0),
(8, 'Gundik', '1h 52m', 'Horror', 'm8.jpg', 1, 'Film Gundik adalah film horor-thriller Indonesia yang dirilis pada 22 Mei 2025, disutradarai oleh Anggy Umbara. Film ini menggabungkan elemen horor, aksi perampokan (heist), dan sentuhan komedi, terinspirasi dari mimpi sang sutradara yang bertemu sosok mistis Nyi Roro Kidul .Otto, mantan tentara yang baru bebas dari penjara, terpaksa merampok rumah seorang wanita kaya bernama Nyai demi masa depan anaknya. Namun, aksi perampokan itu berubah jadi mimpi buruk ketika mereka menyadari Nyai bukan wanita biasa, melainkan sosok misterius yang menyimpan kekuatan gaib. Rumah itu pun berubah jadi arena teror mistis yang mematikan.', 3.0),
(9, 'Thunderbolts', '2h 7m', 'Action', 'm9.jpg', 1, 'Thunderbolts adalah film superhero Marvel Studios yang dirilis pada 2 Mei 2025, menutup fase kelima Marvel Cinematic Universe (MCU). Disutradarai oleh Jake Schreier, film ini menampilkan tim antihero yang terdiri dari Yelena Belova, Bucky Barnes, Red Guardian, Ghost, Taskmaster, dan John Walker. Mereka dipaksa bekerja sama dalam misi berbahaya setelah terjebak dalam jebakan yang dirancang oleh Valentina Allegra de Fontaine, Direktur CIA. Misi ini memaksa mereka menghadapi masa lalu kelam dan mencari penebusan diri.', 0.0),
(11, 'The Red Envelope', '2h 8m', 'Comedy', 'm10.jpg', 1, 'The Red Envelope adalah film komedi aksi supernatural asal Thailand yang dirilis pada 15 Mei 2025. Disutradarai oleh Chayanop Boonprakob, film ini merupakan adaptasi dari film Taiwan Marry My Dead Body (2022) dan dibintangi oleh duo populer Billkin (Putthipong Assaratanakul) dan PP Krit (Krit Amnuaydechkorn). The Red Envelope bercerita tentang Menn, mantan perampok yang terpaksa menikah dengan hantu pria bernama Titi setelah mengambil amplop merah mistis. Untuk membebaskan diri, ia harus membantu Titi mengungkap penyebab kematiannya—yang ternyata terkait kasus narkoba besar. Dalam prosesnya, keduanya menjalin hubungan tak terduga penuh aksi, komedi, dan emosi.', 4.0),
(22, 'John Wick', '1h 41m', 'Action', 'm11.jpg', 1, 'John Wick adalah mantan pembunuh bayaran yang pensiun setelah menikah dan menjalani hidup tenang. Namun, saat anjing kesayangannya yang diberikan oleh almarhum istrinya dibunuh oleh penjahat, John kembali ke dunia gelap penuh kekerasan untuk membalas dendam. Dalam prosesnya, dia menghadapi banyak musuh dan konflik dari dunia kriminal bawah tanah yang sangat berbahaya.\r\n\r\nSeiring berjalannya waktu, John semakin terjerat dalam perang melawan organisasi pembunuh bayaran internasional yang menganggapnya sebagai ancaman besar. Setiap langkahnya penuh dengan aksi brutal dan ketegangan, saat ia berusaha bertahan hidup dan mencari kebebasan dari sistem yang ingin mengontrolnya. Film ini mengisahkan perjuangan John untuk mempertahankan harga dirinya sekaligus mencari kedamaian.\r\n', 5.0),
(23, 'Extraction', '2h 40m', 'Action', 'm12.jpg', 1, 'Extraction menceritakan tentang Tyler Rake, seorang tentara bayaran tangguh yang ditugaskan untuk menyelamatkan anak dari seorang kriminal internasional yang kuat dan berbahaya di kawasan kumuh di Bangladesh. Misi penyelamatan ini penuh dengan aksi intens dan berbahaya, di mana Tyler harus menghadapi berbagai kelompok kriminal yang siap membunuh demi melindungi target mereka.\r\n\r\nSelama perjalanan, Tyler tidak hanya bertarung melawan musuh, tapi juga bergumul dengan masa lalunya yang kelam dan rasa tanggung jawab untuk melindungi nyawa anak tersebut. Film ini menampilkan ketegangan tinggi, adegan perkelahian dan tembak-menembak yang intens, serta menunjukkan bagaimana Tyler berjuang keras demi keberhasilan misi yang hampir mustahil tersebut.\r\n', 0.0),
(24, 'FOXTROT SIX', '1h 55m', 'Action', 'm13.jpg', 1, 'Foxtrot Six berdurasi sekitar 114 menit. Film ini bergenre aksi fiksi ilmiah dan mengambil latar masa depan ketika Indonesia mengalami krisis pangan akibat perubahan iklim. Negara dikuasai oleh partai otoriter bernama PIRANAS yang menindas rakyat demi mempertahankan kekuasaan. Angga, mantan marinir yang kini menjadi anggota parlemen PIRANAS, ditugaskan untuk membasmi kelompok pemberontak bernama Reform.\r\n\r\nNamun setelah diculik oleh Reform dan bertemu kembali dengan Sari, cinta lamanya, Angga mulai menyadari bahwa ia berada di pihak yang salah. Ia pun membelot dan membentuk tim bernama Foxtrot Six bersama lima mantan rekannya. Bersama-sama, mereka berjuang melawan rezim yang kejam demi menyelamatkan masa depan bangsa. Film ini penuh dengan aksi, ledakan, dan nuansa perjuangan untuk kebebasan.\r\n', 0.0),
(25, '13 Bom di Jakarta', '2h 13m', 'Action', 'm14.jpg', 1, 'Film ini mengisahkan ancaman teror besar di ibu kota, ketika seorang teroris bernama Arok mengancam akan meledakkan 13 bom di Jakarta setiap delapan jam. Pemerintah pun dikejutkan oleh skala ancaman ini dan segera membentuk tim khusus untuk mencegah bencana yang bisa memakan banyak korban jiwa. Dengan waktu yang terus berjalan, ketegangan meningkat di seluruh kota.\r\n\r\nDi tengah penyelidikan, muncul dua pengusaha muda bernama Oscar dan William yang diduga terlibat dalam jaringan teroris tersebut. Keadaan makin kacau ketika tim agen rahasia yang menangani kasus ini menyadari ada penyusup di antara mereka. Film ini penuh dengan ketegangan, aksi, dan misteri yang membuat penonton terus menebak-nebak siapa yang bisa dipercaya dan bagaimana cara mencegah kehancuran Jakarta.\r\n', 0.0),
(26, 'Inception', '2h 28m', 'Action', 'm15.jpg', 1, 'Film ini bercerita tentang Dom Cobb, seorang pencuri profesional yang memiliki kemampuan untuk masuk ke dalam mimpi orang lain dan mencuri rahasia terdalam dari alam bawah sadar mereka. Keahliannya membuatnya diburu oleh banyak pihak, tapi juga memberinya kesempatan untuk menebus masa lalunya. Cobb ditawari misi yang berbeda dari biasanya, yaitu bukan mencuri ide, tetapi menanamkan ide ke dalam pikiran seseorang&mdash;proses yang disebut sebagai &quot;inception&quot;.\r\n\r\nUntuk menyelesaikan misi ini, Cobb merekrut tim dengan keahlian khusus dan menyusun rencana kompleks yang melibatkan mimpi di dalam mimpi. Namun, semakin dalam mereka masuk ke dalam lapisan mimpi, semakin sulit membedakan antara kenyataan dan ilusi. Di tengah tekanan waktu dan ancaman dari alam bawah sadarnya sendiri, Cobb harus menghadapi trauma masa lalu demi bisa kembali ke keluarganya. Film ini memadukan aksi, psikologi, dan filosofi dalam perjalanan penuh teka-teki.\r\n', 0.0),
(27, 'Headshot', '1h 58m', 'Action', 'm16.jpg', 1, 'Headshot mengisahkan seorang pria muda yang ditemukan dalam kondisi koma oleh seorang dokter bernama Ailin setelah mengalami luka tembak di kepala. Setelah ia sadar, pria itu tidak mengingat identitas atau masa lalunya. Ia pun diberi nama Ishmael oleh Ailin dan mulai menjalani hidup baru. Namun, ketenangan itu tidak berlangsung lama ketika kelompok bersenjata mulai memburunya.\r\n\r\nTernyata Ishmael memiliki masa lalu kelam sebagai bagian dari organisasi kriminal kejam yang dipimpin oleh Lee. Seiring ingatannya perlahan kembali, Ishmael terpaksa menghadapi orang-orang dari masa lalunya yang kini ingin menghabisinya. Film ini menyajikan aksi pertarungan brutal, pencarian jati diri, dan konflik batin antara memilih masa lalu atau melindungi masa depan yang baru.\r\n', 0.0),
(28, 'The Big 4', '2h 21m', 'Action', 'm17.jpg', 1, '<p>Film ini mengikuti kisah Dina, seorang detektif muda yang disiplin dan berprinsip, yang terkejut saat mengetahui bahwa ayahnya adalah pemimpin dari kelompok pembunuh bayaran terkenal bernama The Big 4. Setelah kematian ayahnya, Dina bertekad menyelidiki lebih jauh dan akhirnya terlibat dalam petualangan bersama empat mantan anak buah ayahnya: Topan, Alpha, Jenggo, dan Pelor. Mereka semua memiliki gaya bertarung dan kepribadian unik yang sering bertentangan satu sama lain.</p>\r\n\r\n<p>Perjalanan mereka tidak hanya penuh aksi dan pertarungan sengit, tapi juga dibumbui humor dan kekacauan akibat perbedaan karakter. Bersama-sama, mereka harus menghadapi musuh berbahaya dari masa lalu yang menjadi ancaman bagi semua pihak. Dina perlahan mulai memahami siapa sebenarnya ayahnya dan apa makna keadilan yang lebih luas. Film ini memadukan aksi, komedi, dan drama keluarga dalam satu paket hiburan seru.</p>\r\n', 0.0),
(29, 'Uncarted', '1h 58m', 'Action', 'm18.jpg', 1, '<p>Film ini mengikuti petualangan Nathan Drake, seorang pemburu harta karun muda yang cerdas dan penuh semangat. Nathan bergabung dengan Victor &quot;Sully&quot; Sullivan, mentor dan partnernya, dalam pencarian harta karun legendaris yang pernah dicari oleh ayah Nathan. Perjalanan mereka penuh dengan teka-teki, jebakan berbahaya, dan konflik dengan kelompok kriminal yang juga mengincar harta tersebut.</p>\r\n\r\n<p>Selama petualangan, Nathan harus mengandalkan kecerdikan dan keberaniannya untuk menghadapi berbagai rintangan serta mengungkap misteri masa lalu keluarganya. Film ini menggabungkan unsur aksi, petualangan, dan humor dalam cerita yang seru dan penuh ketegangan.</p>\r\n', 0.0),
(30, 'AGAK LAEN', '1h 56m', 'Comedy', 'm19.jpg', 1, '<p>Film ini menceritakan Nathan Drake, seorang petualang dan pencari harta yang selalu mencari misteri baru. Bersama mentor sekaligus rekannya, Sully, Nathan berusaha menemukan harta karun legendaris yang tersembunyi, mengikuti jejak ayahnya yang juga seorang pemburu harta. Dalam perjalanan ini, mereka harus menghadapi berbagai bahaya, mulai dari jebakan kuno sampai musuh yang tidak segan-segan menghalangi.</p>\r\n\r\n<p>Petualangan mereka penuh dengan ketegangan dan aksi menegangkan, tapi juga dibalut dengan kekocakan dan keakraban antara Nathan dan Sully. Film ini mengajak penonton untuk ikut merasakan serunya pencarian harta sekaligus mengungkap rahasia masa lalu yang selama ini tersembunyi.</p>\r\n', 0.0),
(31, 'Jumanji: Welcome to the Jungle', '1h 59m', 'Comedy', 'm20.jpg', 1, '<p>Film ini bercerita tentang empat remaja yang menemukan sebuah konsol permainan video tua dan secara ajaib tersedot ke dalam dunia permainan Jumanji. Mereka berubah menjadi karakter avatar dengan keahlian dan kekuatan unik yang harus mereka gunakan untuk bertahan hidup dan menyelesaikan misi dalam dunia hutan yang penuh bahaya.</p>\r\n\r\n<p>Dalam petualangan ini, mereka harus bekerja sama menghadapi berbagai rintangan dan makhluk liar sambil belajar tentang pentingnya persahabatan dan keberanian. Film ini penuh dengan aksi seru, humor, dan pesan positif tentang bagaimana menghadapi tantangan hidup dengan kerja sama dan percaya diri.</p>\r\n', 4.0),
(32, 'Cek Toko Sebelah', '1h 40m', 'Comedy', 'm21.jpg', 1, '<p>Film ini mengisahkan Erwin, seorang pria muda lulusan luar negeri yang sukses berkarier di perusahaan ternama. Namun, hidupnya berubah ketika ayahnya, Koh Afuk, yang memiliki toko kelontong, meminta Erwin untuk menggantikan posisinya. Erwin merasa terjebak antara ambisinya dan harapan keluarganya, terutama sang ayah yang ingin mewariskan toko tersebut kepadanya. Sementara itu, Yohan, kakak Erwin, merasa tersisih dan kecewa karena tidak dipercaya untuk meneruskan usaha keluarga.</p>\r\n\r\n<p>Konflik keluarga semakin memuncak ketika Erwin harus menghadapi kenyataan bahwa ia harus memilih antara karier impiannya dan tanggung jawab terhadap keluarga. Film ini menyajikan kisah tentang dinamika keluarga, perbedaan generasi, dan perjuangan individu dalam menghadapi ekspektasi orang tua, dibalut dengan humor khas Ernest Prakasa.</p>\r\n', 0.0),
(33, 'Ngeri-Ngeri Sedap', '1h 54m', 'Comedy', 'm22.jpeg', 1, '<p>Film ini berkisah tentang tiga bersaudara dari keluarga Batak yang tinggal di Jakarta dan sering mengalami konflik karena perbedaan pandangan dan gaya hidup. Ketegangan keluarga semakin terasa ketika ayah mereka tiba-tiba jatuh sakit, memaksa mereka untuk berkumpul kembali dan menghadapi masalah yang selama ini dihindari. Lewat momen ini, mereka belajar arti penting keluarga dan saling memahami satu sama lain.</p>\r\n\r\n<p>Cerita ini menggabungkan unsur komedi dan drama keluarga dengan nuansa budaya Batak yang kental. Film ini mengajak penonton tertawa sekaligus merenung tentang nilai kekeluargaan, toleransi, dan bagaimana cara menghadapi perbedaan dalam keluarga.</p>\r\n', 5.0),
(34, 'Midnight Runners', '1h 49m', 'Comedy', 'm23.jpg', 1, '<p>Film ini mengikuti kisah dua mahasiswa Akademi Kepolisian Nasional Korea, Ki-joon dan Hee-yeol, yang menjadi sahabat meskipun memiliki kepribadian yang berbeda. Suatu malam, mereka menyaksikan penculikan seorang wanita dan melaporkannya ke polisi. Namun, karena kasus lain yang lebih besar, penyelidikan dihentikan. Merasa tidak puas, mereka memutuskan untuk menyelidiki sendiri dan menemukan bahwa penculikan tersebut terkait dengan perdagangan organ dan eksploitasi wanita. Meskipun masih mahasiswa, mereka berani menghadapi bahaya demi menegakkan keadilan. Film ini menggabungkan aksi, komedi, dan drama dengan tema persahabatan dan keberanian.</p>\r\n', 0.0),
(35, 'Mendarat Darurat', '1h 53m', 'Comedy', 'm24.jpeg', 1, '<p>Film ini mengisahkan Glenn, seorang pria yang merasa terjebak dalam rutinitas rumah tangga yang membosankan dengan istrinya, Maya. Setelah sering dituduh berselingkuh tanpa bukti, Glenn akhirnya benar-benar berselingkuh dengan Kania, seorang rekan kerja. Ketika sedang bersama Kania di hotel, Glenn mendengar kabar bahwa pesawat yang seharusnya ia tumpangi mengalami kecelakaan dan semua penumpangnya meninggal dunia. Glenn yang semula berniat berselingkuh kini harus menghadapi dilema besar: bagaimana menghadapinya jika ia dianggap sudah meninggal? Film ini menyajikan kisah tentang kebohongan, dilema moral, dan konsekuensi dari tindakan yang diambil.</p>\r\n', 0.0),
(36, 'Mission: Possible', '1h 45m', 'Comedy', 'm25.jpg', 1, '<p>Film ini mengisahkan Yoo Da-hee, seorang agen rahasia Tiongkok yang ditugaskan untuk menyelidiki kasus penyelundupan senjata ilegal ke Korea Selatan. Dalam misinya, ia secara tidak sengaja bertemu dengan Woo Soo-han, seorang detektif swasta yang kurang berpengalaman namun memiliki naluri tajam. Keduanya bekerja sama untuk mengungkap jaringan penyelundupan tersebut, meskipun sering kali terlibat dalam situasi kocak dan penuh kekacauan. Seiring berjalannya waktu, mereka harus menghadapi berbagai tantangan dan musuh yang semakin berbahaya. Film ini memadukan elemen aksi dan komedi dengan alur cerita yang seru dan menghibur.</p>\r\n', 0.0),
(37, 'KKN di Desa Penari', '2h 10m', 'Horror', 'm26.jpg', 1, '<p>Film ini diangkat dari cerita viral karya SimpleMan di Twitter, mengisahkan enam mahasiswa yang melaksanakan Kuliah Kerja Nyata (KKN) di sebuah desa terpencil di Jawa Timur. Mereka tinggal di rumah kepala desa, Pak Prabu, yang memperingatkan mereka untuk tidak melewati gerbang terlarang menuju hutan Tapak Tilas. Namun, rasa penasaran membawa mereka melanggar larangan tersebut, memicu serangkaian kejadian mistis yang mengancam nyawa mereka. Teror dari makhluk halus, khususnya sosok penari gaib bernama Badarawuhi, semakin intens seiring berjalannya waktu. Film ini menyoroti konflik internal kelompok, pelanggaran tabu, dan konsekuensi dari ketidaktahuan mereka terhadap adat dan kepercayaan lokal.</p>\r\n', 5.0),
(38, 'The Conjuring 2: The Enfield Poltergeist', '2h 13m', 'Horror', 'm27.jpg', 1, '<p>Film ini mengisahkan pasangan penyelidik paranormal Ed dan Lorraine Warren yang melakukan perjalanan ke Enfield, London, pada tahun 1977 untuk membantu keluarga Hodgson yang mengalami aktivitas poltergeist di rumah mereka. Kejadian aneh mulai terjadi setelah putri bungsu mereka, Janet, bermain dengan papan Ouija. Janet kemudian menunjukkan gejala kepemilikan oleh roh seorang pria tua bernama Bill Wilkins, yang sebelumnya tinggal dan meninggal di rumah tersebut. Ed dan Lorraine berusaha membuktikan apakah kejadian tersebut nyata atau hanya rekayasa, sambil menghadapi ancaman dari entitas jahat yang mengganggu keluarga tersebut.</p>\r\n', 0.0),
(39, 'Asih', '1h 17m', 'Horror', 'm28.jpg', 1, '<p>Film ini mengisahkan Ita, seorang wanita hamil tua yang tinggal bersama suaminya, Andi, di sekitar Kota Bandung. Setelah kelahiran prematur anak mereka, Puspita, keluarga ini mulai mengalami kejadian-kejadian aneh. Teror semakin intens ketika Puspita tumbuh dewasa dan menjadi ibu dari Amelia. Kehadiran Asih, sosok gaib yang memiliki hubungan dengan masa lalu kelam keluarga mereka, membawa ancaman besar bagi Puspita dan anaknya. Film ini mengungkap kisah tragis Asih, seorang wanita yang diusir oleh keluarganya dan masyarakat karena kehamilan di luar nikah, yang berujung pada bunuh diri dan menjelma menjadi hantu yang mengganggu.</p>\r\n', 0.0),
(40, 'A Quiet Place', '1h 30m', 'Horror', 'm29.jpg', 1, '<p>Film ini berlatar dunia pasca-apokaliptik di mana makhluk asing buta dengan pendengaran sangat tajam memburu manusia berdasarkan suara. Keluarga Abbott&mdash;Lee, Evelyn, dan dua anak mereka, Regan dan Marcus&mdash;berusaha bertahan hidup di sebuah peternakan terpencil di New York. Mereka berkomunikasi menggunakan bahasa isyarat Amerika (ASL) dan menghindari suara sekecil apa pun untuk menghindari perhatian makhluk tersebut. Ketika Evelyn hamil dan bersiap melahirkan, tantangan mereka semakin besar karena kelahiran bayi di dunia yang sunyi penuh ancaman.</p>\r\n\r\n<p>Film ini menonjolkan ketegangan yang dibangun melalui minimnya dialog, memanfaatkan keheningan untuk menciptakan atmosfer yang mencekam. Penampilan Emily Blunt dan John Krasinski sebagai pasangan suami-istri yang berjuang demi keluarga mereka sangat kuat, sementara Millicent Simmonds, yang memerankan Regan, memberikan kedalaman emosional dengan menggambarkan seorang remaja tuli yang merasa terisolasi namun berperan penting dalam kelangsungan hidup keluarga.</p>\r\n', 0.0),
(41, 'The 8th Night', '1h 55', 'Horror', 'm30.jpg', 1, '<p>Film ini mengisahkan perjuangan seorang mantan biksu, Park Jin-soo, yang berusaha mencegah kebangkitan dua entitas jahat kuno yang telah terkurung selama 2.500 tahun. Kedua entitas tersebut, yang dikenal sebagai Mata Merah dan Mata Hitam, memiliki kekuatan besar dan dapat membawa kehancuran jika bersatu kembali. Jin-soo bekerja sama dengan seorang biksu muda, Cheong-seok, dan seorang detektif bernama Kim Ho-tae untuk menghentikan proses kebangkitan ini. Mereka harus menemukan dan menghentikan seorang shaman perawan yang menjadi kunci dalam ritual tersebut.</p>\r\n\r\n<p>Sepanjang perjalanan mereka, terungkap bahwa Profesor Kim Joon-cheol, yang sebelumnya dianggap sebagai ilmuwan terkemuka, ternyata memiliki niat tersembunyi untuk membangkitkan entitas-entitas tersebut demi tujuan pribadi. Konflik batin dan pengorbanan menjadi tema sentral dalam film ini, di mana para karakter harus menghadapi kenyataan pahit dan membuat keputusan sulit untuk menyelamatkan umat manusia dari kehancuran.</p>\r\n', 0.0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_general_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(7, 'lala', 'lalalala123@gmail.com', 'lala123', 'user', '2025-05-31 19:07:59'),
(8, 'kaka', 'kaka1000@gmail.com', '234', 'user', '2025-05-31 19:07:59'),
(10, 'ros', 'ros123@gmail.com', 'ros123', 'user', '2025-05-31 22:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_ratings`
--

CREATE TABLE `user_ratings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `film_id` int NOT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_ratings`
--

INSERT INTO `user_ratings` (`id`, `user_id`, `film_id`, `rating`, `created_at`) VALUES
(2, 10, 11, 4, '2025-06-01 12:26:05'),
(3, 10, 1, 4, '2025-06-01 12:56:41'),
(4, 10, 2, 4, '2025-06-02 04:17:34'),
(5, 10, 6, 5, '2025-06-02 13:55:18'),
(6, 10, 31, 4, '2025-06-02 13:55:39'),
(7, 10, 22, 5, '2025-06-02 13:55:57'),
(8, 10, 8, 3, '2025-06-02 13:56:14'),
(9, 10, 7, 5, '2025-06-02 13:58:24'),
(10, 10, 37, 5, '2025-06-02 14:03:45'),
(11, 10, 33, 5, '2025-06-02 14:04:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `film_id` (`film_id`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `film_id` (`film_id`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `film_id` (`film_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_ratings`
--
ALTER TABLE `user_ratings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`);

--
-- Constraints for table `discussions`
--
ALTER TABLE `discussions`
  ADD CONSTRAINT `discussions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `discussions_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`);

--
-- Constraints for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD CONSTRAINT `user_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_ratings_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
