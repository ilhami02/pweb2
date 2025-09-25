<?= $this->extend('layout/template');?>
<?= $this->section('content');?>
<div class="container">
    <div class="row">
        <div class= "col">
            <h1>Daftar Buku</h1>
            <form action="/buku/cari" method="post">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Masukan pencarian data buku" name="cari">
                  <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                </div>
            </form>
            <?php if(session()->getFlashdata('pesan')) : ?>
                <div class= "alert alert-success" role="alert">
                    <?= session()->getFLashdata('pesan');?>
                </div>
            <?php endif?>
            <a href="/buku/tambah" class="btn btn-primary">Tambah Data Buku</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $i = 1 + (2*($current-1));
                    foreach($buku as $b):
                    ?>
                    <tr>
                        <th scope="row"><?= $i++?></th>
                        <td><img src="/img/<?= $b['sampul']?>" alt="" width="100"></td>
                        <td><?= $b['judul']?></td>
                        <td><a href="/buku/<?= $b['id_buku']?>" class="btn btn-success">Detail</td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?= $pager->links('buku', 'page_buku');?>
        <?= $this->endsection()?>