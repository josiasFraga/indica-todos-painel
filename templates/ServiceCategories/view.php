

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-solid">
        <div class="card-header with-border">
          <i class="fa fa-info"></i>
          <h3 class="card-title"><?php echo __('Information'); ?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <dl class="dl-horizontal">
            <dt scope="row"><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($serviceCategory->id) ?></dd>
            <dt scope="row"><?= __('Name') ?></dt>
            <dd><?= h($serviceCategory->name) ?></dd>
            <dt scope="row"><?= __('Image') ?></dt>
            <dd><img src="<?= h($serviceCategory->image) ?>" width="200px" /></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

</section>
