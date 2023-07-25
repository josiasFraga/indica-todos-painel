

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
            <dd><?= $this->Number->format($serviceSubcategory->id) ?></dd>
            <dt scope="row"><?= __('Name') ?></dt>
            <dd><?= h($serviceSubcategory->name) ?></dd>
            <dt scope="row"><?= __('Service Category') ?></dt>
            <dd><?= $serviceSubcategory->has('service_category') ? $this->Html->link($serviceSubcategory->service_category->name, ['controller' => 'ServiceCategories', 'action' => 'view', $serviceSubcategory->service_category->id]) : '' ?></dd>
            <dt scope="row"><?= __('Created') ?></dt>
            <dd><?= h($serviceSubcategory->created) ?></dd>
            <dt scope="row"><?= __('Modified') ?></dt>
            <dd><?= h($serviceSubcategory->modified) ?></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

</section>
