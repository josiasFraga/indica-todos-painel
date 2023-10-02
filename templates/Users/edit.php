<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
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
          <?php echo $this->Form->create($user, ['role' => 'form']); ?>
            <div class="card-body">
              <?php
                echo $this->Form->control('service_provider_id', ['options' => $serviceProviders, 'empty' => true]);
                echo $this->Form->control('name');
                echo $this->Form->control('email');
                echo $this->Form->control('cpf');
                echo $this->Form->control('password');
                echo $this->Form->control('phone');
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
