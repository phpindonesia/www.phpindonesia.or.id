Git workflow untuk para kontributor
===================================

Bagi kawan-kawan yang ingin berpartisipasi dalam pengembangan aplikasi ini dapat mengikuti langkah-langkah berikut.

# Mulai Berpartisipasi #

### 1. [Fork](http://help.github.com/fork-a-repo/) repository aplikasi yang di github ke repository anda sendiri. Setelah itu `clone` repository tersebut.

```
$ git clone https://github.com/YOURUSERNAME/phpindonesia.or.id-profile.git
```

Jika ada masalah setup GIT untuk GitHub di Linux, atau ada error seperti "Permission Denied (publickey)", silakan setup [GIT anda agar dapat bekerja dengan GitHub](http://help.github.com/linux-set-up-git/).

### 2. Tambahkan repository utama sebagai additional git remote dengan nama "upstream".

```
$ git remote add upstream https://github.com/phpindonesia/phpindonesia.or.id-profile.git
```

### 3. Dapatkan code terbaru dari repository utama.

```
$ git fetch upstream
```

Ini harus anda lakukan tiap kali akan berkontribusi untuk memastikan anda bekerja dengan kode terakhir.

### 4. Membuat `branch` baru berdasarkan master branch.

```
$ git checkout upstream/master
$ git checkout -b 999-name-of-branch
```

### 5. Tulis kode anda.

Lakukan yang terbaik. Perbaiki issue yang ada. Tambahkan fitur dan lain-lain.

Pastikan kode anda bekerja dengan benar sebelum menguploadnya :grinning:.

Dan yang tidak kalah penting, lakukan perbaikan di line-line code yang berhubungan dengan perbaikan saja,
agar apa yang anda lakukan dapat langsung di lihat oleh orang lain, jangan melakukan perubahan dari awal file 
sampai akhir file, termasuk membenahi spaci dan lain-lain, ini akan membingungkan dan menghambat pull reguest anda untuk di setujui.

### 6. Update CHANGELOG.

Edit file CHANGELOG.md untuk memasukkan perubahan anda. Sisipkan baris pada CHANGELOG sesuai dengan perubahan yang anda lakukan. Baris yang anda masukkan harus berbentuk seperti

```
Bug #999: a description of the bug fix (Your Name)
Enh #999: a description of the enhancement (Your Name)
```

 #999 adalah nomor issue anda.

### 7. Commit.

tambahkan files/perubahan anda yang ingin dicomit ke [staging area](http://gitref.org/basic/#add) dengan

```
$ git add path/to/my/file.php
```

Anda bisa menggunakan opsi -p untuk memilih perubahan yang ingin dicommit.

Commit perubahan anda dengan deskripsi yang jelas. Anda bisa menambahkan nomor issue anda dengan format #XXX. GitHub akan otomatis menglinkkan commit anda dengan issue tersebut:

```
$ git commit -m "A brief description of this change which fixes #42 goes here";
```

> Di netbeans dapat dilakukan dengan mudah dengan `klik kanan` -> `git` -> `commit`.

### 8. Pull code terakhir dari repository utama ke branch anda.

```
$ git pull upstream master
```

sekali lagi untuk memastikan anda bekerja dengan code terakhir.

### 9. Push code anda ke GitHub.

```
$ git push -u origin 999-name-of-branch
```

### 10. Buat [pull request](http://help.github.com/send-pull-requests/).

Masuk ke repository anda di GitHub kemudian klik `Pull Request`. Pilih branch dan tambahkan detail di comment. Untuk menghubungkan "pull request" dengan issue, tambahkan di comment nomor issue tersebut dengan format #999.

> Satu "pull request" harusnya hanya untuk satu perubahan.

### 11. Seseorang akan mereview code anda.

Seseorang akan mereview code anda. Menanyakan sesuatu, meminta perubahan dan lain-lain. Lakukan langkah 5 (anda tidak perlu membuat "pull request" yang baru). Jika code anda diterima, ia akan dimerge dan menjadi bagian dari phpindonesia.or.id-profile. Jika ditolak, jangan berkecil hati, tiap orang punya pertimbangannya masing-masing :D.

### 12. Bersihkan.

Jika sudah selesai, baik karena diterima maupun ditolak. Bersihkan repository local anda.

```
$ git checkout master
$ git branch -D 999-name-of-branch
$ git push origin --delete 999-name-of-branch
```

### 13. Terima Kasih.


# Ringkasan #

```
$ git clone https://github.com/YOURUSERNAME/phpindonesia.or.id-profile.git phpindonesia-profile
$ cd phpindonesia-profile
$ git remote add upstream git://github.com/phpindonesia/phpindonesia.or.id-profile.git

$ git fetch upstream
$ git checkout upstream/master
$ git checkout -b 999-name-of-branch

$ git add path/to/my/file.php
$ git commit -m "A brief description of this change which fixes #42 goes here";
$ git pull upstream master
$ git push -u origin 999-name-of-branch

$ git checkout master
$ git branch -D 999-name-of-your-branch-goes-here
$ git push origin --delete 999-name-of-your-branch-goes-here
```