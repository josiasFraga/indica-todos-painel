<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ServiceProvider $serviceProvider
 */
?>
<!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header with-border">
            <h3 class="card-title"><?php echo __('Form'); ?></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <?php echo $this->Form->create($serviceProvider, ['role' => 'form']); ?>
            <div class="card-body">
              <?php
                echo $this->Form->control('name');
                echo $this->Form->control('email');
                echo $this->Form->control('phone');
                echo $this->Form->control('address');
                echo $this->Form->control('address_number');
                echo $this->Form->control('address_complement');
                echo $this->Localization->generateBasicLocation('col-md-6 col-xs-12', $serviceProvider->city, 'cities', false, 'select2bs4', $serviceProvider->state);
                echo $this->Form->control('postal_code');
                echo $this->Form->control('neighborhood');
                echo $this->Form->control('active_signature');
                echo $this->Form->control('signature_status', [
                  'type' => 'select',
                  'options' => [
                      null => 'Não Definido',
                      'ACTIVE' => 'Ativa',
                      'CANCELLED' => 'Cancelada'
                  ],
                  'empty' => '(Escolha uma opção)',  // Isso é opcional, mas é útil se você deseja adicionar um placeholder
                ]);
              ?>
            </div>
            <!-- /.card-body -->

          <?php echo $this->Form->submit(__('Submit')); ?>

          <?php echo $this->Form->end(); ?>
        </div>
        <!-- /.card -->
      </div>
  </div>
  <!-- /.row -->
</section>

