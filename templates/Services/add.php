<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Service $service
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
          <?php echo $this->Form->create($service, ['role' => 'form']); ?>
            <div class="card-body">
              <?php
                echo $this->Form->control('title', ['label' => 'Nome do Serviço']);
                echo $this->Form->control('description', ['label' => 'Descrição do Serviço']);
                echo $this->Form->control('category_id', ['options' => $serviceCategories]);
                echo $this->Form->control('subcategory_id', ['options' => $serviceSubcategories, 'label' => 'Subcategoria']);
                echo $this->Form->control('service_provider_id', ['options' => $serviceProviders, 'label' => 'Empresa']);
                echo $this->Form->control('price');
                echo $this->Form->control('price_unit');
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

