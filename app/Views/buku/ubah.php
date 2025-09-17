<?= $this->extend('layout/template');?>
<?= $this->section('content');?>
<div class= "container">
    <div class= "col">
        <h3 class="mt-2">Form Ubah Buku</h3>
        <form action="/buku/update/<?= $buku['id_buku']?>" method="post" class="mt-4" enctype="multipart/form-data">
            <?= csrf_field();?>
            <input type="hidden" name="sampulLama" value="<?= $buku['sampul']?>">
            <div class="form-group row">
                <label for="inputJudul" class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'isInvalid' : '';?>" name="judul" value="<?= (old('judul')) ? old('judul') : $buku['judul']?>" required>
                    <div class= "invalid-feedback">
                        <?= $validation->getError('judul');?>
                    </div>  
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPengarang" class="col-sm-2 col-form-label">Pengarang</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="pengarang" value="<?= (old('pengarang')) ? old('pengarang') : $buku['pengarang']?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPenerbit" class="col-sm-2 col-form-label">Penerbit</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="penerbit" value="<?= (old('penerbit')) ? old('penerbit') : $buku['penerbit']?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputTahunterbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tahun_terbit" value="<?= (old('tahun_terbit')) ? old('tahun_terbit') : $buku['tahun_terbit']?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputSampul" class="col-sm-2 col-form-label">Sampul</label>
                <div class="col-sm-4">
                    <div class= "custom-file">
                        <input type="file" name="sampul" class="form-control <?= ($validation->hasError('sampul')) ? 'is-invalid' : '';?>">
                        <div class= "invalid-feedback">
                            <?= $validation->getError('sampul');?>
                        </div>
                        <label class="custom-file-label" for="customFile" hidden>Choose File</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endsection();?>