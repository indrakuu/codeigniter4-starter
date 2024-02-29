<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<div class="container-fluid">
  <div class="row">
    <!-- Column -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-hover">
        <div class="box bg-cyan text-center">
          <h1 class="font-light text-white">
            <i class="fas fa-fire"></i>
          </h1>
          <h6 class="text-white">Dashboard</h6>
        </div>
      </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-hover">
        <div class="box bg-success text-center">
          <h1 class="font-light text-white">
            <i class="fas fa-chart-line"></i>
          </h1>
          <h6 class="text-white">Charts</h6>
        </div>
      </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-hover">
        <div class="box bg-warning text-center">
          <h1 class="font-light text-white">
            <i class="fas fa-columns"></i>
          </h1>
          <h6 class="text-white">Widgets</h6>
        </div>
      </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-hover">
        <div class="box bg-danger text-center">
          <h1 class="font-light text-white">
            <i class="fas fa-table"></i>
          </h1>
          <h6 class="text-white">Tables</h6>
        </div>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>