

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
            <dt scope="row"><?= __('Title') ?></dt>
            <dd><?= h($service->title) ?></dd>
            <dt scope="row"><?= __('Service Category') ?></dt>
            <dd><?= $service->has('service_category') ? $this->Html->link($service->service_category->name, ['controller' => 'ServiceCategories', 'action' => 'view', $service->service_category->id]) : '' ?></dd>
            <dt scope="row"><?= __('Service Subcategory') ?></dt>
            <dd><?= $service->has('service_subcategory') ? $this->Html->link($service->service_subcategory->name, ['controller' => 'ServiceSubcategories', 'action' => 'view', $service->service_subcategory->id]) : '' ?></dd>
            <dt scope="row"><?= __('Service Provider') ?></dt>
            <dd><?= $service->has('service_provider') ? $this->Html->link($service->service_provider->name, ['controller' => 'ServiceProviders', 'action' => 'view', $service->service_provider->id]) : '' ?></dd>
            <dt scope="row"><?= __('Price Unit') ?></dt>
            <dd><?= h($service->price_unit) ?></dd>
            <dt scope="row"><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($service->id) ?></dd>
            <dt scope="row"><?= __('Price') ?></dt>
            <dd><?= $this->Number->format($service->price) ?></dd>
            <dt scope="row"><?= __('Created') ?></dt>
            <dd><?= h($service->created) ?></dd>
            <dt scope="row"><?= __('Modified') ?></dt>
            <dd><?= h($service->modified) ?></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card card-solid">
        <div class="card-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="card-title"><?= __('Description') ?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?= $this->Text->autoParagraph($service->description); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card card-solid">
        <div class="card-header with-border">
          <i class="fa fa-share-alt"></i>
          <h3 class="card-title"><?= __('Reviews') ?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <?php if (!empty($service->reviews)): ?>
          <table class="table table-hover">
              <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('User Id') ?></th>
                    <th scope="col"><?= __('Service Id') ?></th>
                    <th scope="col"><?= __('Rating') ?></th>
                    <th scope="col"><?= __('Comment') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
              <?php foreach ($service->reviews as $reviews): ?>
              <tr>
                    <td><?= h($reviews->id) ?></td>
                    <td><?= h($reviews->user_id) ?></td>
                    <td><?= h($reviews->service_id) ?></td>
                    <td><?= h($reviews->rating) ?></td>
                    <td><?= h($reviews->comment) ?></td>
                    <td><?= h($reviews->created) ?></td>
                    <td><?= h($reviews->modified) ?></td>
                      <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['controller' => 'Reviews', 'action' => 'view', $reviews->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['controller' => 'Reviews', 'action' => 'edit', $reviews->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reviews', 'action' => 'delete', $reviews->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reviews->id), 'class'=>'btn btn-danger btn-xs']) ?>
                  </td>
              </tr>
              <?php endforeach; ?>
          </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
