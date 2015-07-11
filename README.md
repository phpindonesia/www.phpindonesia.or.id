# phpindonesia.or.id-profile
Website Resmi PHP Indonesia Community

### Cara pemasangan pada localhost untuk proses development :

1. Buat database baru (mysql)
2. Import database dengan file phpindonesia.sql
3. Konfigurasi pada server local untuk mengaktifkan mod_rewrite
4. Edit file konfigurasi pada po-library/po-config.php

	```php
	$db['host']		= "localhost";
	$db['sock']		= "";
	$db['port']		= "5432";
	$db['user']		= "postgres";
	$db['passwd']	= "postgre";
	$db['db']		= "phpindonesia";
	```

5. Untuk login ke administrator, tambahkan **/po-adminboard** di akhir url
6. Untul data login sementara :

	```
	Username : admweb
	Password : phpindo_888
	```

7. Login ke po-adminboard kemudian masuk ke menu setting/pengaturan lalu sesuaikan **Web Url** dengan url yg aktif. Ingat di belakang url tidak boleh ada tanda "/"

8. Untuk proses development baca dokomentasi di sini : http://docs.popojicms.org

9. Untuk cara kerja github baca di sini : https://github.com/phpindonesia/phpindonesia.or.id-profile/blob/master/git-workflow.md
---

Beberapa content masih dalam tahap development dan pengumpulan data

---

**Changelog** :

* 11 Juli 2015 : Pergantian database dari mysql ke postgresql serta penyempurnaan fitur lainnya.
* 9 Juli 2015 : Menambahkan git-workflow.md dan update README.md.
* 8 Juli 2015 : Core awal untuk menjadi role model.
