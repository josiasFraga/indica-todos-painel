

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <?= $this->Html->link(__('Add New'), ['action' => 'add'], ['class' => 'btn btn-success float-right mb-2']) ?>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?php echo __('List'); ?></h3>

          <div class="card-tools">
            <form action="<?php echo $this->Url->build(); ?>" method="POST">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control pull-right" placeholder="<?php echo __('Search'); ?>">

                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('active_signature') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('signature_status') ?></th>
                  <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($serviceProviders as $serviceProvider): ?>
                <tr>
                  <td><?= $this->Number->format($serviceProvider->id) ?></td>
                  <td><?= h($serviceProvider->name) ?></td>
                  <td><?= h($serviceProvider->email) ?></td>
                  <td><?= h($serviceProvider->phone) ?></td>
                  <td><?= h($serviceProvider->city) ?></td>
                  <td><?= h($serviceProvider->state) ?></td>
                  <td><?= h($serviceProvider->created) ?></td>
                  <td><?= h($serviceProvider->modified) ?></td>
                  <td><?= h($serviceProvider->active_signature) ?></td>
                  <td>
                  <?php 
                  $signature_status = 'Ativa';
                  if ( $serviceProvider->signature_status == "CANCELLED" ) {
                    $signature_status = 'Cancelada';
                  } else if ( $serviceProvider->signature_status == "TRIAL" ) {
                    $signature_status = 'Período de Avaliação';                    
                  }
                  echo h($signature_status); 
                  ?></td>
                  <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $serviceProvider->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $serviceProvider->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $serviceProvider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $serviceProvider->id), 'class'=>'btn btn-danger btn-xs']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <div class="paginator">
              <ul class="pagination">
                  <?= $this->Paginator->first('<< ' . __('first')) ?>
                  <?= $this->Paginator->prev('< ' . __('previous')) ?>
                  <?= $this->Paginator->numbers() ?>
                  <?= $this->Paginator->next(__('next') . ' >') ?>
                  <?= $this->Paginator->last(__('last') . ' >>') ?>
              </ul>
              <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</section>