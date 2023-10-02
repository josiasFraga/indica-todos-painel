

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
            <dd><?= $this->Number->format($user->id) ?></dd>
            <dt scope="row"><?= __('Service Provider') ?></dt>
            <dd><?= $user->has('service_provider') ? $this->Html->link($user->service_provider->name, ['controller' => 'ServiceProviders', 'action' => 'view', $user->service_provider->id]) : '' ?></dd>
            <dt scope="row"><?= __('Name') ?></dt>
            <dd><?= h($user->name) ?></dd>
            <dt scope="row"><?= __('Email') ?></dt>
            <dd><?= h($user->email) ?></dd>
            <dt scope="row"><?= __('Cpf') ?></dt>
            <dd><?= h($user->cpf) ?></dd>
            <dt scope="row"><?= __('Phone') ?></dt>
            <dd><?= h($user->phone) ?></dd>
            <dt scope="row"><?= __('Created') ?></dt>
            <dd><?= h($user->created) ?></dd>
            <dt scope="row"><?= __('Modified') ?></dt>
            <dd><?= h($user->modified) ?></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>


</section>
