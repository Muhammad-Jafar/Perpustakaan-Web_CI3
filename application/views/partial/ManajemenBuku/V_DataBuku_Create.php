
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card shadow">
            <div class="card-body">
              <h3 class="card-title"><?=$title_page;?></h3>
              <?php if($this->session->flashdata('msg_alert')) { ?>

              <div class="col-md-6">
                <div class="alert alert-info">
                  <label style="font-size: 13px;"><?=$this->session->flashdata('msg_alert');?></label>
                </div>
              </div>

              <?php } ?>
              <?=form_open_multipart('buku/add_new/data_buku', array('method'=>'post'));?>

                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kode Buku</label>
                        <div class="col-sm-9">
                          <input type="text" name="kode_buku" value="<?= $kode_buku; ?>" readonly class="form-control" placeholder="Contoh : BUKU-00001 "/>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Kategori Buku</label>
                      <div class="col-sm-5">
                        <select name="kategori_buku" class="form-control">
                            <option disabled selected>Pilih kategori Buku</option>
                            <option value="Teks-pelajaran">Buku teks pelajaran</option>
                            <option value="Non Teks-pelajaran">Buku non teks pelajaran</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Jenis Buku</label>
                      <div class="col-sm-5">
                        <select name="id_jenis_buku" class="form-control">
                            <option disabled selected>Pilih Jenis Buku</option>
                              <?php foreach($klasifikasi_buku as $kb) { ?>
                                <option value="<?=$kb->id_jenis_buku;?>"> <?=$kb->jenis_buku;?></option>
                              <?php } ?>
                          </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Judul Buku</label>
                      <div class="col-sm-9">
                        <input type="text" name="judul_buku" class="form-control" placeholder="Contoh : Pengantar Fisika Edisi ke 5 Cetakan ke 2 Untuk Kelas XII "/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Pengarang</label>
                      <div class="col-sm-9">
                        <input type="text" name="pengarang" class="form-control" placeholder="Harry Potter"/>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Penerbit</label>
                      <div class="col-sm-9">
                        <input type="text" name="penerbit" class="form-control" placeholder="Gramedia"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Tahun terbit</label>
                      <div class="col-sm-9">
                        <input type="number" name="tahun_terbit" class="form-control" placeholder="Contoh : 2022" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Jumlah halaman buku</label>
                      <div class="col-sm-9">
                        <input type="number" name="jumlah_halaman" class="form-control" placeholder="Contoh : 210, artinya 210 lembar"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Stok buku</label>
                      <div class="col-sm-9">
                        <input type="number" name="qt" class="form-control" placeholder="Contoh : 10, artinya ada 10 paket buku"/>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group row" style="justify-content:right; margin-right: auto; margin-top: 10px;">
                      <button class="btn btn-warning mr-2 mdi mdi-arrow-left" type="button" onclick="javascript:top.location.href='<?=base_url("buku/data_buku"); ?>';"> Kembali</button>
                      <button type="submit" class="btn btn-success mr-2">Tambah data</button>
                      <button class="btn btn-light" type="reset">Hapus</button>
                    </div>
                  </div>
                </div>

                <?=form_close();?>
            </div>
          </div>
        </div>
    </div>
  </div>