

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
            <dd><?= $this->Number->format($serviceProvider->id) ?></dd>
            <dt scope="row"><?= __('Name') ?></dt>
            <dd><?= h($serviceProvider->name) ?></dd>
            <dt scope="row"><?= __('Email') ?></dt>
            <dd><?= h($serviceProvider->email) ?></dd>
            <dt scope="row"><?= __('Phone') ?></dt>
            <dd><?= h($serviceProvider->phone) ?></dd>
            <dt scope="row"><?= __('Address') ?></dt>
            <dd><?= h($serviceProvider->address) ?></dd>
            <dt scope="row"><?= __('Address Complement') ?></dt>
            <dd><?= h($serviceProvider->address_complement) ?></dd>
            <dt scope="row"><?= __('City') ?></dt>
            <dd><?= h($serviceProvider->city) ?></dd>
            <dt scope="row"><?= __('State') ?></dt>
            <dd><?= h($serviceProvider->state) ?></dd>
            <dt scope="row"><?= __('Postal Code') ?></dt>
            <dd><?= h($serviceProvider->postal_code) ?></dd>
            <dt scope="row"><?= __('Neighborhood') ?></dt>
            <dd><?= h($serviceProvider->neighborhood) ?></dd>
            <dt scope="row"><?= __('Active Signature') ?></dt>
            <dd><?= h($serviceProvider->active_signature) ?></dd>
            <dt scope="row"><?= __('Signature Status') ?></dt>
            <dd><?= h($serviceProvider->signature_status) ?></dd>
            <dt scope="row"><?= __('Address Number') ?></dt>
            <dd><?= $this->Number->format($serviceProvider->address_number) ?></dd>
            <dt scope="row"><?= __('Created') ?></dt>
            <dd><?= h($serviceProvider->created) ?></dd>
            <dt scope="row"><?= __('Modified') ?></dt>
            <dd><?= h($serviceProvider->modified) ?></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card card-solid">
        <div class="card-header with-border">
          <i class="fa fa-share-alt"></i>
          <h3 class="card-title"><?= __('Services') ?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <?php if (!empty($serviceProvider->services)): ?>
          <table class="table table-hover">
              <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Title') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Category Id') ?></th>
                    <th scope="col"><?= __('Subcategory Id') ?></th>
                    <th scope="col"><?= __('Price') ?></th>
                    <th scope="col"><?= __('Price Unit') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
              <?php foreach ($serviceProvider->services as $services): ?>
              <tr>
                    <td><?= h($services->id) ?></td>
                    <td><?= h($services->title) ?></td>
                    <td><?= h($services->description) ?></td>
                    <td><?= h($services->service_category->name) ?></td>
                    <td><?= h($services->service_subcategory->name) ?></td>
                    <td><?= h($services->price) ?></td>
                    <td><?= h($services->price_unit) ?></td>
                    <td><?= h($services->created) ?></td>
                    <td><?= h($services->modified) ?></td>
                      <td class="actions text-center">
                      <?= $this->Html->link(__('Edit'), ['controller' => 'Services', 'action' => 'edit', $services->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['controller' => 'Services', 'action' => 'delete', $services->id], ['confirm' => __('Are you sure you want to delete # {0}?', $services->id), 'class'=>'btn btn-danger btn-xs']) ?>
                  </td>
              </tr>
              <?php endforeach; ?>
          </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card card-solid">
        <div class="card-header with-border">
          <i class="fa fa-share-alt"></i>
          <h3 class="card-title"><?= __('Users') ?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <?php if (!empty($serviceProvider->users)): ?>
          <table class="table table-hover">
              <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Email') ?></th>
                    <th scope="col"><?= __('Cpf') ?></th>
                    <th scope="col"><?= __('Phone') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
              <?php foreach ($serviceProvider->users as $users): ?>
              <tr>
                    <td><?= h($users->id) ?></td>
                    <td><?= h($users->name) ?></td>
                    <td><?= h($users->email) ?></td>
                    <td><?= h($users->cpf) ?></td>
                    <td><?= h($users->phone) ?></td>
                    <td><?= h($users->created) ?></td>
                    <td><?= h($users->modified) ?></td>
                      <td class="actions text-center">
                      <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id), 'class'=>'btn btn-danger btn-xs']) ?>
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
