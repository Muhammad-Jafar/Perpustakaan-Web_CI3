
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card shadow">
            <div class="card-body">

              <h4 class="card-title"><?=$title_page;?></h4>
              <?php if($this->session->flashdata('msg_alert')) : ?>
                <div class="alert alert-info">
                  <label style="font-size: 14px;"><?=$this->session->flashdata('msg_alert');?></label>
                </div>
              <?php endif; ?>
              
              <!-- TABEL KATALOG BUKU DISINI -->
              <div class="table-responsive">
                <p> <table class="data table table-striped" cellspacing="0" width="100%"></table> </p>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>