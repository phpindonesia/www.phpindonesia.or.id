# phpindonesia.or.id-profile
Website Resmi PHP Indonesia Community

### Cara pemasangan pada localhost untuk proses development

1. Buat database baru (mysql)
2. Import database dengan file phpindonesia.sql
3. Konfigurasi pada server local untuk mengaktifkan mod_rewrite
4.  Edit file konfigurasi pada po-library/po-config.php

```php
$db['host']		= "localhost";
$db['sock']		= "";
$db['port']		= "";
$db['user']		= "root";
$db['passwd']	= "";
$db['db']		= "phpindonesia";
```

5. Untuk login ke administrator, tambahkan **/po-adminboard** di akhir url
6. Untul data login sementara :

```
Username : admweb
Password : phpindo_888
```

7. Untuk proses development baca dokomentasi di sini : http://docs.popojicms.org

---

Beberapa content masih dalam tahap development dan pengumpulan data
