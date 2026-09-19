  <?= $this->extend('layout/backend') ?>


  <?= $this->section('content') ?>

  <section class="section">
      <div class="section-header">
          <!-- <h1>Blank Page</h1> -->
          <a href="<?= site_url('akun1/new') ?>" class="btn btn-primary">Add New</a>
      </div>

      <!-- untuk menangkap session success dengan bawaan with -->
      <?php if (session()->getFlashdata('success')) : ?>
          <div class="alert alert-success alert-dismissible show fade">
              <div class="alert-body">
                  <button class="close" data-dismiss="alert"> X </button>
                  <?= session()->getFlashdata('success'); ?>
              </div>
          </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')) : ?>
          <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                  <button class="close" data-dismiss="alert"> X </button>
                  <?= session()->getFlashdata('error'); ?>
              </div>
          </div>
      <?php endif; ?>

      <div class="section-body">
          <!-- dinamis -->

          <div class="card">
              <div class="card-header">
                  <h4>Data Akun 1</h4>
              </div>
              <div class="card-body p-0">
                  <div class="table-responsive">
                      <table class="table table-striped table-md">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode Akun 1</th>
                                  <th>Nama Akun</th>
                                  <th class="text-center" style="width: 20%">Action</th>
                                  </th class=>
                              </tr>
                          <tbody>
                              <?php /** @var array $dtakun1 */
                                //biar dtakun1 ga error kata gemini// 
                                ?>
                              <?php foreach ($dtakun1 as $key => $value) : ?>
                                  <tr>
                                      <td><?= $key + 1 ?></td>
                                      <td><?= $value->kode_akun1 ?></td>
                                      <td><?= $value->nama_akun1 ?></td>
                                      <td class="text-center" style="width:15%">
                                          <a href="" class="btn btn-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                                          <a href="" class="btn btn-danger"><i class="fas fa-trash btn-small"></i> Del</a>

                                      </td>
                                  </tr>

                              <?php endforeach; ?>
                          </tbody>

                      </table>
                  </div>
              </div>
          </div>
      </div>

  </section>

  <?= $this->endSection(); ?>